<?php

class ProjectModel {
    public $id;
    public $name;
    public $slug;
    public $logo;
    public $short_description;
    public $long_description;
    public $owner_id = 0;
    public $settings = [];
    public $status = 0;
    
    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug ? Helper::toAscii($slug) : Helper::toAscii($title);
        if(!$this->slug) {
            $this->slug = 'project_'.$this->id;
        }
    }

    /**
     * @param mixed $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
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
     * @param mixed $owner_id
     */
    public function setOwner_id($owner_id)
    {
        $this->owner_id = $owner_id;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @param mixed $settings
     */
    public function setSettings($settings)
    {
        $this->settings = $settings;
    }

    public function __construct($id = null) {
        if ($id) {
            $this->id = $id;
            $this->loadProject();
        }
    }
    
    private function loadProject() {
        $sql = "SELECT * FROM projects WHERE id=?";
        $sth = VC::db()->prepare($sql);
        $sth->execute([$this->id]);
        $data = $sth->fetch();
        
        if (!$data) {
            throw new PublicException("Wybrany projekt nie istnieje.");
        }
        
        foreach (['name', 'slug', 'logo', 'short_description', 'long_description', 'owner_id', 'status', 'settings'] as $key) {
            $this->$key = $data->$key;
        }
    }
    
    public function save() {
        if ($this->id) {
            $data = [
                'name'       => $this->name,
                'slug'       => $this->slug,
                'logo'       => $this->logo,
                'short_description' => $this->short_description,
                'long_description'  => $this->long_description,
                'owner_id'   => $this->owner_id,
                'status'     => $this->status
            ];
            
            Helper::DB_update('projects', $data, ['id' => $this->id]);
        }
        else {
            $data = [
                'name'       => $this->name,
                'slug'       => $this->slug,
                'logo'       => $this->logo,
                'short_description' => $this->short_description,
                'long_description'  => $this->long_description,
                'owner_id'   => $this->owner_id,
                'status'     => $this->status
            ];
            
            $project_id = Helper::DB_insert('projects', $data);
            
            if (!$project_id) {
                throw new PublicException("Błąd dodawania nowego projektu");
            }
            PageModel::createSystemPages($project_id);
        }
    }
    
    public static function getOne($slug) {
        
        $sql = "SELECT * FROM projects WHERE slug = ?";
        
        $sth = VC::db()->prepare($sql);
        $sth->execute([$slug]);
        
        return $sth->fetch();
    }
    
    public static function getAll() {
        
        $sql = "SELECT * FROM projects";
        
        $sth = VC::db()->prepare($sql);
        $sth->execute();
        
        return $sth->fetchAll();
    }
    
    public function delete() {
        Helper::DB_delete('projects', ['id' => $this->id]);
        Helper::DB_delete('pages', ['project_id' => $this->id]);
        Helper::DB_delete('projects_access', ['project_id' => $this->id]);
    }
    
    public static function getByID($id) {
        $sql = "SELECT * FROM projects WHERE id=?";
        
        $sth = VC::db()->prepare($sql);
        $sth->execute([$id]);
        
        return $sth->fetch();
    }
    
    public static function getByUser($member_id, $excludeAdminPowers = false) {
        $member = new MemberModel($member_id);
        $sql = "";
        if ($member->access & MemberModel::ADMIN_ACCESS_ALL_PROJECTS && $excludeAdminPowers == false) {
            $sql = "SELECT *, 127 AS access FROM projects";
            $sth = VC::db()->prepare($sql);
            $sth->execute();
        }
        else {
            $sql = "SELECT p.*, a.access FROM projects_access a JOIN projects p ON a.project_id = p.id WHERE a.member_id = ? ORDER BY name";
            $sth = VC::db()->prepare($sql);
            $sth->execute([$member_id]);
        }
        
        $data = $sth->fetchAll();
        
        $results = [];
        foreach ($data as $rec) {
            $results[$rec->id] = $rec;
        }
        return $results;
    }
    
    public static function addAccess($project_id, $member_id) {
        Helper::DB_insert('projects_access', ['project_id' => $project_id, 'member_id' => $member_id]);
    }
    
    public static function removeAccess($project_id, $member_id) {
        Helper::DB_delete('projects_access', ['project_id' => $project_id, 'member_id' => $member_id]);
    }
    
    public static function getAccess($project_id, $member_id) {
        $sql = "SELECT access FROM projects_access WHERE project_id=? AND member_id=?";
        $sth = VC::db()->prepare($sql);
        $sth->execute([$project_id, $member_id]);
        return $sth->fetch();
    }
    
    public static function hasAccess($project_id, $member_id) {
        $sql = "SELECT member_id FROM projects_access WHERE project_id=? AND member_id=?";
        $sth = VC::db()->prepare($sql);
        $sth->execute([$project_id, $member_id]);
        return $sth->fetch();
    }
    
    public static function setAccess($project_id, $member_id, $access) {
        Helper::DB_update('projects_access', ['access' => $access], ['project_id' => $project_id, 'member_id' => $member_id]);
    }
    /*
    public static function setSettings($project_id, $data) {
        Helper::DB_update('projects', $data, ['id' => $project_id]);
    }
    */
    
}