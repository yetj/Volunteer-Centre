<?php

class ProjectRequestModel {
    public $id;
    public $name;
    public $short_description;
    public $long_description;
    public $status;
    public $requester_name;
    public $requester_email;
    public $requester_contact;
    
    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * @param mixed $short_description
     */
    public function setShort_description($short_description)
    {
        $this->short_description = $short_description;
    }
    
    /**
     * @param mixed $long_description
     */
    public function setLong_description($long_description)
    {
        $this->long_description = $long_description;
    }
    
    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
    
    /**
     * @param mixed $requester_name
     */
    public function setRequester_name($requester_name)
    {
        $this->requester_name = $requester_name;
    }
    
    /**
     * @param mixed $requester_email
     */
    public function setRequester_email($requester_email)
    {
        $this->requester_email = $requester_email;
    }
    
    /**
     * @param mixed $requester_contact
     */
    public function setRequester_contact($requester_contact)
    {
        $this->requester_contact = $requester_contact;
    }
    
    
    public function __construct($id = null) {
        if ($id) {
            $this->id = $id;
            $this->loadProject();
        }
    }
    
    private function loadProject() {
        $sql = "SELECT * FROM projects_requests WHERE id=?";
        $sth = VC::db()->prepare($sql);
        $sth->execute([$this->id]);
        $data = $sth->fetch();
        
        if (!$data) {
            throw new PageDoesNotExistException("Wybrane zgłoszenie projektu nie istnieje.");
        }
        
        foreach (['name', 'short_description', 'long_description', 'status', 'requester_name', 'requester_email', 'requester_contact'] as $key) {
            $this->$key = $data->$key;
        }
    }
    
    public function save() {
        if ($this->id) {
            $data = [
                'name'       => $this->name,
                'short_description' => $this->short_description,
                'long_description'  => $this->long_description,
                'status'     => $this->status,
                'requester_name'     => $this->requester_name,
                'requester_email'     => $this->requester_email,
                'requester_contact'     => $this->requester_contact
            ];
            
            Helper::DB_update('projects_requests', $data, ['id' => $this->id]);
        }
        else {
            $data = [
                'name'       => $this->name,
                'short_description' => $this->short_description,
                'long_description'  => $this->long_description,
                'status'     => $this->status,
                'requester_name'     => $this->requester_name,
                'requester_email'     => $this->requester_email,
                'requester_contact'     => $this->requester_contact
            ];
            
            $project_id = Helper::DB_insert('projects_requests', $data);
            PageModel::createSystemPages($project_id);
        }
    }
    
    public static function getAll() {
        
        $sql = "SELECT * FROM projects_requests ORDER BY status";
        
        $sth = VC::db()->prepare($sql);
        $sth->execute();
        
        return $sth->fetchAll();
    }
    
    public static function getWaitingCount() {
        $sql = "SELECT count(id) AS sum FROM projects_requests WHERE status = 0";
        
        $sth = VC::db()->prepare($sql);
        $sth->execute();
        
        return $sth->fetch();
    }
    
    public static function delete($id) {
        Helper::DB_delete('projects_requests', ['id' => $this->id]);
    }
    
}