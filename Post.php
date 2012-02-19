<?php

require_once "Model.php";

class Post extends Model{

    private $className = 'Post';
    private $tableName = 'posts';
    private $columnsName = array("id", "title", "content");
    
    public function __construct($db) {
        parent::__construct($db, $this->tableName);
    }

    public function __set($property, $value) {
        if (!in_array($property, $this->columnsName)) {
            return null;
        }
        $this->data[$property] = $value;
    }

    public function __get($property) {
        if (isset($this->data[$property]) === true) {
            return $this->data[$property];
        }
    }
    
}

?>
