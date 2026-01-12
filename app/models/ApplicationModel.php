<?php

class ApplicationModel {
    public $id;
    public $project_id;
    public $action_id;
    public $date;
    public $status;
    public $feedback;
    public $hash;
    
    /**
     * @param mixed $project_id
     */
    public function setProjectID($project_id)
    {
        $this->project_id = $project_id;
    }

    /**
     * @param mixed $action_id
     */
    public function setActionID($action_id)
    {
        $this->action_id = $action_id;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @param mixed $feedback
     */
    public function setFeedback($feedback)
    {
        $this->feedback = $feedback;
    }
    
    public function __construct($application = null) {
        if ($application) {
            $this->id = $application;
            $this->loadApplication();
        }
    }
    
    private function loadApplication() {
        $sql = "SELECT * FROM applications WHERE id=?";
        $sth = VC::db()->prepare($sql);
        $sth->execute([$this->id]);
        $data = $sth->fetch();
        
        if ($data) {
            foreach (["project_id", "action_id", "date", 'status', 'feedback', 'hash'] as $key) {
                $this->$key = $data->$key;
            }
        }
    }
    
    public function save() {
        if ($this->id) {
            $data = [
                'status' => $this->status,
                'feedback' => $this->feedback
            ];
            
            Helper::DB_update('applications', $data, ['id' => $this->id]);
        }
        else {
            $data = [
                'project_id' => $this->project_id,
                'action_id'  => $this->action_id,
                'date'       => time(),
                'hash'       => md5(MemberModel::generatePassword().microtime())
            ];
            
            return Helper::DB_insert('applications', $data);
        }
    }
    
    public function fetchAll($action_id) {
        $sql = "SELECT * FROM applications WHERE action_id = ? ORDER BY date DESC";
        
        $sth = VC::db()->prepare($sql);
        $sth->execute([$action_id]);
        
        return $sth->fetchAll();
    }
    
    public function fetchAllByProject($project_id) {
        $sql = "SELECT * FROM applications WHERE project_id = ?";
        
        $sth = VC::db()->prepare($sql);
        $sth->execute([$project_id]);
        
        return $sth->fetchAll();
    }
    
    public function fetchTotal() {
        $sql = "SELECT count(id) sum FROM applications";
        
        $sth = VC::db()->prepare($sql);
        $sth->execute();
        
        return $sth->fetch();
    }
    
    public function fetchVotes($application_id) {
        $sql = "SELECT * FROM applications_votes WHERE application_id = ?";
        
        $sth = VC::db()->prepare($sql);
        $sth->execute([$application_id]);
        
        return $sth->fetchAll();
    }
    
    public function isVoted($application_id, $member_id) {
        $sql = "SELECT * FROM applications_votes WHERE application_id = ? AND member_id = ?";
        
        $sth = VC::db()->prepare($sql);
        $sth->execute([$application_id, $member_id]);
        
        return $sth->fetch();
    }
    
    public function addVote($application_id, $member_id, $vote) {
        $data = [
            'application_id' => $application_id,
            'member_id'  => $member_id,
            'vote'  => $vote,
            'date'       => time()
        ];
        
        return Helper::DB_insert('applications_votes', $data);
    }
    
    public function averageVote($application_id) {
        $sql = "SELECT count(id) num, sum(vote) sum FROM applications_votes WHERE application_id = ?";
        
        $sth = VC::db()->prepare($sql);
        $sth->execute([$application_id]);
        
        return $sth->fetch();
    }
    
    public function addComment($application_id, $member_id, $comment) {
        $data = [
            'application_id' => $application_id,
            'member_id'  => $member_id,
            'comment'  => $comment,
            'date'       => time()
        ];
        
        return Helper::DB_insert('applications_comments', $data);
    }
    
    public function fetchComments($application_id) {
        $sql = "SELECT ac.*, m.name FROM applications_comments ac LEFT JOIN members m ON (m.id = ac.member_id) WHERE application_id = ? ORDER BY date ASC";
        
        $sth = VC::db()->prepare($sql);
        $sth->execute([$application_id]);
        
        return $sth->fetchAll();
    }
}