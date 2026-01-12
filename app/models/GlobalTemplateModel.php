<?php 

class GlobalTemplateModel {
    public $id;
    public $name;
    public $img;
    public $img_type;
    public $parts;
    public $html;
    public $deleted;
    
    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $img
     */
    public function setImg($img)
    {
        $this->img = $img;
    }

    /**
     * @param mixed $img_type
     */
    public function setImgType($imgType)
    {
        $this->img_type = $imgType;
    }

    /**
     * @param mixed $parts
     */
    public function setParts($parts)
    {
        $this->parts = $parts;
    }

    /**
     * @param mixed $html
     */
    public function setHtml($html)
    {
        $this->html = $html;
    }

    public function __construct($globalTemplate = null) {
        if ($globalTemplate) {
            $this->id = $globalTemplate;
            $this->loadGlobalTemplate();
        }
    }
    
    private function loadGlobalTemplate() {
        $sql = "SELECT * FROM global_templates WHERE id=?";
        $sth = VC::db()->prepare($sql);
        $sth->execute([$this->id]);
        $data = $sth->fetch();
        
        if (!$data) {
            throw new PageDoesNotExistException("Wybrany globalny szablon nie istnieje.");
        }
        
        foreach (["name", 'img', 'img_type', 'parts', 'html', 'deleted'] as $key) {
            $this->$key = $data->$key;
        }
    }
    
    public function save() {
        if ($this->id) {
            $data = [
                'name' => $this->name,
                'img'  => $this->img,
                'img_type'  => $this->img_type,
                'parts'  => $this->parts,
                'html' => $this->html
            ];
            
            Helper::DB_update('global_templates', $data, ['id' => $this->id]);
        }
        else {
            $data = [
                'name' => $this->name,
                'img'  => $this->img,
                'img_type'  => $this->img_type,
                'parts'  => $this->parts,
                'html' => $this->html
            ];
            
            Helper::DB_insert('global_templates', $data);
        }
    }
    
    public static function fetchAll() {
        $sql = "SELECT * FROM global_templates WHERE deleted = 0";
        
        $sth = VC::db()->prepare($sql);
        $sth->execute();
        
        return $sth->fetchAll();
    }
    
    public function delete() {
        Helper::DB_update('global_templates', ['deleted' => 1], ['id' => $this->id]);
    }
}