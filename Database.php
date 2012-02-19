<?php

abstract class Database {

    protected $host;
    protected $user;
    protected $password;

    public function __construct($host, $user, $password) {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
    }

    abstract public function connection($host, $user, $password);

    abstract public function selectDB($databaseName);
}

?>