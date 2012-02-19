<?php

interface Deletable {

    public function deleteAll($tableName);

    public function deleteById($tableName, $id);

    public function deleteBy($tableName, $columnName, $columnValue);
}

?>