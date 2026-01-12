<?php

class AdminApplicationsController extends AbstractAdminController {

	protected function init() {
		$this->setTitle('Zgłoszenia');
		
		return parent::init();
	}
	
	protected function preAction() {
	    $this->requireProjectAccess($this->selectedProject, MemberModel::PROJECT_ACCESS_APPLICATIONS);
	}
	
	protected function action_index() {
	    $this->setSubTitle('Wybierz akcję');
	    $view = $this->getView();
	    
	    $actions = ActionModel::fetchAllApps($this->selectedProject->id);
	    
	    $view = $this->getView();
	    
	    $view->assign('actions', $actions);
	    
	    return $view->render('applications/index');
	}
	
	protected function action_action() {
	    $this->setSubTitle('Lista zgłoszeń');
	    $view = $this->getView();
	    
	    $id = Param::int($this->getParams(), 'id');
	    
	    $action = new ActionModel($id);
	    
	    if ($action->project_id != $this->selectedProject->id) {
	        throw new PublicException("Coś poszło nie tak, wróć do list akcji i wybierz ponownie.");
	    }
	    
	    $apps = ApplicationModel::fetchAll($id);
	    
	    $view = $this->getView();
	    
	    $view->assign('action', $action);
	    $view->assign('apps', $apps);
	    
	    return $view->render('applications/list');
	}
	
	protected function action_show() {
	    $this->setSubTitle('Lista zgłoszeń');
	    $view = $this->getView();
	    
	    $id = Param::int($this->getParams(), 'id');
	    $action_id = Param::int($this->getParams(), 'action');
	    
	    if ($this->isPost()) {
	        $idp = Param::int($_POST, 'id');
	        $status = Param::int($_POST, 'status');
	        $feedback = Param::str($_POST, 'feedback');
	        $comment = Param::str($_POST, 'comment');
	        $vote = Param::str($_POST, 'vote');
	        
	        $appEdit = new ApplicationModel($idp);
	        
	        if ($action_id == $appEdit->action_id && isset($_POST['status_button'])) {
	            $appEdit->setStatus($status);
	            $appEdit->setFeedback($feedback);
	            $appEdit->save();
	            
	            new LogsModel($this->member->id, $this->selectedProject->id, 'applications', 'update_status');
	        }
	        
	        if ($action_id == $appEdit->action_id && isset($_POST['vote_button']) && $vote >= 0 && $vote <= 6) {
	            if (!isset(ApplicationModel::isVoted($id, $this->member->id)->vote)) {
	                
	                ApplicationModel::addVote($id, $this->member->id, $vote);
	                
	                new LogsModel($this->member->id, $this->selectedProject->id, 'applications', 'vote');
	            }
	        }
	        
	        if (strlen($comment) > 5 && isset($_POST['comment_button'])) {
	            
	            ApplicationModel::addComment($id, $this->member->id, nl2br($comment));
	            
	            new LogsModel($this->member->id, $this->selectedProject->id, 'applications', 'comment');
	        }
	        
	    }
	    
	    $action = new ActionModel($action_id);
	    $app = new ApplicationModel($id);
	    
	    if (!$app->project_id) {
	        throw new PublicException("Wybrane zgłoszenie nie istnieje");
	    }
	    
	    if ($app->project_id != $this->selectedProject->id || $app->action_id != $action_id) {
	        throw new PublicException("Coś poszło nie tak, wróć do list akcji i wybierz ponownie.");
	    }
	    
	    
	    $app_replys = ApplicationReplyModel::fetchAnswers($id);
	    
	    $view = $this->getView();
	    
	    $view->assign('isvoted', ApplicationModel::isVoted($id, $this->member->id));
	    $view->assign('avgVote', ApplicationModel::averageVote($id));
	    $view->assign('comments', ApplicationModel::fetchComments($id));
	    $view->assign('action', $action);
	    $view->assign('app', $app);
	    $view->assign('app_replys', $app_replys);
	    
	    return $view->render('applications/show');
	}
}