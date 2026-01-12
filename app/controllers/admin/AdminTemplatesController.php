<?php

class AdminTemplatesController extends AbstractAdminController {
    
    protected function init() {
        $this->setTitle('Szablony');
        return parent::init();
    }
    
    protected function preAction() {
        $this->requireProjectAccess($this->selectedProject, MemberModel::PROJECT_ACCESS_TEMPLATES);
    }
    
    protected function action_index() {
        $this->setSubTitle('Lista szablonów');
        
        $view = $this->getView();
        
        $templates = TemplateModel::fetchAll($this->selectedProject->id);
        
        $view->assign('templates', $templates);
        
        return $view->render('templates/index');
    }
    
    protected function action_add() {
        $this->setSubTitle('Dodaj nowy');
        
        $global_templates = GlobalTemplateModel::fetchAll();
        
        $view = $this->getView();
        $view->assign('global_templates', $global_templates);
        
        return $view->render('templates/add');
    }
    
    protected function action_add_post() {
        $this->requirePost();
        $this->onException('add');
        
        $name = Param::str($_POST, 'name');
        $global_template = Param::int($_POST, 'global_template');
        
        if (strlen($name) < 3) {
            throw new PublicException("Nazwa jest za krótka.");
        }
        
        if ($global_template == 0) {
            throw new PublicException("Wybrano nieodpowiedni szablon globalny.");
        }
        
        $global = new GlobalTemplateModel($global_template);
        
        if (!$global->id) {
            throw new PublicException("Wybrany szablon globalny nie istnieje.");
        }
        
        $template = new TemplateModel();
        $template->setName($name);
        $template->setProjectID($this->selectedProject->id);
        $template->setGlobalTemplateID($global_template);
        $template->save();
        
        new LogsModel($this->member->id, $this->selectedProject->id, 'templates', 'add');
        
        $this->redirect('templates', 'index', ['project' => $this->selectedProject->id]);
    }
    
    protected function action_preview() {
        $this->setSubTitle('Podgląd');
        
        $id = Param::int($this->getParams(), 'id');
        
        $template = new TemplateModel($id);
        
        if (!$template || $template->deleted == 1) {
            throw new PublicException("Wybrany szablon jest niedostępny");
        }
        
        $template_fields = TemplateFieldsModel::fetchAll($id);
        
        $view = $this->getView();
        
        $view->assign('template', $template);
        $view->assign('template_fields', $template_fields);
        
        return $view->render('templates/preview');
    }
    
    protected function action_edit() {
        $this->setSubTitle('Edytuj');
        
        $id = Param::int($this->getParams(), 'id');
        
        $template = new TemplateModel($id);
        
        if (!$template || $template->deleted == 1) {
            throw new PublicException("Wybrany szablon jest niedostępny");
        }
        
        $template_fields = TemplateFieldsModel::fetchAll($id);
        
        $view = $this->getView();
        
        $view->assign('fields', TemplateModel::$fields);
        $view->assign('template', $template);
        $view->assign('template_fields', $template_fields);
        
        return $view->render('templates/edit');
    }
    
    
    
    protected function action_edit_post() {
        $this->requirePost();
        $this->onException('index');
        
        $id = Param::int($this->getParams(), 'template_id');
        $idp = Param::int($_POST, 'template_id');
        $save = Param::int($_POST, 'save_changes', 0);
        $fields = Param::arr($_POST, 'field');
        
        if ($id != $idp) {
            throw new PublicException("Coś poszło nie tak... Wróć do poprzedniej strony i spróbuj ponownie");
        }
        
        $template = new TemplateModel($id);
        
        foreach ($fields as $fid => $field) {
            $f = new TemplateFieldsModel($fid);
            
            if (!$f) {
                continue;
            }
            
            // name
            if (strlen($field['name']) > 3 && strlen($field['name']) < 255 && $field['name'] != $f->name) {
                $f->setName($field['name']);
            }
            
            // position
            if ($field['position'] <= $template->parts && $field['position'] >= 1 && $field['position'] != $f->position) {
                $f->setPosition($field['position']);
            }
            
            // options
            if ($field['options'] && implode("|", $field['options']) != $f->position) {
                $f->setOptions(implode("|", $field['options']));
            }
            
            // required
            if (isset($field['required'])) {
                $f->setRequired(1);
            }
            else {
                $f->setRequired(0);
            }
            
            // defaults
            if (isset($field['defaults']) && $field['defaults'] != $f->defaults) {
                $f->setDefaults($field['defaults']);
            }
            
            // sort
            if ($field['sort'] >= 0 && $field['sort'] != $f->sort) {
                $f->setSort($field['sort']);
            }
            
            $f->save();
        }
        
        new LogsModel($this->member->id, $this->selectedProject->id, 'templates', 'field_edit_all');
        
        $this->redirect('templates', 'edit', ['id' => $id, 'project' => $this->selectedProject->id]);
    }
    
