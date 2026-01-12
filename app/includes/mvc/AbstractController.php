<?php

abstract class AbstractController {
	/**
	 * @var Response
	 */
	protected $response = null;
	
	protected $viewData = array('additionals' => array(), 'error_messages' => array(), 'success_messages' => array());

	protected $onErrorAction = null;

	protected $controllerName = '';

	protected $action = '';

	protected $renderLayout = true;
	
	protected $project = null;
	
	protected $projectName = null;
	
	protected $projectDetails = null;
	
	protected $user = array();
	
	protected $params = null;
	
	protected $title;
	protected $project_title;
	protected $pages;
	protected $active;

	/**
	 * Constructor
	 *
	 * @param string $app Application name e.g. project, start, webservice ...
	 * @param string $controllerName Name of this controller
	 */
	public function __construct($app, $controller_name = null) {
		$this->app = $app;
		
		if($controller_name != null) {
			$this->controllerName = $controller_name;
		}
		$this->response = new Response();
		$this->action = Router::get()->getAction();
	}
	
	protected function setPages($pages) {
		$this->pages = $pages;
	}
	
	protected function setActive($active) {
		$this->active = $active;
	}
	
	protected function setTitle($title) {
		$this->title = $title;
	}
	
	protected function setProjectTitle($title) {
		$this->project_title = $title;
	}
	
	protected function getParams() {
		return Router::get()->getParams();	
	}
	
	public function setProject($slug) {
		$exists = ProjectModel::getOne($slug);

		if(!$exists && $slug) {
			header("Location: " . VC::config()->url_base . '/global');
		}

		$this->projectDetails = $exists;
		$this->project = $slug;
	}
	
	/**
	 * Get DB
	 */
	protected function db() {
		return VC::db();
	}

	/**
	 * Gets a template engine for current application
	 *
	 * @return View;
	 */
	public function getView(){
		return new View($this->app);
	}

	public function handle() {
		if ($this->init()) {
			$this->executeAction();
		}
		return $this->response;
	}

	public function json($data) {
		$this->response->setHeader('Content-Type', 'application/json');
		$this->response->setBody(json_encode($data));
	}

	public function addViewInfo($data, $key = 'additionals') {
		if (!is_array($data)) {
			$data = (array) $data;
		}
	 	$this->viewData[$key] = array_unique(array_merge($data, $this->viewData[$key]));
	}

	/**
	 *
	 */
	public function addErrorMessage($error_messages) {
		$this->addViewInfo($error_messages, 'error_messages');
	}
	
	public function addSuccessMessage($success_messages) {
		$this->addViewInfo($success_messages, 'success_messages');
	}

	/**
	 * Escapes an URL to a controller and its parameters
	 *
	 * @param string $controller
	 * @param array $params
	 * @return string
	 */
	public function url($controller, array $params = array()) {
		return htmlspecialchars($this->unescapedUrl($controller, $params));
	}

	/**
	 * Generate an URL for a controller and parameters
	 *
	 * $controller->url('buildings_mail', array('action' => 'sleep'));
	 * results in /game/buildings_mail?town=3&action=sleep
	 *
	 * @param string $controller
	 * @param array $params
	 * @return string
	 */
	public function unescapedUrl($controller, $action, array $params) {
		if($this->app == 'admin') {
			return adminURL($controller, $action, $params);
		}
		else {
		    return Helper::publicURL($this->project, $controller, $action, $params);
		}

		die('todo 004');
	}


	/**
	 * Redirect relative to this application
	 *
	 * @param string $controller Can be "action=login" or "?action=login"
	 * @return Response
	 */
	public function redirect($controller, $action, array $params = array()) {
	    $this->renderLayout = false;
		$url = $this->unescapedUrl($controller, $action, $params);
		$this->response->setRedirect($url);
	}

	public function onException($action) {
		$this->onErrorAction = $action;
	}

