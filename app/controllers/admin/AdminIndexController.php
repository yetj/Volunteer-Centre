<?php

class AdminIndexController extends AbstractAdminController {

	protected function init() {
		$this->setTitle('Dashboard');
		return parent::init();
	}
	
	protected function preAction() {
	    $this->requireAdminAccess(MemberModel::ADMIN_ACCESS_PROJECTS);
	}

	protected function action_index() {
	    
	    if ($this->member->access) {
    		$view = $this->getView();
    		
    		$members = MemberModel::getAll();
    		$projects = ProjectModel::getAll();
    		$waiting = ProjectRequestModel::getWaitingCount();
    		$applications = ApplicationModel::fetchTotal();
    		$actions = ActionModel::fetchTotal();
    		
    		$view->assign('projects', sizeof($projects));
    		$view->assign('projects_waiting', $waiting->sum);
    		$view->assign('members', sizeof($members));
    		$view->assign('applications', $applications->sum);
    		$view->assign('actions', $actions->sum);
    		
    		return $view->render('index/index');
	    }
	    else {
	        throw new PublicException("Proszę wybrać projekt do zarządzania...");
	    }
	}
	
	protected function action_logout() {
		setcookie('session_id', '', time()-86400, '/', '');
		
		header('Location: /');
	}
}