    protected function action_field_add_post() {
        $this->requirePost();
        $this->onException('index');
        
        $id = Param::int($this->getParams(), 'template_id');
        $idp = Param::int($_POST, 'id');
        $name = Param::str($_POST, 'name');
        $position = Param::int($_POST, 'position', 1);
        $type = Param::str($_POST, 'type');
        
        if ($id != $idp) {
            throw new PublicException("Coś poszło nie tak... Wróć do poprzedniej strony i spróbuj ponownie");
        }
        
        if (strlen($name) < 3) {
            throw new PublicException("Wprowadzona nazwa pola jest za krótka");
        }
        
        if (strlen($name) > 255) {
            throw new PublicException("Wprowadzona nazwa pola jest za długa");
        }
        
        $template = new TemplateModel($id);
        
        if ($position > $template->parts || $position < 1) {
            throw new PublicException("Wybrana pozycja nie spełnia wymagań szablonu");
        }
        
        if (!array_key_exists($type, TemplateModel::$fields)) {
            throw new PublicException("Wybrany typ pola nie jest wspierany");
        }
        
        $field = new TemplateFieldsModel();
        $field->setTemplateID($id);
        $field->setName($name);
        $field->setPosition($position);
        $field->setType($type);
        $field->save();
        
        new LogsModel($this->member->id, $this->selectedProject->id, 'templates', 'field_add');
        
        $this->redirect('templates', 'edit', ['id' => $id, 'project' => $this->selectedProject->id]);
    }
    
    protected function action_field_delete() {
        $this->setSubTitle('Usuń pole');
        
        $id = Param::int($this->getParams(), 'field_id');
        
        $field = new TemplateFieldsModel($id);
        
        if (!$field || $field->deleted == 1) {
            throw new PublicException("Wybrane pole jest niedostępne");
        }
        
        $view = $this->getView();
        
        $view->assign('field', $field);
        
        return $view->render('templates/field_delete');
    }
    
    protected function action_field_delete_post() {
        $this->requirePost();
        $this->onException('field_delete');
        
        $id = Param::int($this->getParams(), 'field_id');
        $idp = Param::int($_POST, 'field_id');
        
        if ($id != $idp) {
            throw new PublicException("Coś poszło nie tak... Wróć do poprzedniej strony i spróbuj ponownie");
        }
        
        $field = new TemplateFieldsModel($id);
        
        $field->delete();
        
        new LogsModel($this->member->id, $this->selectedProject->id, 'templates', 'field_delete');
        
        $this->redirect('templates', 'index', ['project' => $this->selectedProject->id]);
    }
    
    protected function action_delete() {
        $this->setSubTitle('Usuń');
        
        $id = Param::int($this->getParams(), 'id');
        
        $template = new TemplateModel($id);
        
        if (!$template || $template->deleted == 1) {
            throw new PublicException("Wybrany szablon jest niedostępny");
        }
        
        $view = $this->getView();
        
        $view->assign('template', $template);
        
        return $view->render('templates/delete');
    }
    
    protected function action_delete_post() {
        $this->requirePost();
        $this->onException('delete');
        
        $id = Param::int($this->getParams(), 'id');
        $idp = Param::int($_POST, 'id');
        
        if ($id != $idp) {
            throw new PublicException("Coś poszło nie tak... Wróć do poprzedniej strony i spróbuj ponownie");
        }
        
        $template = new TemplateModel($id);
        
        $template->delete();
        
        new LogsModel($this->member->id, $this->selectedProject->id, 'templates', 'delete');
        
        $this->redirect('templates', 'index', ['project' => $this->selectedProject->id]);
    }
    
}