<?php

require_once "config.php";

final class Db {
    private $dbHost = DB_HOST;
    private $dbUser = DB_USER;
    private $dbPass = DB_PASS;
    private $dbName = DB_NAME;

    private static $instance = null;
    private $conn;

    private function __construct(){

        $this->conn = new PDO("mysql:host={$this->dbHost};
		dbname={$this->dbName}", $this->dbUser,$this->dbPass,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }

    public static function getInstance() : Db{

        if(!self::$instance){
            self::$instance = new Db();
        }

        return self::$instance;
    }

    public function getConnection(){
        return $this->conn;
    }

    private function __clone(){
    }

    private function __wakeup(){
    }

    public function __destruct() {
        if ( isset($this->conn) ) {
            $this->conn = null;
        }
    }
}