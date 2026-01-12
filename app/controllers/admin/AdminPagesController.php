<?php

class AdminPagesController extends AbstractAdminController {

	protected function init() {
		$this->setTitle('Strony');
		
		return parent::init();
	}
	
	protected function preAction() {
	    $this->requireProjectAccess($this->selectedProject, MemberModel::PROJECT_ACCESS_PAGES);
	}
	
	protected function action_index() {
	    $this->setSubTitle('Lista');
	    $view = $this->getView();
	    
	    $view->assign('pages', PageModel::fetchByProject($this->selectedProject->id,0,0));
	    return $view->render('pages/index');
	}
	
	protected function action_update_order() {
	    $order = Param::str($_POST, 'ids');
	    
	    $sort = explode(",", trim($order));
	    
	    new LogsModel($this->member->id, $this->selectedProject->id, 'pages', 'update_order');
	    
	    return PageModel::saveOrder($sort, $this->selectedProject->id);
	    
	    return true;
	}
	
	protected function action_add() {
	    $this->setSubTitle('Dodaj nową stronę');
	    
	    $view = $this->getView();
	    return $view->render('pages/add');
	}
	
	protected function action_add_post() {
	    $this->requirePost();
	    $this->onException('show');
	    
	    $title = Param::str($_POST, 'title');
	    $content = Param::str($_POST, 'content');
	    $display = Param::int($_POST, 'display');
	    $hidden = Param::int($_POST, 'hidden');
	    
	    if (strlen($title) < 3) {
	        throw new PublicException("Nazwa jest za krótka.");
	    }
	   
	    $page = new PageModel();
	    $page->setProject_id($this->selectedProject->id);
	    $page->setTitle($title);
	    $page->setContent($content);
	    $page->setSystem(0);
	    $page->setSort(100);
	    $page->setDisplay($display);
	    $page->setHidden($hidden);
	    $page->save();
	    
	    new LogsModel($this->member->id, $this->selectedProject->id, 'pages', 'add');
	    
	    $this->redirect('pages', 'index', ['project' => $this->selectedProject->id]);
	}
	
	protected function action_edit() {
	    $this->setSubTitle('Edytuj');
	    
	    $id = Param::int($this->getParams(), 'id');
	    
	    $page = new PageModel($id);
	    
	    $page->requireProject($this->selectedProject->id);
	    
	    if (!$page) {
	        throw new PublicException("Wybrana strona nie istnieje");
	    }
	    
	    $view = $this->getView();
	    
	    $view->assign('page', $page);
	    
	    return $view->render('pages/edit');
	}
	
	protected function action_edit_post() {
	    $this->requirePost();
	    $this->onException('show');
	    
	    $id = Param::int($this->getParams(), 'id');
	    $idp = Param::int($_POST, 'id');
	    
	    $page = new PageModel($id);
	    $title = Param::str($_POST, 'title');
	    
	    if ($id != $idp) {
	        throw new PublicException("Coś poszło nie tak... Wróć do poprzedniej strony i spróbuj ponownie");
	    }
	    
	    if (strlen($title) < 3) {
	        throw new PublicException("Nazwa jest za krótka");
	    }
	    
	    $page = new PageModel($id);
	    
	    if ($page->slug != "apply" && $page->slug != "register") {
    	    $content = Param::str($_POST, 'content');
    	    $page->setContent($content);
	    }
	    
	    if ($page->system == 0) {
	        $display = Param::int($_POST, 'display');
	        $hidden = Param::int($_POST, 'hidden');
	        $page->setDisplay($display);
	        $page->setHidden($hidden);
	    }
	    
	    $page->requireProject($this->selectedProject->id);
	    
	    $page->setTitle($title);
	    $page->save();
	    
	    new LogsModel($this->member->id, $this->selectedProject->id, 'pages', 'edit');
	    
	    $this->redirect('pages', 'index', ['project' => $this->selectedProject->id]);
	}
	
	protected function action_delete() {
	    $this->setSubTitle('Usuń');
	    
	    $id = Param::int($this->getParams(), 'id');
	    
	    $page = new PageModel($id);
	    
	    if (!$page) {
	        throw new PublicException("Wybrana strona jest niedostępna");
	    }
	    
	    if ($page->system == 1) {
	        throw new PublicException("Nie można usunąć strony systemowej");
	    }
	    
	    $view = $this->getView();
	    
	    $view->assign('page', $page);
	    
	    return $view->render('pages/delete');
	}
	
	protected function action_delete_post() {
	    
	    $this->requirePost();
	    $this->onException('show');
	    
	    $id = Param::int($this->getParams(), 'id');
	    $idp = Param::int($_POST, 'id');
	    
	    if ($id != $idp) {
	        throw new PublicException("Coś poszło nie tak... Wróć do poprzedniej strony i spróbuj ponownie");
	    }
	    
	    $page = new PageModel($id);
	    
	    if ($page->system == 1) {
	        throw new PublicException("Nie można usunąć strony systemowej");
	    }
	    
	    $page->delete();
	    
	    new LogsModel($this->member->id, $this->selectedProject->id, 'pages', 'delete');
	    
	    $this->redirect('pages', 'index', ['project' => $this->selectedProject->id]);
	}
}