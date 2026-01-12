<?php 

class PageModel {
    public static $systemPages = [
        'index' => 'Strona główna',
        'apply' => 'Lista akcji'
    ];
    
    public $id;
    public $project_id;
    public $title;
    public $slug;
    public $content;
    public $system = 0;
    public $sort;
    public $display;
    public $hidden;
    
    
    public function __construct($pageID = null) {
        if($pageID) {
            $this->id = $pageID;
            $this->loadPage();
        }
    }
    
    private function loadPage() {
        $sql = "SELECT * FROM pages WHERE id=?";
        $sth = VC::db()->prepare($sql);
        $sth->execute([$this->id]);
        $data = $sth->fetch();
        
        if (!$data) {
            throw new PublicException("Strona nie istnieje.");
        }
        
        foreach (['project_id', 'title', 'slug', 'content', 'system', 'sort', 'display', 'hidden'] as $key) {
            $this->$key = $data->$key;
        }
    }
    
    public function requireProject($projectID) {
        if ($projectID != $this->project_id) {
            throw new PublicException("Wybrano nieodpowiedni projekt lub stronę.");
        }
    }
    
    /**
     * @param mixed $project_id
     */
    public function setProject_id($project_id) {
        $this->project_id = $project_id;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title, $slug = false) {
        if(strlen($title) > 30) {
            $title = substr($title, 0, 30);
        }
        $this->title = $title;
        
        $this->slug = $slug ? Helper::toAscii($slug) : Helper::toAscii($title);
        if(!$this->slug) {
            $this->slug = $this->id;
        }
    }

    /**
     * @param mixed $content
     */
    public function setContent($content) {
        $this->content = $content;
    }

    /**
     * @param mixed $system
     */
    public function setSystem($system) {
        $this->system = $system;
    }

    /**
     * @param mixed $sort
     */
    public function setSort($sort) {
        $this->sort = $sort;
    }

    /**
     * @param mixed $display
     */
    public function setDisplay($display) {
        if($this->system && !$display) {
            throw new PublicException("Nie można ukryć stron systemowych.");
        }
        $this->display = $display;
    }

    /**
     * @param mixed $hidden
     */
    public function setHidden($hidden) {
        if($this->system && $hidden) {
            throw new PublicException("Nie można ukryć stron systemowych.");
        }
        $this->hidden = $hidden;
    }
    
    public function save() {
        if ($this->id) {
            $data = [
                'sort' => $this->sort, 
                'title' => $this->title,
                'slug'  => $this->slug,
                'content'  => $this->content,
                'display'  => $this->display,
                'hidden'  => $this->hidden
            ];
            
            if ($this->system) {
                unset($data['slug']);
            }
            
            Helper::DB_update('pages', $data, ['id' => $this->id]);
        }
        else {
            $data = [
                'project_id' => $this->project_id,
                'title' => $this->title,
                'slug'  => $this->slug,
                'content'  => $this->content,
                'system' => $this->system,
                'sort' => $this->sort,
                'display'  => $this->display,
                'hidden'  => $this->hidden
            ];
            
            Helper::DB_insert('pages', $data);
        }
    }
    
    public function delete() {
        if($this->system) {
            throw new PublicException("Nie można usunąć stron systemowych.");
        }
        
        Helper::DB_delete('pages', ['id' => $this->id]);
    }
    
    public static function fetchByProject($projectID, $display=1, $not_hidden=1) {
        
        if ($display == 1) {
            $display = " AND display = 1";
        }
        else {
            $display = "";
        }
        
        if ($not_hidden == 1) {
            $not_hidden = " AND hidden = 0";
        }
        else {
            $not_hidden = "";
        }
        
        $sql = "SELECT id, title, slug, display, system, hidden FROM pages WHERE project_id = ? ".$display.$not_hidden." ORDER BY sort";
        
        $sth = VC::db()->prepare($sql);
        $sth->execute([$projectID]);
        
        return $sth->fetchAll();
    }
    
    public static function getPage($projectID, $slug) {
        $sql = "SELECT * FROM pages WHERE project_id=? AND slug=? LIMIT 1";
        
        $sth = VC::db()->prepare($sql);
        $sth->execute([$projectID, $slug]);
        
        return $sth->fetch();
    }
    
    public static function saveOrder($orders, $projectID) {
        foreach ($orders as $order => $id) {
            Helper::DB_update('pages', ['sort' => $order], ['id' => $id, 'project_id' => $projectID]);
        }
    }
    
    public static function createSystemPages($projectID) {
        $sort = 0;
        
        foreach (self::$systemPages as $slug => $title) {
            $page = new PageModel();
            $page->setSort($sort);
            $page->setProject_id($projectID);
            $page->setTitle($title, $slug);
            $page->setContent('<h3>Nowa strona o nazwie: '.$title.'</h3>');
            $page->setSystem(true);
            $page->setDisplay(true);
            $page->setHidden(false);
            $page->save();
        }
    }
}