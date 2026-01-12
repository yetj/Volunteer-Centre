<?php

class AdminGlobalTemplatesController extends AbstractAdminController {

	protected function init() {
		$this->setTitle('Szablony globalne');
		
		
		
		return parent::init();
	}
	
	protected function preAction() {
	    $this->requireAdminAccess(MemberModel::ADMIN_ACCESS_TEMPLATES);
	}

	protected function action_index() {
		$this->setSubTitle('Lista');
		
		$templates = GlobalTemplateModel::fetchAll();
		
		$view = $this->getView();
		
		$view->assign('templates', $templates);
		
		return $view->render('global_templates/index');
	}
	
	protected function action_add() {
	    $this->setSubTitle('Dodaj nowy szablon');
	    
	    $view = $this->getView();
	    return $view->render('global_templates/add');
	}
	
	protected function action_add_post() {
	    $this->requirePost();
	    $this->onException('show');
	    
	    $name = Param::str($_POST, 'name');
	    $parts = Param::int($_POST, 'parts');
	    $html = Param::str($_POST, 'html');
	    
	    if (strlen($name) < 3) {
	        throw new PublicException("Nazwa jest za krótka.");
	    }
	    
	    if ($parts < 1) {
	        throw new PublicException("Szablon nie może zawierać mniej niż 1 pola");
	    }
	    
	    if(count($_FILES) != 1) {
	        throw new PublicException("Nie wybrano żadnego pliku do dodania lub wybrano więcej niż jeden plik");
	    }
	    
	    // File
	    if($_FILES['img']['size'] > 2097152) { // 2MB
	       throw new PublicException('Plik, który chcesz dodać jest za duży.');
	    }
	    
	    $available_extensions = ['gif', 'png', 'jpeg', 'bmp'];
	    $available_extensions_mime = [
	        'image/gif',
	        'image/png',
	        'image/jpeg',
	        'image/x-ms-bmp'
	    ];
	    
	    if(!in_array($_FILES['img']['type'], $available_extensions_mime)) {
	       throw new PublicException("Plik, który chcesz dodać ma nieodpowiednie rozszerzenie.");
	    }
	    
	    $image = file_get_contents($_FILES['img']['tmp_name']);
	    $image_type = $_FILES['img']['type'];
	    
	    $template = new GlobalTemplateModel();
	    $template->setName($name);
	    $template->setImg($image);
	    $template->setImgType($image_type);
	    $template->setParts($parts);
	    $template->setHtml($html);
	    $template->save();
	    
	    new LogsModel($this->member->id, $this->selectedProject->id, 'global_templates', 'add');
	    
	    $this->redirect('global_templates', 'index');
	}
	
	protected function action_edit() {
	    $this->setSubTitle('Edytuj');
	    
	    $id = Param::int($this->getParams(), 'id');
	    
	    $template = new GlobalTemplateModel($id);
	    
	    if (!$template || $template->deleted == 1) {
	        throw new PublicException("Wybrany szablon jest niedostępny");
	    }
	    
	    $view = $this->getView();
	    
	    $view->assign('template', $template);
	    
	    return $view->render('global_templates/edit');
	}
	
	protected function action_edit_post() {
	    $this->requirePost();
	    $this->onException('show');
	    
	    $id = Param::int($this->getParams(), 'id');
	    $idp = Param::int($_POST, 'id');
	    $name = Param::str($_POST, 'name');
	    $parts = Param::int($_POST, 'parts');
	    $html = Param::str($_POST, 'html');
	    
	    if ($id != $idp) {
	        throw new PublicException("Coś poszło nie tak... Wróć do poprzedniej strony i spróbuj ponownie");
	    }
	    
	    if (strlen($name) < 3) {
	        throw new PublicException("Nazwa jest za krótka.");
	    }
	    
	    if ($parts < 1) {
	        throw new PublicException("Szablon nie może zawierać mniej niż 1 pola");
	    }
	    
	    $template = new GlobalTemplateModel($id);
	    
	    
	    if($_FILES['img']['size'] > 0) {
    	    if(count($_FILES) != 1) {
    	        throw new PublicException("Nie wybrano żadnego pliku do dodania lub wybrano więcej niż jeden plik");
    	    }
    	    
    	    // File
    	    if($_FILES['img']['size'] > 2097152) { // 2MB
    	        throw new PublicException('Plik, który chcesz dodać jest za duży.');
    	    }
    	    
    	    $available_extensions = ['gif', 'png', 'jpeg', 'bmp'];
    	    $available_extensions_mime = [
    	        'image/gif',
    	        'image/png',
    	        'image/jpeg',
    	        'image/x-ms-bmp'
    	    ];
    	    
    	    if(!in_array($_FILES['img']['type'], $available_extensions_mime)) {
    	        throw new PublicException("Plik, który chcesz dodać ma nieodpowiednie rozszerzenie.");
    	    }
    	    
    	    $image = file_get_contents($_FILES['img']['tmp_name']);
    	    $image_type = $_FILES['img']['type'];
    	    $template->setImg($image);
    	    $template->setImgType($image_type);
	    }
	    
	    if ($template->name != $name) {
	        $template->setName($name);
	    }
	    
	    if ($template->parts != $parts) {
    	    $template->setParts($parts);
	    }
	    
	    if ($template->html != $html) {
	        $template->setHtml($html);
	    }
	    
	    $template->save();
	    
	    new LogsModel($this->member->id, $this->selectedProject->id, 'global_templates', 'update');
	    
	    $this->redirect('global_templates', 'index');
	}
	
	protected function action_delete() {
	    $this->setSubTitle('Usuń');
	    
	    $id = Param::int($this->getParams(), 'id');
	    
	    $template = new GlobalTemplateModel($id);
	    
	    if (!$template || $template->deleted == 1) {
	        throw new PublicException("Wybrany szablon jest niedostępny");
	    }
	    
	    $view = $this->getView();
	    
	    $view->assign('template', $template);
	    
	    return $view->render('global_templates/delete');
	}
	
	protected function action_delete_post() {
	    
	    $this->requirePost();
	    $this->onException('show');
	    
	    $id = Param::int($this->getParams(), 'id');
	    $idp = Param::int($_POST, 'id');
	    
	    if ($id != $idp) {
	        throw new PublicException("Coś poszło nie tak... Wróć do poprzedniej strony i spróbuj ponownie");
	    }
	    
	    $template = new GlobalTemplateModel($id);
	    
	    $template->delete();
	    
	    new LogsModel($this->member->id, $this->selectedProject->id, 'global_templates', 'delete');
	    
	    $this->redirect('global_templates', 'index');
	}
}