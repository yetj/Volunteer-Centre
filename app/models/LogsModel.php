<?php

class LogsModel {
    public $member_id;
    public $date;
    public $ip;
    public $project_id;
    public $controller;
    public $action;
    
    public function __construct($member = null, $project = null, $controller = null, $action = null) {
        $this->member_id = $member;
        $this->project_id = isset($project) ? $project : 0;
        $this->controller = $controller;
        $this->action = $action;
        
        if ($this->member_id != null && $this->project_id != null && $this->controller != null && $this->action != null) {
            self::save();
        }
    }

    /**
     * @param mixed $member_id
     */
    public function setMember($member_id)
    {
        $this->member_id = $member_id;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @param mixed $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * @param mixed $project_id
     */
    public function setProject($project_id)
    {
        $this->project_id = $project_id;
    }

    /**
     * @param mixed $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }
    
    public function save() {
        $this->date = time();
        $this->ip = $_SERVER['REMOTE_ADDR'];
        
        $data = [
            'member_id' => $this->member_id,
            'date' => $this->date,
            'ip' => $this->ip,
            'project_id' => $this->project_id,
            'controller' => $this->controller,
            'action' => $this->action
        ];
        
        return Helper::DB_insert('logs', $data);
    }
    
    public static function getAll($start = 0, $end = -1) {
        $limit = "";
        
        if($start >= 0 && $end > 0) {
            $limit = " LIMIT ".$start.", ".$end;
        }
        
        $query = 'SELECT l.id, CONCAT(m.name, " - ", m.email) AS name, l.date, l.ip, p.name AS project, l.controller, l.action 
                  FROM `logs` AS l 
                  LEFT JOIN members AS m ON (m.id = l.member_id) 
                  LEFT JOIN projects AS p ON (p.id = l.project_id)
                  ORDER BY l.date DESC';
        
        $sql = VC::db()->prepare($query . $limit);
        $sql->execute();
        return $sql->fetchAll();
    }
    
    public function getAllByProject($projectID, $start = 0, $end = -1) {
        $limit = "";
        
        if($start >= 0 && $end > 0) {
            $limit = " LIMIT ".$start.", ".$end;
        }
        
        $query = 'SELECT l.id, CONCAT(m.name, " - ", m.email) AS name, l.date, l.ip, l.controller, l.action
                  FROM `logs` AS l
                  LEFT JOIN members AS m ON (m.id = l.member_id)
                  WHERE l.project_id=?
                  ORDER BY l.date DESC';
        
        $sql = VC::db()->prepare($query . $limit);
        
        $sql->execute([$projectID]);
        return $sql->fetchAll();
    }
    
}