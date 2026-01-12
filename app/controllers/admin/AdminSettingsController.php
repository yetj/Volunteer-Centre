<?php

class AdminSettingsController extends AbstractAdminController {
    
    protected function init() {
        $this->setTitle('Ustawienia');
        return parent::init();
    }
    
    protected function preAction() {
        $this->requireProjectAccess($this->selectedProject, MemberModel::PROJECT_ACCESS_SETTINGS);
    }
    
    protected function action_index() {
        $this->setSubTitle('Ustawienia');
        
        $view = $this->getView();
        
        $project = new ProjectModel($this->selectedProject->id);
        
        $settings = [];
        
        try {
            $settings = json_decode($project->settings);
        } catch (Exception $e) {
            
        }
        
        $view->assign('project', $project);
        $view->assign('settings', $settings);
        
        return $view->render('settings/index');
    }
    
    protected function action_save() {
        $this->requirePost();
        $this->onException('index');
        
        $id = Param::int($this->getParams(), 'id');
        $idp = Param::int($_POST, 'id');
        
        $project = new ProjectModel($id);
        
        $name = Param::str($_POST, 'name');
        $status = Param::int($_POST, 'status');
        
        if ($id != $idp) {
            throw new PublicException("Coś poszło nie tak... Wróć do poprzedniej strony i spróbuj ponownie");
        }
        
        if (strlen($name) < 3) {
            throw new PublicException("Nazwa jest za krótka");
        }
        $project->setName($name);
        
        if ($project->slug != "global") {
            $slug = Param::str($_POST, 'slug');
            
            if ($slug != $project->slug && ProjectModel::getOne($slug)) {
                throw new PublicException("Wprowadzony slug nie jest unikalny");
            }
            $project->setSlug($slug);
            
            if ($project->status != 2) {
                $project->setStatus($status);
            }
        }
        
        $project->save();
        
        new LogsModel($this->member->id, $this->selectedProject->id, 'settings', 'save');
        
        $this->redirect('settings', 'index', ['project' => $this->selectedProject->id]);
    }
    
}