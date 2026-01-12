<?php

class AdminUsersController extends AbstractAdminController {

	protected function init() {
		$this->setTitle('Użytkownicy');
		return parent::init();
	}
	
	protected function preAction() {
	    $this->requireProjectAccess($this->selectedProject, MemberModel::PROJECT_ACCESS_USERS);
	}

	protected function action_index() {
		$view = $this->getView();
		
		$members = MemberModel::getAllByProject($this->selectedProject->id);
				
		$view->assign('members', $members);
		$view->assign('member_count', sizeof($members));
		
		return $view->render('users/index');
	}
	
	protected function action_add() {
	    $this->setTitle('Użytkownicy - dodaj nowego');
	    $view = $this->getView();
	    
	    $view->assign('post', $_POST);
	    
	    return $view->render('users/add');
	}
	
	protected function action_add_post() {
	    $this->requirePost();
	    $this->onException('add');
	    
	    $email = Param::str($_POST, 'email');
	    $password = Param::str($_POST, 'password');
	    $password2 = Param::str($_POST, 'password2');
	    
	    $project = $this->selectedProject->id;
	    
	    $rights = Param::arr($_POST, 'access');
	    
	    $access = 0;
	    
	    if (sizeof($rights)) {
    	    foreach ($rights as $right) {
    	        $access += $right;
    	    }
	    }
	    
	    
	    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	        throw new PublicException("Podany email jest niepoprawny.");
	    }
	    
	    if ($password != $password2) {
	        throw new PublicException("Wprowadzone hasła nie są takie same.");
	    }
	    
	    if ($existingUser = MemberModel::getByEmail($email)) {
            	        
	        $existingMember = ProjectModel::getByUser($existingUser->id, true);
	        
	        if (!isset($existingMember[$project])) {
	            ProjectModel::addAccess($project, $existingUser->id);
	        }
	        else {
	            throw new PublicException("Znaleziono już konto o takim adresie email w Twoim projekcie.");
	        }
	        
	        ProjectModel::setAccess($project, $existingUser->id, $access);
	        
	        $this->redirect('users', 'index');
	        return true;;
	    }
	    
	    $member = new MemberModel();
	    $member->setEmail($email);
	    $member->setPassword($password);
	    $member->setAccess(0);
	    $memberId = $member->save();
	    
	    ProjectModel::addAccess($project, $memberId);
	    ProjectModel::setAccess($project, $memberId, $access);
	    
	    new LogsModel($this->member->id, $this->selectedProject->id, 'users', 'add');
	    
