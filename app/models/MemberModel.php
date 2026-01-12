<?php

class MemberModel {
    const SESSION_VALID_TIME = 86400;
    
    const ADMIN_ACCESS_PROJECTS = 1;
    const ADMIN_ACCESS_MEMEBERS = 2;
    const ADMIN_ACCESS_TEMPLATES = 4;
    const ADMIN_ACCESS_LOGS = 8;
    const ADMIN_ACCESS_ALL_PROJECTS = 16;
    
    const PROJECT_ACCESS_USERS = 1;
    const PROJECT_ACCESS_PAGES = 2;
    const PROJECT_ACCESS_TEMPLATES = 4;
    const PROJECT_ACCESS_ACTIONS = 8;
    const PROJECT_ACCESS_APPLICATIONS = 16;
    const PROJECT_ACCESS_SETTINGS = 32;
    const PROJECT_ACCESS_LOGS = 64;
    
	public $id;
	public $email;
	public $name;
	public $joined;
	public $login_key;
	public $login_key_expire;
	public $password;
	public $salt;
	public $access;

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $joined
     */
    public function setJoined($joined)
    {
        $this->joined = $joined;
    }

    /**
     * @param mixed $login_key
     */
    public function setLogin_key($login_key)
    {
        $this->login_key = $login_key;
    }

    /**
     * @param mixed $login_key_expire
     */
    public function setLogin_key_expire($login_key_expire)
    {
        $this->login_key_expire = $login_key_expire;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param mixed $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * @param mixed $access
     */
    public function setAccess($access)
    {
        $this->access = $access;
    }

    public function __construct($id = null) {
		if ($id) {
			$this->id = $id;
			$this->loadUserData();
		}
	}
	
	private function loadUserData() {
		$sql = VC::db()->prepare('SELECT * FROM members WHERE id=?');
		$sql->execute([$this->id]);
		$data = $sql->fetch();
		
		if (!$data) {
		    throw new PublicException("Wybrany użytkownik nie istnieje.");
		}
		
		foreach(["email", "name", "joined", "login_key", "login_key_expire", "password", "salt", "access"] as $key) {
			$this->$key = $data->$key;
		}
	}
	
	public function save() {
		if ($this->id) {
			$data = [
			    'email' => $this->email,
			    'name' => $this->name,
				'access' => $this->access
			];
			
			Helper::DB_update('members', $data, ['id' => $this->id]);
		}
		else {
		    $salt = self::generatePassword(5);
		    $password = hash('sha256', $this->password . '_VC_' . $salt);
		    
		    $data = [
		        'email' => $this->email,
		        'name' => $this->name,
		        'password' => $password,
		        'joined' => time(),
		        'salt' => $salt,
		        'access' => $this->access
		    ];
		    
		    return Helper::DB_insert('members', $data);
		}
	}
	
	public static function getAll($start = 0, $end = -1) {
	    $limit = "";
	    
	    if($start >= 0 && $end > 0) {
	        $limit = " LIMIT ".$start.", ".$end;
	    }
	    
	    $sql = VC::db()->prepare('SELECT id, email, name, access FROM members' . $limit);
	    $sql->execute();
	    return $sql->fetchAll();
	}
	
	public static function getAllByProject($projectID) {
	    $sql = VC::db()->prepare('SELECT m.id, m.email, m.access, a.access AS project_access 
            FROM projects_access AS a 
            JOIN members AS m ON (m.id = a.member_id) 
            WHERE project_id = ?');
	    $sql->execute([$projectID]);
	    return $sql->fetchAll();
	}
	
	public static function getCountAdmins() {
	    $sql = "SELECT COUNT(id) AS sum FROM members WHERE access > 0";
	    $sth = VC::db()->prepare($sql);
	    $sth->execute();
	    $data = $sth->fetch();
	    
	    return $data->sum;
	}
	
	public static function getCountMembers() {
	    $sql = "SELECT COUNT(id) AS sum FROM members WHERE access = 0";
	    $sth = VC::db()->prepare($sql);
	    $sth->execute();
	    $data = $sth->fetch();
	    
	    return isset($data->sum) ? $data->sum : 0;
	}
	
	public static function getCountMembersProject($memberID) {
	    $sql = "SELECT COUNT(id) AS sum FROM members m JOIN projects_access a ON (m.id = a.member_id) WHERE a.member_id = ? GROUP BY m.id";
	    $sth = VC::db()->prepare($sql);
	    $sth->execute([$memberID]);
	    $data = $sth->fetch();
	    
	    return isset($data->sum) ? $data->sum : 0;
	}
	
	public function changePassword() {
	    if ($this->id) {
	        $salt = self::generatePassword(5);
	        $password = hash('sha256', $this->password . '_VC_' . $salt);
	        
	        $data = [
	            'password' => $password,
	            'salt' => $salt,
	       ];
	        
	        Helepr::DB_update('members', $data, ['id' => $this->id]);
	    }
	}
	
	public function changeEmail() {
	    
	    $data = [
	        'email' => $this->email
	    ];
	    
	    Helepr::DB_update('members', $data, ['id' => $this->id]);
	    new LogsModel($this->member, $this->selectedProject, 'member', 'change_email');
	}
	
	public static function getByEmail($email) {
	    $sql = "SELECT id FROM members WHERE email=?";
	    $sth = VC::db()->prepare($sql);
	    $sth->execute([$email]);
	    
	    return $sth->fetch();
	}
	
	public static function fetchMemberIDBySessionID($sessionID) {
	    $sql = "SELECT id FROM members WHERE login_key=? AND login_key_expire > UNIX_TIMESTAMP()";
	    
	    $sth = VC::db()->prepare($sql);
	    $sth->execute([$sessionID]);
	    
	    return $sth->fetch();
	}
	
	public static function createSession($userID) {
	    $sessionID = md5(mt_rand() * time());
	    
	    $data = [
	        'login_key' => $sessionID,
	        'login_key_expire' => time()+self::SESSION_VALID_TIME
	    ];
	    
	    Helper::DB_update('members', $data, ['id' => $userID]);
	    
	    return $sessionID;
	}
	
	public function delete() {
	    Helper::DB_delete('members', ['id' => $this->id]);
	    Helper::DB_delete('projects_access', ['member_id' => $this->id]);
	}
	
	private function generateSalt() {
	    return generatePassword(5);
	}
	
	function generatePassword($length = 12) {
		$chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789`-=~!@#$%^&*()_+,./<>?;:[]{}\|';

		$str = '';
		$max = strlen($chars) - 1;

		for ($i=0; $i < $length; $i++) {
			$str .= $chars[rand(0, $max)];
		}

		return $str;
	}
	
}