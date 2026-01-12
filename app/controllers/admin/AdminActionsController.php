<?php

class AdminActionsController extends AbstractAdminController {

	protected function init() {
		$this->setTitle('Akcje');
		
		return parent::init();
	}
	
	protected function preAction() {
	    $this->requireProjectAccess($this->selectedProject, MemberModel::PROJECT_ACCESS_ACTIONS);
	}
	
	protected function action_index() {
	    $this->setSubTitle('Lista akcji');
	    $view = $this->getView();
	    
	    $view->assign('actions', ActionModel::fetchAll($this->selectedProject->id));
	    return $view->render('actions/index');
	}
	
	protected function action_add() {
	    $this->setSubTitle('Dodaj nową');
	    
	    $templates = TemplateModel::fetchAll($this->selectedProject->id);
	    
	    $view = $this->getView();
	    
	    $view->assign('templates', $templates);
	    $view->assign('post', $_POST);
	    
	    return $view->render('actions/add');
	}
	
	protected function action_add_post() {
	    $this->requirePost();
	    $this->onException('add');
	    
	    $name = Param::str($_POST, 'name');
	    $description_short = Param::str($_POST, 'description_short');
	    $description_long = Param::str($_POST, 'description_long');
	    $template_id = Param::int($_POST, 'template_id');
	    $startd = Param::str($_POST, 'start_date');
	    $startt = Param::str($_POST, 'start_time');
	    $endd = Param::str($_POST, 'end_date');
	    $endt = Param::str($_POST, 'end_time');
	    
	    $start = strtotime($startd. ' '.$startt);
	    $end = strtotime($endd. ' '.$endt);
	    
	    if (strlen($name) < 3) {
	        throw new PublicException("Nazwa jest za krótka.");
	    }
	    
	    if ($template_id == 0) {
	        throw new PublicException("Wybrano nieodpowiedni szablon globalny.");
	    }
	    
	    $template = new TemplateModel($template_id);
	    
	    if (!isset($template->id)) {
	        throw new PublicException("Wybrany szablon nie istnieje.");
	    }
	    
	    if ($start >= $end) {
	        throw new PublicException("Akcja nie może rozpoczynać się w momencie zakończenia lub po terminie zakończenia");
	    }
	    
	    if (strlen($description_short) < 50) {
	        throw new PublicException("Krótki opis jest za krótki");
	    }
	    
	    
	    if (strlen($description_long) < 100) {
	        throw new PublicException("Długi opis jest za krótki");
	    }
	    
	    if(count($_FILES) != 1) {
	        throw new PublicException("Nie wybrano żadnego pliku do dodania lub wybrano więcej niż jeden plik");
	    }
	    
	    // File
	    if($_FILES['logo']['size'] > 2097152) { // 2MB
	        throw new PublicException('Plik, który chcesz dodać jest za duży.');
	    }
	    
	    $available_extensions = ['gif', 'png', 'jpeg', 'bmp'];
	    $available_extensions_mime = [
	        'image/gif',
	        'image/png',
	        'image/jpeg',
	        'image/x-ms-bmp'
	    ];
	    
	    if(!in_array($_FILES['logo']['type'], $available_extensions_mime)) {
	        throw new PublicException("Plik, który chcesz dodać ma nieodpowiednie rozszerzenie.");
	    }
	    
	    $logo = file_get_contents($_FILES['logo']['tmp_name']);
	    $logo_type = $_FILES['logo']['type'];
	    
	    $action = new ActionModel();
	    $action->setName($name);
	    $action->setDescriptionShort($description_short);
	    $action->setDescriptionLong($description_long);
	    $action->setProjectID($this->selectedProject->id);
	    $action->setLogo($logo);
	    $action->setLogoType($logo_type);
	    $action->setTemplateID($template_id);
	    $action->setStart($start);
	    $action->setEnd($end);
	    $action->save();
	    
	    new LogsModel($this->member->id, $this->selectedProject->id, 'action', 'add');
	    
	    $this->redirect('actions', 'index', ['project' => $this->selectedProject->id]);
	}
	
	protected function action_edit() {
	    $this->setSubTitle('Edytuj');
	    
	    $id = Param::int($this->getParams(), 'id');
	    
	    $action = new ActionModel($id);
	    
	    if (!$action) {
	        throw new PublicException("Wybrana akcja nie istnieje");
	    }
	    
	    $templates = TemplateModel::fetchAll($this->selectedProject->id);
	    
	    $view = $this->getView();
	    $view->assign('templates', $templates);
	    $view->assign('action', $action);
	    $view->assign('post', $_POST);
	    
	    return $view->render('actions/edit');
	}
	
