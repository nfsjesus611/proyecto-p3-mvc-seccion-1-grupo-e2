<?php
	
	class Database {
	    private static $instance = null;
	    private $pdo;

	    private function __construct() {
	        $host = 'localhost';
	        $db   = 'mlt_capacitacion2';
	        $user = 'root';
	        $pass = '';
	        $this->pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
	        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    }

	    public static function getInstance() {
	        if (!self::$instance) {
	            self::$instance = new Database();
	        }
	        return self::$instance;
	    }

	    public function getConnection() {
	        return $this->pdo;
	    }
	}
 ?>