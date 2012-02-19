<?php

interface Viewable {

    public function viewAll($tableName, $columnNames, $type);

    public function viewById($tableName, $columnNames, $id, $type);

    public function viewBy($tableName, $columnNames, $columnName, $columnValue, $type);
}

?>