	protected function action_edit_post() {
	    $this->requirePost();
	    $this->onException('edit');
	    
	    $id = Param::int($this->getParams(), 'id');
	    $idp = Param::int($_POST, 'id');
	    
	    $action = new ActionModel($idp);
	    
	    if (!$action) {
	        throw new PublicException("Wybrana akcja nie istnieje");
	    }
	    
	    $name = Param::str($_POST, 'name');
	    $description_short = Param::str($_POST, 'description_short');
	    $description_long = Param::str($_POST, 'description_long');
	    $template_id = Param::int($_POST, 'template_id');
	    $startd = Param::str($_POST, 'start_date');
	    $startt = Param::str($_POST, 'start_time');
	    $endd = Param::str($_POST, 'end_date');
	    $endt = Param::str($_POST, 'end_time');
	    
	    $start = strtotime($startd. ' '.$startt);
	    $end = strtotime($endd. ' '.$endt);
	    
	    if ($id != $idp) {
	        throw new PublicException("Coś poszło nie tak... Wróć do poprzedniej strony i spróbuj ponownie");
	    }
	    
	    if (strlen($name) < 3) {
	        throw new PublicException("Nazwa jest za krótka");
	    }
	    
	    if (strlen($name) < 3) {
	        throw new PublicException("Nazwa jest za krótka.");
	    }
	    
	    if ($template_id == 0) {
	        throw new PublicException("Wybrano nieodpowiedni szablon globalny.");
	    }
	    
	    $template = new TemplateModel($template_id);
	    
	    if (!isset($template->id)) {
	        throw new PublicException("Wybrany szablon nie istnieje.");
	    }
	    
	    if ($start >= $end) {
	        throw new PublicException("Akcja nie może rozpoczynać się w momencie zakończenia lub po terminie zakończenia");
	    }
	    
	    if (strlen($description_short) < 50) {
	        throw new PublicException("Krótki opis jest za krótki");
	    }
	    
	    
	    if (strlen($description_long) < 100) {
	        throw new PublicException("Długi opis jest za krótki");
	    }
	    
	    if($_FILES['logo']['error'] == 0) {
	       
    	    // File
	        if((int) $_FILES['logo']['size'] >= 2097152) { // 6MB
	            throw new PublicException('Plik, który chcesz dodać jest za duży.');
    	    }
    	    
    	    $available_extensions = ['gif', 'png', 'jpeg', 'bmp'];
    	    $available_extensions_mime = [
    	        'image/gif',
    	        'image/png',
    	        'image/jpeg',
    	        'image/x-ms-bmp'
    	    ];
    	    
    	    if(!in_array($_FILES['logo']['type'], $available_extensions_mime)) {
    	        throw new PublicException("Plik, który chcesz dodać ma nieodpowiednie rozszerzenie.");
    	    }
    	    
    	    $logo = file_get_contents($_FILES['logo']['tmp_name']);
    	    $logo_type = $_FILES['logo']['type'];
    	    
    	    $action->setLogo($logo);
    	    $action->setLogoType($logo_type);
	    }
	    
	    $action->setName($name);
	    $action->setDescriptionShort($description_short);
	    $action->setDescriptionLong($description_long);
	    $action->setTemplateID($template_id);
	    $action->setStart($start);
	    $action->setEnd($end);
	    $action->save();
	    
	    new LogsModel($this->member->id, $this->selectedProject->id, 'action', 'edit');
	    
	    $this->redirect('actions', 'index', ['project' => $this->selectedProject->id]);
	}
	
	protected function action_publish() {
	    $this->setSubTitle('Opublikuj');
	    
	    $id = Param::int($this->getParams(), 'id');
	    
	    $action = new ActionModel($id);
	    
	    if (!$action) {
	        throw new PublicException("Wybrana akcja nie istnieje");
	    }
	    
	    $view = $this->getView();
	    
	    $view->assign('action', $action);
	    
	    return $view->render('actions/publish-hide');
	}
	
	protected function action_hide() {
	    $this->setSubTitle('Ukryj');
	    
	    $id = Param::int($this->getParams(), 'id');
	    
	    $action = new ActionModel($id);
	    
	    if (!$action) {
	        throw new PublicException("Wybrana akcja nie istnieje");
	    }
	    
	    $view = $this->getView();
	    
	    $view->assign('action', $action);
	    
	    return $view->render('actions/publish-hide');
	}
	
	protected function action_publish_post() {
	    $this->requirePost();
	    $this->onException('index');
	    
	    $id = Param::int($this->getParams(), 'id');
	    $idp = Param::int($_POST, 'id');
	    $status = Param::int($_POST, 'status');
	    
	    if ($id != $idp) {
	        throw new PublicException("Coś poszło nie tak... Wróć do poprzedniej strony i spróbuj ponownie");
	    }
	    
	    $action = new ActionModel($id);
	    $action->setStatus($status);
	    $action->save();
	    
	    new LogsModel($this->member->id, $this->selectedProject->id, 'actions', 'publish-hide');
	    
	    $this->redirect('actions', 'index', ['project' => $this->selectedProject->id]);
	}
	
	protected function action_delete() {
	    $this->setSubTitle('Usuń');
	    
	    $id = Param::int($this->getParams(), 'id');
	    
	    $action = new ActionModel($id);
	    
	    if (!$action) {
	        throw new PublicException("Wybrana akcja nie istnieje");
	    }
	    
	    $view = $this->getView();
	    
	    $view->assign('action', $action);
	    
	    return $view->render('actions/delete');
	}
	
	protected function action_delete_post() {
	    $this->requirePost();
	    $this->onException('delete');
	    
	    $id = Param::int($this->getParams(), 'id');
	    $idp = Param::int($_POST, 'id');
	    
	    if ($id != $idp) {
	        throw new PublicException("Coś poszło nie tak... Wróć do poprzedniej strony i spróbuj ponownie");
	    }
	    
	    $action = new ActionModel($id);
	    
	    $action->delete();
	    
	    new LogsModel($this->member->id, $this->selectedProject->id, 'actions', 'delete');
	    
	    $this->redirect('actions', 'index', ['project' => $this->selectedProject->id]);
	}
}