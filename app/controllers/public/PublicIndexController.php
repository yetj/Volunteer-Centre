<?php
class PublicIndexController extends AbstractController {
	
	protected function preAction() {
	    if ($this->projectDetails) {
	        
	        if(!$this->projectDetails->status || $this->projectDetails->status == 2) {
    			$this->setTitle("Projekt jest tymczasowo niedostępny");
    			throw new PublicException("Projekt jest tymczasowo niedostępny");
    		}
    		$this->setPages(PageModel::fetchByProject($this->projectDetails->id));
	    }
	}
	
	protected function action_index() {
	    
	    if ($this->project) {
    		$page = Param::str($this->getParams(), 'show');
    		
    		$content = PageModel::getPage($this->projectDetails->id, $page);
    		$this->setProjectTitle($this->projectDetails->name);
    		
    		if(!$page) {
    			$page = 'index';
    		}
    		elseif ($page == 'apply') {
    			$this->action = 'apply';
    			
    			$this->setActive($page);
    			$this->setTitle($content->title);
    			return $this->action_apply();
    		}
    		elseif ($page == 'register') {
    		    $this->action = 'register';
    			
    			$this->setTitle($content->title);
    			return $this->action_register();
    		}
    		
    		if(!$content || !$content->display) {
    			$page = 'index';
    			$content = PageModel::getPage($this->projectDetails->id, $page);
    		}
    		
    		$view = parent::getView();
    		
    		$this->setTitle($content->title);
    		
    		$this->setActive($page);
    		
    		$view->assign('page', $content);
    		$view->assign('pages', PageModel::fetchByProject($this->projectDetails->id));
    		
    		
    		return $view->render('index/index');
	    }
	    else {
	        $view = parent::getView();
	        
	        $this->setProjectTitle("Volunteer centre");
	        $this->setTitle("Strona główna");
	        
	        $view->assign('projectTitle', "Volunteer centre");
	        
	        return $view->render('index/index');
	    }
	}
	
	protected function action_login() {
	    parent::setRenderLayout(false);
	    $layout = new View('admin');
	    $errors = [];
	    
	    if ($this->isPost()) {
	        
	        $email = Param::str($_POST, 'email');
	        $password = Param::str($_POST, 'password');
	        
            $result = MemberModel::getByEmail($email);
            
            if ($result) {
                $user = new MemberModel($result->id);
                
                if ($user) {
                    if ($user->password == hash('sha256', $password . '_VC_' . $user->salt)) {
                        $sessionID = MemberModel::createSession($user->id);
                        
                        header('Location: /admin/index/index/enter_session/'.$sessionID);
                        die();
                    }
                    else {
                        $errors[] = "Niepoprawne dane do logowania";
                    }
                }
                else {
                    $errors[] = "Niepoprawne dane do logowania";
                }
            }
            else {
                $errors[] = "Niepoprawne dane do logowania";
            }
	    }
	    
	    $layout->assign('errors', $errors);
	    $this->response->setBody($layout->render('login'));
	}

	protected function action_page() {
		
		$this->action = 'index';
		
		return $this->action_index();
	}

	protected function action_apply() {
	    
	    $action_id = Param::int($this->getParams(), 'action', 0);
	    
	    if($this->isPost()) {
	        
	        $this->onException('apply');
	        
	        $action_idp = Param::int($_POST, 'action_id');
	        $project_idp = Param::int($_POST, 'project_id');
	        $fields = Param::arr($_POST, 'field');
	        
	        if ($this->projectDetails->id != $project_idp || $action_id != $action_idp) {
	            throw new PublicException("Coś poszło nie tak... Wróć na stronę akcji i spróbuj ponownie wysłać zgłoszenie");
	        }
	        
	        $action = new ActionModel($action_id);
	        
	        $template_fields = TemplateFieldsModel::fetchAll($action->template_id, 1);
	        
	        $app = new ApplicationModel();
	        $app->setProjectID($this->projectDetails->id);
	        $app->setActionID($action_id);
	        $application_id = $app->save();
	        
	        foreach ($template_fields as $template_field) {
	            if (array_key_exists($template_field->id, $fields)) {
    	            $appReply = new ApplicationReplyModel();
    	            $appReply->setApplicationID($application_id);
    	            $appReply->setFieldID($template_field->id);
    	            $appReply->setValue($fields[$template_field->id]);
    	            $appReply->save();
	            }
	        }
	        
	        $this->redirect('index', 'page', ['show'=>'apply', 's'=>'Zgłoszenie zostało pomyślnie wysłane! Proszę teraz oczekiwać na kontakt!']);
	    }
	    
	    $view = parent::getView();
	    
	    // actions
	    
	    $actions = ActionModel::fetchActive($this->projectDetails->id);
	    $view->assign('actions', $actions);
	    $view->assign('project', $this->projectDetails);
	    $view->assign('action_id', $action_id);
	    
	    
	    if ($action_id > 0) {
	        
	        $action = new ActionModel($action_id);
	        $this->onException('apply');
	        
	        if ($action->project_id != $this->projectDetails->id) {
	            throw new PublicException("Wybrana akcja nie należy do wybranego projektu...");
	        }
	        
	        if ($action->status != 1) {
	            throw new PublicException("Wybrana akcja nie jest aktualnie dostępna");
	        }
	        
	        $template = new TemplateModel($action->template_id);
	        $template_fields = TemplateFieldsModel::fetchAll($action->template_id);
	        
	        
	        $view->assign('action', $action);
	        $view->assign('template', $template);
	        $view->assign('template_fields', $template_fields);
	    }
	    
	    
	    return $view->render('index/apply');
	}
	
	protected function action_register() {
		
		$view = parent::getView();

		$this->setActive('register');
		
		$content = PageModel::getPage($this->projectDetails->id, 'register');
		
		$this->setTitle($content->title);
		$view->assign('page', $content);
		
		$view->assign('url', $this->project);
		$view->assign('sendSuccesfull', 0);
		return $view->render('index/register');
	}
	
}