<?php

class ApplicationReplyModel {
    public $id;
    public $application_id;
    public $field_id;
    public $value;
    
    /**
     * @param mixed $application_id
     */
    public function setApplicationID($application_id)
    {
        $this->application_id = $application_id;
    }

    /**
     * @param mixed $field_id
     */
    public function setFieldID($field_id)
    {
        $this->field_id = $field_id;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    public function save() {
        $data = [
            'application_id' => $this->application_id,
            'field_id'  => $this->field_id,
            'value'       => $this->value
        ];
        
        Helper::DB_insert('applications_reply', $data);
    }
    
    public function fetchAnswers($application_id) {
        $sql = "
            SELECT f.name, ar.value FROM applications_reply AS ar
                LEFT JOIN templates_fields AS f ON (ar.field_id = f.id)
            WHERE ar.application_id=?";
        $sth = VC::db()->prepare($sql);
        $sth->execute([$application_id]);
        return $sth->fetchAll();
    }
}