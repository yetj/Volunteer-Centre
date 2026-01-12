<?php

class AdminProjectsController extends AbstractAdminController {

	protected function init() {
		$this->setTitle('Projekty');
		return parent::init();
	}
	
	protected function preAction() {
	    $this->requireAdminAccess(MemberModel::ADMIN_ACCESS_PROJECTS);
	}

	protected function action_index() {
		$this->setSubTitle('Lista projektów');
		
		$view = $this->getView();
		
		$projects = ProjectModel::getAll();
		$waiting = ProjectRequestModel::getWaitingCount();
		
		$view->assign('waiting', $waiting);
		$view->assign('projects', $projects);
		
		return $view->render('projects/index');
	}
	
	protected function action_add() {
	    $this->setSubTitle('Dodaj nowy');
	    
	    $members = MemberModel::getAll();
	    
	    $view = $this->getView();
	    $view->assign('members', $members);
	    
	    return $view->render('projects/add');
	}
	
	protected function action_add_post() {
	    $this->requirePost();
	    $this->onException('add');
	    
	    $name = Param::str($_POST, 'name');
	    $slug = Param::str($_POST, 'slug');
	    $status = Param::int($_POST, 'status');
	    $owner_id = Param::int($_POST, 'owner');
	    
	    if (strlen($name) < 3) {
	        throw new PublicException("Nazwa jest za krótka.");
	    }
	    
	    $member = new MemberModel($owner_id);
	    
	    if (!$member) {
	        throw new PublicException("Wybrany użytkownik nie istnieje");
	    }
	    
	    if (ProjectModel::getOne($slug)) {
	        throw new PublicException("Wprowadzony slug nie jest unikalny");
	    }
	    
	    $project = new ProjectModel();
	    $project->setName($name);
	    $project->setSlug($slug);
	    $project->setStatus($status);
	    $project->setOwner_id($owner_id);
	    $project->save();
	    
	    new LogsModel($this->member->id, $this->selectedProject->id, 'projects', 'add');
	    
	    $this->redirect('projects', 'index');
	}
	
	protected function action_edit() {
	    $this->setSubTitle('Edycja');
	    
	    $id = Param::int($this->getParams(), 'id');
	    
	    $project = new ProjectModel($id);
	    
	    if (!$project) {
	        throw new PublicException("Wybrany projekt nie istnieje");
	    }
	    
	    $members = MemberModel::getAll();
	    
	    $view = $this->getView();
	    
	    $view->assign('members', $members);
	    $view->assign('project', $project);
	    
	    return $view->render('projects/edit');
	}
	
	protected function action_edit_post() {
	    $this->requirePost();
	    $this->onException('edit');
	    
	    $id = Param::int($this->getParams(), 'id');
	    $idp = Param::int($_POST, 'id');
	    
	    $project = new ProjectModel($id);
	    
	    $name = Param::str($_POST, 'name');
	    $owner_id = Param::int($_POST, 'owner');
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
	        
	        $member = new MemberModel($owner_id);
	        
	        if (!$member) {
	            throw new PublicException("Wybrany użytkownik nie istnieje");
	        }
	        
	        $project->setOwner_id($owner_id);
	        $project->setStatus($status);
	    }
	    
	    $project->save();
	    
	    new LogsModel($this->member->id, $this->selectedProject->id, 'projects', 'update');
	    
	    $this->redirect('projects', 'index');
	}
	
	protected function action_delete() {
	    $this->setSubTitle('Usuń');
	    
	    $id = Param::int($this->getParams(), 'id');
	    
	    $project = new ProjectModel($id);
	    
	    if (!$project) {
	        throw new PublicException("Wybrany projekt jest niedostępny");
	    }
	    
	    $view = $this->getView();
	    
	    $view->assign('project', $project);
	    
	    return $view->render('projects/delete');
	}
	
	protected function action_delete_post() {
	    $this->requirePost();
	    $this->onException('delete');
	    
	    $id = Param::int($this->getParams(), 'id');
	    $idp = Param::int($_POST, 'id');
	    
	    if ($id != $idp) {
	        throw new PublicException("Coś poszło nie tak... Wróć do poprzedniej strony i spróbuj ponownie");
	    }
	    
	    $project = new ProjectModel($id);
	    
	    $project->delete();
	    
	    new LogsModel($this->member->id, $this->selectedProject->id, 'projects', 'delete');
	    
	    $this->redirect('projects', 'index');
	}
	
	protected function action_waiting() {
	    $this->setSubTitle('Lista zgłoszonych projektów');
	    
	    $view = $this->getView();
	    
	    $projects = ProjectRequestModel::getall();
	    
	    $view->assign('projects', $projects);
	    
	    return $view->render('projects/waiting');
	}
	
	protected function action_show() {
	    $this->setSubTitle('Podgląd zgłoszenia');
	    
	    $id = Param::int($this->getParams(), 'id');
	    
	    if ($this->isPost()) {
	        $idp = Param::int($_POST, 'id');
	        $status = Param::int($_POST, 'status');
	        
	        if ($id != $idp) {
	            throw new PublicException("Coś poszło nie tak... Wróć do poprzedniej strony i spróbuj ponownie");
	        }
	        
	        $projectRequest = new ProjectRequestModel($id);
	        $projectRequest->setStatus($status);
	        $projectRequest->save();
	        
	        $this->redirect('projects', 'waiting');
	        return;
	    }
	    
	    $project = new ProjectRequestModel($id);
	    
	    $view = $this->getView();
	    
	    $view->assign('project', $project);
	    
	    return $view->render('projects/show');
	}
	
}