	public function setRenderLayout($bool) {
	    $this->renderLayout = $bool;
	}
	
	/**
	 * Decode json data which is transferred with $_GET['json'] or $_POST['json']
	 *
	 * @var array $source $_GET or $_POST
	 * @return array
	 */
	protected function jsonParams($source) {
		return Zend_Json::decode(Param::str($source, 'json'), Zend_Json::TYPE_ARRAY);
	}

	protected function requirePost() {
		if (!$this->isPost()) {
			throw new Exception('Invalid request. Requires post.');
		}
	}

	protected function isAjax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) and $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
	}

	protected function isPost() {
		return ($_SERVER['REQUEST_METHOD'] == 'POST');
	}

	protected function isGet() {
		return ($_SERVER['REQUEST_METHOD'] == 'GET');
	}

	protected function createDefaultResponse($content) {
		$layout = $this->getView();
		$layout->assign('errors', $this->viewData['error_messages']);
		$layout->assign('success', $this->viewData['success_messages']);
		$layout->assign($this->viewData['additionals']);
		$layout->assign('baseurl', VC::config()->url_base);
		$layout->assign('content', $content);
		$layout->assign('title', $this->project_title .' - '. $this->title);
		$layout->assign('projectTitle', $this->project_title);
		$layout->assign('pages', $this->pages);
		$layout->assign('active', $this->active);
		$layout->assign('project', $this->project);
		$layout->assign('url', $this->project);
		
		$this->response->setBody($layout->render('layout'));
	}

	/**
	 * Excecutes an action.
	 * If an expected error occurs (GameException) this message is displayed to the gamer
	 * Other exceptions are logged and a generic error message is displayed. In development mode the exception stack trace is displayed.
	 *
	 */
	protected function executeAction() {
		$content = '';

		try {
			$this->preAction();
			
			$action_method_name = 'action_' . $this->action;
			
			if (!method_exists($this, $action_method_name)) throw new PublicException('Wybrano nieodpowiednią akcję.');
			$content  = $this->$action_method_name();
			
			if(is_string($content)) {
				$content .= $this->postAction();
			}
		} catch (Exception $e) {
			if($e instanceOf PublicException) {
				$this->addErrorMessage($e->getMessage());
				if(!is_null($this->onErrorAction)) {
					$this->action = $this->onErrorAction;
					return $this->executeAction();
				}
			}
			else if($e instanceOF PublicExceptionSuccess) {
				$this->addSuccessMessage($e->getMessage());
				if(!is_null($this->onErrorAction)) {
					$this->action = $this->onErrorAction;
					return $this->executeAction();
				}
			}
			else {
				if(VC::config()->debug) {
					echo "<pre>";
					print_r($e);
					echo "</pre>";
				}
				else {
					$this->addErrorMessage("A fatal error occured and has been logged");
				}
			}
		}
		if (!$this->isAjax() && $this->renderLayout) {
			$this->createDefaultResponse($content);
		} 
		elseif($this->isAjax()) {
			$this->response->setBody(json_encode($content));
		}
		elseif (!empty($content)) {
			$this->response->setBody($content);
		}
	}

	/**
	 * This (hook) method is called right before the action is executed. Execution
	 * gets CANCELED when init() doesn't return true.
	 *
	 * It can be used to initialize a controller in the same way for every
	 * action. You could use the constructor to do that but the
	 * session is not constructed at this point so you have to use init
	 * if you rely on the session in some way.
	 */
	protected function init() {
		
		return true;
	}
	
	protected function sendToAuth() {
		$url = VC::config()->url_login;
		//$url .= "?redirect=" . urlencode($_SERVER['REQUEST_URI']);

		header("Location: $url");
		die();
	}
	
	protected function preAction() {
	}

	protected function postAction() {
	}

	protected function createDefaultExceptionResponse($exception) {
		ob_start();
		var_dump($exception);
		$result = ob_get_clean();
		return $result;
	}
}