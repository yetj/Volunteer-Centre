<?php 

class TemplateFieldsModel {
    
    public $id;
    public $template_id;
    public $name;
    public $position;
    public $type;
    public $required;
    public $defaults;
    public $options;
    public $sort;
    public $deleted;
    
    /**
     * @param mixed $template_id
     */
    public function setTemplateID($template_id)
    {
        $this->template_id = $template_id;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * @param mixed $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @param mixed $required
     */
    public function setRequired($required)
    {
        $this->required = $required;
    }

    /**
     * @param mixed $defaults
     */
    public function setDefaults($defaults)
    {
        $this->defaults = $defaults;
    }

    /**
     * @param mixed $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * @param mixed $sort
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
    }

    /**
     * @param mixed $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    public function __construct($id = null) {
        if ($id) {
            $this->id = $id;
            $this->loadField();
        }
    }
    
    private function loadField() {
        $sql = "SELECT * FROM templates_fields WHERE id=?";
        $sth = VC::db()->prepare($sql);
        $sth->execute([$this->id]);
        $data = $sth->fetch();
        
        if (!$data) {
            throw new PublicException("Wybrane pole nie istnieje.");
        }
        
        foreach (['template_id', 'name', 'position', 'type', 'required', 'defaults', 'options', 'sort', 'deleted'] as $key) {
            $this->$key = $data->$key;
        }
    }
    
    public function save() {
        if ($this->id) {
            $data = [
                'name'      => $this->name,
                'position'  => $this->position,
                'required'  => $this->required,
                'defaults'  => $this->defaults,
                'options'   => $this->options,
                'sort'      => $this->sort
            ];
            
            Helper::DB_update('templates_fields', $data, ['id' => $this->id]);
        }
        else {
            $data = [
                'template_id' => $this->template_id,
                'name'        => $this->name,
                'position'    => $this->position,
                'type'        => $this->type
            ];
            
            Helper::DB_insert('templates_fields', $data);
        }
    }
    
    public static function fetchAll($template_id = 0, $deleted=0) {
        if ($deleted == 1) {
            $deleted = "";
        }
        else {
            $deleted = " AND deleted = 0";
        }
        
        $sql = "SELECT * FROM templates_fields WHERE template_id=?".$deleted." ORDER BY position ASC, sort ASC";
        
        $sth = VC::db()->prepare($sql);
        $sth->execute([$template_id]);
        
        return $sth->fetchAll();
    }
    
    public function delete() {
        Helper::DB_update('templates_fields', ['deleted' => 1], ['id' => $this->id]);
    }
}