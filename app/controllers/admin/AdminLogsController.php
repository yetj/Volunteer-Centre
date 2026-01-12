<?php

class AdminLogsController extends AbstractAdminController {

	protected function init() {
		$this->setTitle('Logi administracyjne');
		return parent::init();
	}
	
	protected function preAction() {
	    $this->requireAdminAccess(MemberModel::ADMIN_ACCESS_LOGS);
	}

	protected function action_index() {
	    $view = $this->getView();
	    
	    $logs = LogsModel::getAll();
		
		$page = Param::int($this->getParams(), 'page', 1);
		$pageConfig = Helper::setPage($page, 30, sizeof($logs));
		
		$logs = LogsModel::getAll($pageConfig['first'], $pageConfig['second']);
		
		if($page > $pageConfig['all'] && $pageConfig['all'] > 0) {
		    throw new PublicException("Wybrana strona nie istnieje");
		}
		
		$pageConfig['url'] = adminURL('logs', 'index');
		
		$view->assign('pageConfig', $pageConfig);
		$view->assign('logs', $logs);
		
		return $view->render('logs/index');
	}
}