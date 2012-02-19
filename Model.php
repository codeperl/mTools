<?php
class Model{
    
    private $db = null;
    private $tableName = null;
    protected $data = array();
    
    public function __construct($db, $tableName){
        $this->db = $db;
        $this->tableName = $tableName;
    }
    
    public function viewAll($type='', $columns='') {
        return $this->db->viewAll($this->tableName, $columns, $type);
    }

    public function viewById($type='', $columns='', $id) {
        return $this->db->viewById($this->tableName, $columns, $id, $type);
    }

    public function viewBy($type='', $columns='', $columnName, $columnValue) {
        return $this->db->viewBy($this->tableName, $columns, $columnName, $columnValue, $type);
    }

    public function deleteAll() {
        return $this->db->deleteAll($this->tableName);
    }

    public function deleteById($id) {
        return $this->db->deleteById($this->tableName, $id);
    }

    public function deleteBy($columnName, $columnValue) {
        return $this->db->deleteBy($this->tableName, $columnName, $columnValue);
    }
    
    public function insert(){
        return $this->db->insert($this->tableName, $this->data);
    }
    
    public function updateAll(){
        return $this->db->updateAll($this->tableName, $this->data);
    }
    
    public function updateById($id){
        return $this->db->updateById($this->tableName, $this->data, $id);
    }
    
    public function updateBy($columnName, $columnValue){
        return $this->db->updateBy($this->tableName, $this->data, $columnName, $columnValue);
    }
}
?>