	    $this->redirect('users', 'index', ['project' => $project]);
	}
	
	
	protected function action_edit() {
	    $this->setTitle('Użytkownicy - edycja');
	    $view = $this->getView();
	    
	    $id = Param::int($this->getParams(), 'id');
	    $project = Param::int($this->getParams(), 'project');
	    
	    $member = new MemberModel($id);
	    
	    if (!$member) {
	        throw new PublicException("Wybrany użytkownik nie istnieje");
	    }
	    
	    $access = [];
	    if(isset($post['access'])) {
	        if (in_array(MemberModel::PROJECT_ACCESS_USERS, $post['access'])) {
	            $access[1] = true;
	        }
	        if (in_array(MemberModel::PROJECT_ACCESS_PAGES, $post['access'])) {
	            $access[2] = true;
	        }
	        if (in_array(MemberModel::PROJECT_ACCESS_TEMPLATES, $post['access'])) {
	            $access[3] = true;
	        }
	        if (in_array(MemberModel::PROJECT_ACCESS_ACTIONS, $post['access'])) {
	            $access[4] = true;
	        }
	        if (in_array(MemberModel::PROJECT_ACCESS_APPLICATIONS, $post['access'])) {
	            $access[5] = true;
	        }
	        if (in_array(MemberModel::PROJECT_ACCESS_SETTINGS, $post['access'])) {
	            $access[6] = true;
	        }
	        if (in_array(MemberModel::PROJECT_ACCESS_LOGS, $post['access'])) {
	            $access[7] = true;
	        }
	    }
	    
	    $accessProject = ProjectModel::getAccess($project, $id);
	    
	    $access[1] = $accessProject->access & MemberModel::PROJECT_ACCESS_USERS ? true : false;
	    $access[2] = $accessProject->access & MemberModel::PROJECT_ACCESS_PAGES ? true : false;
	    $access[3] = $accessProject->access & MemberModel::PROJECT_ACCESS_TEMPLATES ? true : false;
	    $access[4] = $accessProject->access & MemberModel::PROJECT_ACCESS_ACTIONS ? true : false;
	    $access[5] = $accessProject->access & MemberModel::PROJECT_ACCESS_APPLICATIONS ? true : false;
	    $access[6] = $accessProject->access & MemberModel::PROJECT_ACCESS_SETTINGS ? true : false;
	    $access[7] = $accessProject->access & MemberModel::PROJECT_ACCESS_LOGS ? true : false;
	    
	    $view->assign('member', $member);
	    $view->assign('access', $access);
	    $view->assign('project', $project);
	    $view->assign('post', $_POST);
	    
	    return $view->render('users/edit');
	}
	
	protected function action_edit_post() {
	    $this->requirePost();
	    $this->onException('edit');
	    
	    $id = Param::int($this->getParams(), 'id');
	    $idp = Param::int($_POST, 'id');
	    
	    $member = new MemberModel($id);
	    
	    if ($id != $idp) {
	        throw new PublicException("Coś poszło nie tak... Wróć do poprzedniej strony i spróbuj ponownie");
	    }
	    
	    $password = Param::str($_POST, 'password');
	    $password2 = Param::str($_POST, 'password2');
	    
	    $rights = Param::arr($_POST, 'access');
	    
	    $accessProject = ProjectModel::getAccess($this->selectedProject->id, $member->id);
	    
	    $access = 0;
	    
	    if (sizeof($rights)) {
	        foreach ($rights as $right) {
	            $access += $right;
	        }
	    }
	    
	    if ($password != $password2) {
	        throw new PublicException("Wprowadzone hasła nie są takie same.");
	    }
	    
	    if ($access != $accessProject->access) {
	        ProjectModel::setAccess($this->selectedProject->id, $member->id, $access);
	    }
	    
	    if (strlen($password)) {
	        $member->setPassword($login);
	        $member->changePassword();
	    }
	    $member->save();
	    
	    new LogsModel($this->member->id, $this->selectedProject->id, 'users', 'update');
	    
	    $this->redirect('users', 'index', ['project' => $this->selectedProject->id]);   
	}
	
	protected function action_delete() {
	    $this->setSubTitle('Usuń');
	    
	    $id = Param::int($this->getParams(), 'id');
	    
	    $member = new MemberModel($id);
	    
	    if (!$member) {
	        throw new PublicException("Wybrana użytkownik nie istnieje.");
	    }
	    
	    $view = $this->getView();
	    
	    $view->assign('member', $member);
	    
	    return $view->render('users/delete');
	}
	
	protected function action_delete_post() {
	    $this->requirePost();
	    $this->onException('delete');
	    
	    $id = Param::int($this->getParams(), 'id');
	    $idp = Param::int($_POST, 'id');
	    
	    if ($id != $idp) {
	        throw new PublicException("Coś poszło nie tak... Wróć do poprzedniej strony i spróbuj ponownie");
	    }
	    	    
	    $member = new MemberModel($id);
	    
	    ProjectModel::removeAccess($this->selectedProject->id, $member->id);
	    
	    new LogsModel($this->member->id, $this->selectedProject->id, 'users', 'delete');
	    
	    $this->redirect('users', 'index', ['project' => $this->selectedProject->id]);
	}
}