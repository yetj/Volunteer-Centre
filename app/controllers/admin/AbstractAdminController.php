<?php

class AbstractAdminController extends AbstractController {
	protected $memberProjects;

	protected $selectedProject;

	protected $title;

	protected $subTitle;
	
	protected $member;

	protected function init() {
		parent::init();

		if(VC::config()->developer) {
			$userID = VC::config()->developer;
			$this->member = new MemberModel($userID);
		} else {
			// Authentication
			$enterSession = Param::str($this->getParams(), 'enter_session');
			
			if($enterSession) {
			    setcookie('session_id', $enterSession, time()+MemberModel::SESSION_VALID_TIME, '/', '');

				$url = VC::config()->url->base . '/admin';
				header("Location: $url");
				die();
			}

			// Validate session
			$sessionID = Param::str($_COOKIE, 'session_id');

			if(!$sessionID) {
				$this->sendToAuth();
			}

			$result = MemberModel::fetchMemberIDBySessionID($sessionID);
			
			if(!$result) {
				$this->sendToAuth();
			}

			$this->member = new MemberModel($result->id);
		}

		// Selected resource?
		$this->memberProjects = ProjectModel::getByUser($result->id);
		
		if($projectID = Param::int($this->getParams(), 'project')) {
			$this->selectedProject = isset($this->memberProjects[$projectID]) ? $this->memberProjects[$projectID] : false;
		}

		return true;
	}

	protected function setTitle($title) {
		$this->title = $title;
	}

	protected function setSubTitle($subTitle) {
		$this->subTitle = $subTitle;
	}
	
	protected function hasAdminAccess($access) {
	    if ($this->member->access == -1) {
	        return true;
	    }
	    else {
	        return $this->member->access & $access;
	    }
	}
	
	protected function requireAdminAccess($access) {
	    if (!$this->hasAdminAccess($access)) {
	        throw new PublicException("Brak odpowiednich uprawnień administratora.");
	    }
	}

	protected function hasProjectAccess($resource, $access) {
	    if ($resource) {
    	    if($this->member->access & MemberModel::ADMIN_ACCESS_ALL_PROJECTS) {
    	        return true;
    		} else {
                return $this->selectedProject->access & $access;
    		}
	    }
	    return false;
	}

	protected function requireProjectAccess($project, $access) {
	    if(!$this->selectedProject || !$this->hasProjectAccess($project, $access)) {
	        throw new PublicException("Brak dostępu.");
		}
	}

	private function getAdminNav() {
	    $nav = [];
	    if ($this->member->access > 0) {
	       $nav[] = ['home', 'index', 'Dashoboard'];
	    }
	    if (self::hasAdminAccess(MemberModel::ADMIN_ACCESS_PROJECTS)) {
	        $nav[] = ['shopping-cart', 'projects', 'Projekty'];
	    }
	    if (self::hasAdminAccess(MemberModel::ADMIN_ACCESS_MEMEBERS)) {
	        $nav[] = ['users', 'members', 'Użytkownicy'];
	    }
	    if (self::hasAdminAccess(MemberModel::ADMIN_ACCESS_TEMPLATES)) {
	        $nav[] = ['layout', 'global_templates', 'Szablony globalne'];
	    }
	    if (self::hasAdminAccess(MemberModel::ADMIN_ACCESS_LOGS)) {
	        $nav[] = ['book-open', 'logs', 'Logi'];
	    }
	    return $nav;
	}
	
	private function getProjectNav() {
	    $nav[] = ['home', 'project', 'Dashoboard'];
	    
	    if (self::hasProjectAccess($this->selectedProject, MemberModel::PROJECT_ACCESS_USERS)) {
	        $nav[] = ['users', 'users', 'Użytkownicy'];
	    }
	    if (self::hasProjectAccess($this->selectedProject, MemberModel::PROJECT_ACCESS_ACTIONS)) {
	        $nav[] = ['heart', 'actions', 'Akcje wolontariackie'];
	    }
	    if (self::hasProjectAccess($this->selectedProject, MemberModel::PROJECT_ACCESS_PAGES)) {
	        $nav[] = ['layers', 'pages', 'Strony'];
	    }
	    if (self::hasProjectAccess($this->selectedProject, MemberModel::PROJECT_ACCESS_APPLICATIONS)) {
	        $nav[] = ['tag', 'applications', 'Zgłoszenia'];
	    }
	    if (self::hasProjectAccess($this->selectedProject, MemberModel::PROJECT_ACCESS_TEMPLATES)) {
	        $nav[] = ['layout', 'templates', 'Szablony'];
	    }
	    if (self::hasProjectAccess($this->selectedProject, MemberModel::PROJECT_ACCESS_LOGS)) {
	        $nav[] = ['book-open', 'log', 'Logi'];
	    }
	    if (self::hasProjectAccess($this->selectedProject, MemberModel::PROJECT_ACCESS_SETTINGS)) {
	        $nav[] = ['settings', 'settings', 'Ustawienia'];
	    }
	    
	    $nav[] = ['globe', 'index', 'Strona rekrutacji'];
	    
	    return $nav;
	}

	protected function createDefaultResponse($content) {
		$layout = $this->getView();

		$layout->assign('errors', $this->viewData['error_messages']);     // ok
		$layout->assign('success', $this->viewData['success_messages']);  // ok
		$layout->assign($this->viewData['additionals']);                  // ok
		$layout->assign('content', $content);                             // ok
		
		$layout->assign('title', $this->title);
		
		$layout->assign('sub_title', $this->subTitle);                 // ok
		$layout->assign('member_projects', $this->memberProjects);
		$layout->assign('selected_project', $this->selectedProject);

		$layout->assign('admin_nav', $this->getAdminNav());       // ok
		$layout->assign('project_nav', $this->getProjectNav());   // ok
		$layout->assign('controller', $this->controllerName);     // ok
		$layout->assign('action', $this->action);                 // ok
		$layout->assign('params', $this->getParams());            // ok

		$this->response->setBody($layout->render('layout'));
	}

	public function unescapedUrl($controller, $action, array $params) {
		$currentParams = Router::get()->getParams();
		$url = "/admin/$controller/$action";

		if(isset($currentParams['resource']) && !isset($params['resource'])) {
			$params['resource'] = $currentParams['resource'];
		}

		foreach($params as $key => $value) {
			$url .= "/$key/$value";
		}

		return $url;
	}
}