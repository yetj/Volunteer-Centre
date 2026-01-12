<?php

class AdminLogController extends AbstractAdminController {

	protected function init() {
		$this->setTitle('Logi');
		return parent::init();
	}
	
	protected function preAction() {
	    $this->requireProjectAccess($this->selectedProject, MemberModel::PROJECT_ACCESS_LOGS);
	}

	protected function action_index() {
	    $view = $this->getView();
	    
	    $logs = LogsModel::getAllByProject($this->selectedProject->id);
		
		$page = Param::int($this->getParams(), 'page', 1);
		$pageConfig = Helper::setPage($page, 30, sizeof($logs));
		
		$logs = LogsModel::getAllByProject($this->selectedProject->id, $pageConfig['first'], $pageConfig['second']);
		
		if($page > $pageConfig['all'] && $pageConfig['all'] > 0) {
		    throw new PublicException("Wybrana strona nie istnieje");
		}
		
		$pageConfig['url'] = adminURL('log', 'index');
		
		$view->assign('pageConfig', $pageConfig);
		$view->assign('logs', $logs);
		
		return $view->render('log/index');
	}
}