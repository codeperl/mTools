<?php

require_once "Database.php";
require_once "Query.php";
require_once "Insertable.php";
require_once "Updatable.php";
require_once "Deletable.php";
require_once "Viewable.php";

class MySQL extends Database implements Query, Insertable, Updatable, Deletable, Viewable {

    private $database;
    private $connection;
    private $selectedDB;
    private $query;
    private $result;

    public function __construct($host, $user, $password, $database) {
        parent::__construct($host, $user, $password);
        $this->database = $database;
        try {
            $this->connection();
            $this->selectDB();
        } catch (Exception $exception) {
            echo $exception->getMessage();
            exit;
        }
    }

    public function setHost($host) {
        $this->host = $host;
    }

    public function getHost() {
        return $this->host;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function getUser() {
        return $this->user;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setDatabase($database) {
        $this->database = $database;
    }

    public function getDatabase() {
        return $this->database;
    }

    public function getConnection($connection) {
        return $this->connection;
    }

    public function setSelectedDB($selectedDB) {
        $this->selectedDb = $selectedDB;
    }

    public function setQuery($query) {
        $this->query = $query;
    }

    public function getResult() {
        return $this->result;
    }

    public function connection($host='', $user='', $password='') {
        if ($host) {$this->host = $host;}
        if ($user) {$this->user = $user;}
        if ($password) {$this->password = $password;}

        try {
            $this->connection = mysql_connect($this->host, $this->user, $this->password);
        } catch (Exception $exception) {
            echo $exception->getMessage();
            exit;
        }
        return $this->connection;
    }

    public function selectDB($databaseName='') {
        if ($databaseName) {$this->database = $databaseName;}
        try {
            $this->selectedDB = mysql_select_db($this->database, $this->connection);
        } catch (Exception $exception) {
            echo $exception->getMessage();
            exit;
        }
        return $this->selectedDB;
    }

    public function query($query) {
        if ($query) {
            try {
                $this->query = mysql_query($query, $this->connection);
            } catch (Exception $exception) {
                echo $exception->getMessage();
                exit;
            }
        }
        return $this->query;
    }

    public function insert($tableName, $modelProperties) {
        $columnNames = implode(", ", array_keys($modelProperties));
        $columnValues = implode("', '", array_values($modelProperties));
        try{
            $query = "INSERT INTO $tableName ($columnNames) VALUES ('$columnValues')";
            return $this->query($query);
        }catch(Exception $exception){
            echo $exception->getMessage();
            exit;
        }
    }

    public function updateAll($tableName, $modelProperties) {
        $columnsAndValues = $this->getColumnsAndValues($modelProperties);
        try{
            $query = "UPDATE $tableName SET $columnsAndValues";
            return $this->query($query);
        }catch(Exception $exception){
            echo $exception->getMessage();
            exit;

        }
    }

    public function updateById($tableName, $modelProperties, $id) {
        $columnsAndValues = $this->getColumnsAndValues($modelProperties);
        try{
            $query = "UPDATE $tableName SET $columnsAndValues WHERE id=".$id;
            return $this->query($query);
        }catch(Exception $exception){
            echo $exception->getMessage();
            exit;
        }
    }

    public function updateBy($tableName, $modelProperties, $columnName, $columnValue) {
        $columnsAndValues = $this->getColumnsAndValues($modelProperties);
        try{
            $query = "UPDATE $tableName SET $columnsAndValues WHERE $columnName='$columnValue'";
            return $this->query($query);
        }catch(Exception $exception){
            echo $exception->getMessage();
            exit;
        }
    }
    
    public function getColumnsAndValues($modelProperties){
        $array = array();
        
        foreach($modelProperties as $key=>$value){
            $array[] = "$key='$value'";
        }
        
        return $columnsAndValues = implode(",", $array);
    }

    public function deleteAll($tableName) {
        try {
            $query = "DELETE FROM $tableName";
            return $this->query($query);
        } catch (Exception $exception) {
            echo $exception->getMessage();
            exit;
        }
    }

    public function deleteById($tableName, $id) {
        try {
            $query = "DELETE FROM $tableName WHERE id=" . $id;
            return $this->query($query);
        } catch (Exception $exception) {
            echo $exception->getMessage();
            exit;
        }
    }

    public function deleteBy($tableName, $columnName, $columnValue) {
        try {
            $query = "DELETE FROM $tableName WHERE $columnName='" . $columnValue . "'";
            return $this->query($query);
        } catch (Exception $exception) {
            echo $exception->getMessage();
            exit;
        }
    }

    public function viewAll($tableName, $columns, $type) {
        $data = null;
        try {
            $columnNames = $this->getColumnNames($columns);
            $query = "SELECT $columnNames FROM $tableName";
            $this->query($query);
            if ($type == 'object') {
                $data = $this->fetchObject();
            } else if ($type == 'assoc') {
                $data = $this->fetchAssoc();
            } else {
                $data = $this->fetchArray();
            }
            return $data;
        } catch (Exception $exception) {
            echo $exception->getMessage();
            exit;
        }
    }

    public function viewById($tableName, $columns, $id, $type) {
        $data = null;
        try {
            $columnNames = $this->getColumnNames($columns);
            $query = "SELECT $columnNames FROM $tableName WHERE id=" . $id;
            $this->query($query);
            if ($type == 'object') {
                $data = $this->fetchObject();
            } else if ($type == 'assoc') {
                $data = $this->fetchAssoc();
            } else {
                $data = $this->fetchArray();
            }
            return $data;
        } catch (Exception $exception) {
            echo $exception->getMessage();
            exit;
        }
    }

    public function viewBy($tableName, $columns, $columnName, $columnValue, $type) {
        $data = null;
        try {
            $columnNames = $this->getColumnNames($columns);
            $query = "SELECT $columnNames FROM $tableName WHERE $columnName='" . $columnValue . "'";
            $this->query($query);
            if ($type == 'object') {
                $data = $this->fetchObject();
            } else if ($type == 'assoc') {
                $data = $this->fetchAssoc();
            } else {
                $data = $this->fetchArray();
            }
            return $data;
        } catch (Exception $exception) {
            echo $exception->getMessage();
            exit;
        }
    }

    public function getColumnNames($columns) {
        $columnNames = '*';
        if (is_array($columns)) {
            if ($columns) {
                $columnNames = implode(', ', $columns);
            }
        }
        return $columnNames;
    }

    public function fetchArray() {
        try {
            while ($result = mysql_fetch_array($this->query)) {
                $this->result[] = $result;
            }
        } catch (Exception $exception) {
            echo $exception->getMessage();
            exit;
        }
        return $this->result;
    }

    public function fetchAssoc() {
        try {
            while ($result = mysql_fetch_assoc($this->query)) {
                $this->result[] = $result;
            }
        } catch (Exception $exception) {
            echo $exception->getMessage();
            exit;
        }
        return $this->result;
    }

    public function fetchObject() {
        try {
            while ($result = mysql_fetch_object($this->query)) {
                $this->result[] = $result;
            }
        } catch (Exception $exception) {
            echo $exception->getMessage();
            exit;
        }
        return $this->result;
    }

}

?>
