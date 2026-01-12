<?php

class ActionModel {
    public $id;
    public $project_id;
    public $name;
    public $logo;
    public $logo_type;
    public $template_id;
    public $start;
    public $end;
    public $description_short;
    public $description_long;
    public $status;
    

    /**
     * @param mixed $project_id
     */
    public function setProjectID($project_id)
    {
        $this->project_id = $project_id;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    /**
     * @param mixed $logo_type
     */
    public function setLogoType($logo_type)
    {
        $this->logo_type = $logo_type;
    }

    /**
     * @param mixed $template_id
     */
    public function setTemplateID($template_id)
    {
        $this->template_id = $template_id;
    }

    /**
     * @param mixed $start
     */
    public function setStart($start)
    {
        $this->start = $start;
    }

    /**
     * @param mixed $end
     */
    public function setEnd($end)
    {
        $this->end = $end;
    }

    /**
     * @param mixed $description_short
     */
    public function setDescriptionShort($description_short)
    {
        $this->description_short = $description_short;
    }

    /**
     * @param mixed $description_long
     */
    public function setDescriptionLong($description_long)
    {
        $this->description_long = $description_long;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function __construct($action = null) {
        if ($action) {
            $this->id = $action;
            $this->loadAction();
        }
    }
    
    private function loadAction() {
        $sql = "SELECT * FROM actions WHERE id=?";
        $sth = VC::db()->prepare($sql);
        $sth->execute([$this->id]);
        $data = $sth->fetch();
        
        if (!$data) {
            throw new PageDoesNotExistException("Wybrana akcja nie istnieje.");
        }
        
        foreach (["name", 'description_short', 'description_long', 'logo', 'logo_type', 'template_id', 'project_id', 'start', 'end', 'status'] as $key) {
            $this->$key = $data->$key;
        }
    }
    
    public function save() {
        if ($this->id) {
            $data = [
                'name' => $this->name,
                'description_short'  => $this->description_short,
                'description_long'  => $this->description_long,
                'logo'  => $this->logo,
                'logo_type'  => $this->logo_type,
                'template_id'  => $this->template_id,
                'start'  => $this->start,
                'end'  => $this->end,
                'status' => $this->status
            ];
            
            Helper::DB_update('actions', $data, ['id' => $this->id]);
        }
        else {
            $data = [
                'name' => $this->name,
                'description_short'  => $this->description_short,
                'description_long'  => $this->description_long,
                'logo'  => $this->logo,
                'logo_type'  => $this->logo_type,
                'template_id'  => $this->template_id,
                'project_id'  => $this->project_id,
                'start'  => $this->start,
                'end'  => $this->end
            ];
            
            Helper::DB_insert('actions', $data);
        }
    }
    
    public static function fetchAll($project_id = 0) {
        $sql = "SELECT * FROM actions WHERE project_id = ?";
        
        $sth = VC::db()->prepare($sql);
        $sth->execute([$project_id]);
        
        return $sth->fetchAll();
    }
    
    public static function fetchAllApps($project_id = 0) {
        $sql = "SELECT a.id, a.name, a.start, a.end, a.status, count(app.id) as sum FROM actions a LEFT JOIN applications app ON (app.action_id = a.id) WHERE a.project_id = ? GROUP BY app.action_id";
        
        $sth = VC::db()->prepare($sql);
        $sth->execute([$project_id]);
        
        return $sth->fetchAll();
    }
    
    public static function fetchActive($project_id = 0) {
        $sql = "";
        if ($project_id == 1) {
            $sql = "SELECT a.*, p.name as project_name, p.slug as project_slug FROM actions as a JOIN projects p ON (a.project_id = p.id) WHERE a.status = 1 AND p.status = 1 AND a.end > UNIX_TIMESTAMP() ORDER BY end ASC";
        }
        else {
            $sql = "SELECT * FROM actions WHERE project_id = ? AND status = 1";
        }
        
        $sth = VC::db()->prepare($sql);
        $sth->execute([$project_id]);
        
        return $sth->fetchAll();
    }
    
    public static function fetchTotal() {
        $sql = "SELECT count(id) sum FROM actions";
        
        $sth = VC::db()->prepare($sql);
        $sth->execute([]);
        
        return $sth->fetch();
    }
    
    public function delete() {
        Helper::DB_delete('actions', ['id' => $this->id]);
    }
}