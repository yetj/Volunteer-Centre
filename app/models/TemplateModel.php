<?php

class TemplateModel {
    public $id;
    public $name;
    public $project_id;
    public $global_template_id;
    public $sort;
    public $deleted;
    public $img;
    public $img_type;
    public $html;
    public $parts;
    
    public static $fields = [
        'text' => 'Krótkie pole tekstowe',
        'textarea' => 'Obszerne pole tekstowe',
        'email' => 'Pole do podania adresu email'
    ];
    
    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * @param mixed $projectID
     */
    public function setProjectID($projectID)
    {
        $this->project_id = $projectID;
    }

    /**
     * @param mixed $globalTemplateID
     */
    public function setGlobalTemplateID($globalTemplateID)
    {
        $this->global_template_id = $globalTemplateID;
    }

    /**
     * @param mixed $sort
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
    }

    /**
     * @param mixed $removed
     */
    public function setRemoved($removed)
    {
        $this->removed = $removed;
    }

    public function __construct($id = null) {
        if ($id) {
            $this->id = $id;
            $this->loadTemplate();
        }
    }
    
    private function loadTemplate() {
        $sql = "SELECT t.*, g.img, g.img_type, g.html, g.parts FROM templates AS t LEFT JOIN global_templates AS g ON (t.global_template_id = g.id) WHERE t.id=?";
        $sth = VC::db()->prepare($sql);
        $sth->execute([$this->id]);
        $data = $sth->fetch();
        
        if (!$data) {
            throw new PublicException("Wybrany szablon nie istnieje.");
        }
        
        foreach (['name', 'project_id', 'global_template_id', 'sort', 'deleted', 'img', 'img_type', 'html', 'parts'] as $key) {
            $this->$key = $data->$key;
        }
    }
    
    public function save() {
        if ($this->id) {
            $data = [
                'name'  => $this->name,
                'sort'  => $this->sort
            ];
            
            Helper::DB_update('templates', $data, ['id' => $this->id]);
        }
        else {
            $data = [
                'name'  => $this->name,
                'project_id' => $this->project_id,
                'global_template_id' => $this->global_template_id
            ];
            
            Helper::DB_insert('templates', $data);
        }
    }
    
    public static function fetchAll($project_id = 0) {
        $sql = "SELECT t.*, g.img, g.img_type, g.html, g.parts FROM templates t LEFT JOIN global_templates AS g ON (t.global_template_id = g.id) WHERE t.deleted = 0 AND t.project_id = ?";
        
        $sth = VC::db()->prepare($sql);
        $sth->execute([$project_id]);
        
        return $sth->fetchAll();
    }
    
    public function delete() {
        Helper::DB_update('templates', ['deleted' => 1], ['id' => $this->id]);
    }
}