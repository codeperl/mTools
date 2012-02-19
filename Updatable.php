<?php

interface Updatable {

    public function updateAll($tableName, $modelProperties);

    public function updateById($tableName, $modelProperties, $id);

    public function updateBy($tableName, $modelProperties, $columnName, $columnValue);
}

?>
