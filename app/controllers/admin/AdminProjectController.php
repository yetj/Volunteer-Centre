<?php

class AdminProjectController extends AbstractAdminController {

	protected function init() {
		$this->setTitle('Dashboard');
		return parent::init();
	}
	
	protected function action_index() {
	    $view = $this->getView();
	    
	    $this->requireProjectAccess($this->selectedProject->id, MemberModel::PROJECT_ACCESS_PAGES);;
	    
	    $members = MemberModel::getAllByProject($this->selectedProject->id);
	    $projects = ProjectModel::getAll();
	    $waiting = ProjectRequestModel::getWaitingCount();
	    $templates = TemplateModel::fetchAll($this->selectedProject->id);
	    $actions = ActionModel::fetchAll($this->selectedProject->id);
	    $applications = ApplicationModel::fetchAllByProject($this->selectedProject->id);
	    
	    $view->assign('actions', sizeof($actions));
	    $view->assign('members', sizeof($members));
	    $view->assign('applications', sizeof($applications));
	    $view->assign('templates', sizeof($templates));
	    return $view->render('project/index');
	}

}