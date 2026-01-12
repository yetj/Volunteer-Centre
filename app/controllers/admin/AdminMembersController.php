<?php

class AdminMembersController extends AbstractAdminController {

	protected function init() {
		$this->setTitle('Użytkownicy');
		return parent::init();
	}
	
	protected function preAction() {
	    $this->requireAdminAccess(MemberModel::ADMIN_ACCESS_MEMEBERS);
	}

	protected function action_index() {
		$view = $this->getView();
		
		$members = MemberModel::getAll();
		
		$page = Param::int($this->getParams(), 'page', 1);
		
		$pageConfig = Helper::setPage($page, 10, sizeof($members));
		
		$members = MemberModel::getAll($pageConfig['first'], $pageConfig['second']);
		
		if ($members) {
		    foreach ($members as $member) {
		        $member->{'projects'} = MemberModel::getCountMembersProject($member->id);
		    }
		}
		
		if($page > $pageConfig['all']) {
		    throw new PublicException("Wybrana strona nie istnieje");
		}
		
		$pageConfig['url'] = adminURL('members', 'index');
		
		$view->assign('pageConfig', $pageConfig);
		
		$view->assign('members', $members);
		$view->assign('member_count', MemberModel::getCountMembers());
		$view->assign('admin_count', MemberModel::getCountAdmins());
		
		return $view->render('members/index');
	}
	
	protected function action_add() {
	    $this->setTitle('Użytkownicy - dodaj nowego');
	    $view = $this->getView();
	    
	    $projects = ProjectModel::getAll();
	    $view->assign('projects', $projects);
	    $view->assign('post', $_POST);
	    
	    return $view->render('members/add');
	}
	
	protected function action_add_post() {
	    $this->requirePost();
	    $this->onException('add');
	    
	    $email = Param::str($_POST, 'email');
	    $name = Param::str($_POST, 'name');
	    $password = Param::str($_POST, 'password');
	    $password2 = Param::str($_POST, 'password2');
	    
	    $rights = Param::arr($_POST, 'access');
	    $projects = Param::arr($_POST, 'projects');
	    
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
	    
	    if (MemberModel::getByEmail($email)) {
	        throw new PublicException("Wprowadzony adres e-mail nie jest unikalny.");
	    }
	    
	    $member = new MemberModel();
	    $member->setEmail($email);
	    $member->setName($name);
	    $member->setPassword($password);
	    $member->setAccess($access);
	    $memberId = $member->save();
	    
	    if (sizeof($projects)) {
	        foreach ($projects as $project) {
	            ProjectModel::addAccess($project, $memberId);
	        }
	    }
	    
	    new LogsModel($this->member->id, $this->selectedProject->id, 'member', 'add');
	    
	    $this->redirect('members', 'index');
	}
	
	
	protected function action_edit() {
	    $this->setTitle('Użytkownicy - edycja');
	    $view = $this->getView();
	    
	    $id = Param::int($this->getParams(), 'id');
	    
	    $member = new MemberModel($id);
	    
	    if (!$member) {
	        throw new PublicException("Wybrany użytkownik nie istnieje");
	    }
	    
	    $access = [];
	    if(isset($post['access'])) {
	        if (in_array(MemberModel::ADMIN_ACCESS_PROJECTS, $post['access'])) {
	            $access[1] = true;
	        }
	        if (in_array(MemberModel::ADMIN_ACCESS_MEMEBERS, $post['access'])) {
	            $access[2] = true;
	        }
	        if (in_array(MemberModel::ADMIN_ACCESS_TEMPLATES, $post['access'])) {
	            $access[3] = true;
	        }
	        if (in_array(MemberModel::ADMIN_ACCESS_LOGS, $post['access'])) {
	            $access[4] = true;
	        }
	        if (in_array(MemberModel::ADMIN_ACCESS_ALL_PROJECTS, $post['access'])) {
	            $access[5] = true;
	        }
	    }
	    
	    if ($member->access & MemberModel::ADMIN_ACCESS_PROJECTS) {
	        $access[1] = true;
	    }
	    else {
	        $access[1] = false;
	    }
	    if ($member->access & MemberModel::ADMIN_ACCESS_MEMEBERS) {
	        $access[2] = true;
	    }
	    else {
	        $access[2] = false;
	    }
	    if ($member->access & MemberModel::ADMIN_ACCESS_TEMPLATES) {
	        $access[3] = true;
	    }
	    else {
	        $access[3] = false;
	    }
	    if ($member->access & MemberModel::ADMIN_ACCESS_LOGS) {
	        $access[4] = true;
	    }
	    else {
	        $access[4] = false;
	    }
	    if ($member->access & MemberModel::ADMIN_ACCESS_ALL_PROJECTS) {
	        $access[5] = true;
	    }
	    else {
	        $access[5] = false;
	    }
	    
	    $projects = ProjectModel::getAll();
	    $memberProjects = ProjectModel::getByUser($member->id, true);
	    
	    $memberProjectAccess = [];
	    
	    foreach ($memberProjects as $project) {
	        $memberProjectAccess[] = $project->id;
	    }
	    
	    $view->assign('member', $member);
	    $view->assign('access', $access);
	    $view->assign('projects', $projects);
	    $view->assign('member_projects', $memberProjectAccess);
	    $view->assign('post', $_POST);
	    
	    return $view->render('members/edit');
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
	    
	    $email = Param::str($_POST, 'email');
	    $name = Param::str($_POST, 'name');
	    $password = Param::str($_POST, 'password');
	    $password2 = Param::str($_POST, 'password2');
	    
	    $rights = Param::arr($_POST, 'access');
	    $projects = Param::arr($_POST, 'projects');
	    
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
	    
	    if ($member->email != $email && MemberModel::getByEmail($email)) {
	        throw new PublicException("Wprowadzony adres e-mail nie jest unikalny.");
	    }
	    
	    if ($email != $member->email) {
	        $member->setEmail($email);
	    }
	    if ($name != $member->name) {
	        $member->setName($name);
	    }
	    if ($access != $member->access) {
	        $member->setAccess($access);
	    }
	    if (strlen($password)) {
	        $member->setPassword($login);
	        $member->changePassword();
	    }
	    $member->save();
	    
	    $member_projects = ProjectModel::getByUser($member->id, true);
	    
	    if (sizeof($member_projects)) {
	        foreach ($member_projects as $project) {
	            if (!in_array($project->id, $projects)) {
	               ProjectModel::removeAccess($project->id, $member->id);
	            }
	        }
	    }
	    if (sizeof($projects)) {
	        foreach ($projects as $project) {
	            ProjectModel::addAccess($project, $member->id);
	        }
	    }
	    
	    new LogsModel($this->member->id, $this->selectedProject->id, 'member', 'update');
	    
	    $this->redirect('members', 'index');   
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
	    
	    return $view->render('members/delete');
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
	    
	    $member->delete();

	    new LogsModel($this->member->id, $this->selectedProject->id, 'member', 'delete');
	    
	    $this->redirect('members', 'index');
	}
}