<?php

class Config {

    private static $dbConfig = array();
    private static $defaultDbConfig = "";

    public function __construct() {
        
    }

    public static function setDbConfig($dbConfig=null) {
        if (!$dbConfig) {
            static::$dbConfig = array(
                "Default"=>array(
                    "database" => "MySQL",
                    "host" => "localhost",
                    "user" => "root",
                    "password" => "",
                    "dbName" => "testdbs"
                ),
                "Production"=>array(
                    "database" => "MySQL",
                    "host" => "localhost",
                    "user" => "root",
                    "password" => "",
                    "dbName" => "testdbs"
                ),
                "Development"=>array(
                    "database" => "MySQL",
                    "host" => "localhost",
                    "user" => "root",
                    "password" => "",
                    "dbName" => "testdbs"
                ),
                "Test"=>array(
                    "database" => "MySQL",
                    "host" => "localhost",
                    "user" => "root",
                    "password" => "",
                    "dbName" => "testdbs"
                )
            );
        } else {
            static::$dbConfig = $dbConfig;
        }
    }

    public static function getDbConfig() {
        if (!static::$dbConfig) {
            static::setDbConfig();
        }
        return static::$dbConfig;
    }
    
    public static function setDefaultDbConfig($defaultDbConfig=null){
        if(!$defaultDbConfig){
            static::$defaultDbConfig = "Default";
        }else{
            static::$defaultDbConfig =  $defaultDbConfig;
        }
    }
    
    public static function getDefaultDbConfig(){
        if(!static::$defaultDbConfig){
            static::setDefaultDbConfig();
        }
        return static::$defaultDbConfig;
    }

}

?>
