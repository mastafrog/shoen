<?php

class Database
{
    private $_connection;
    private static $_instance;
    private $_host;
    private $_username;
    private $_password = '';
    private $_database = 'c9';
    
    
    /* Cloud9 specific
    servername = getenv('IP');
    $username = getenv('C9_USER');
    $password = "";
    $database = "c9";
    $dbport = 3306;
    
    Get an instance of the Database
    @return Instance
    */
    
    public static function getInstance()
    {
        if (!self::$_instance) { // If no instance then make one
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    
    // Constructor
    /*private*/ function __construct()
    {
        $this->_host =  getenv('IP');
        $this->_username = getenv('C9_USER');
        
        try {
            $this->_connection  = new \PDO("mysql:host=$this->_host;dbname=$this->_database", $this->_username, $this->_password);
            /*** echo a message saying we have connected ***/
            echo 'Connected to database';
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    
    // Magic method clone is empty to prevent duplication of connection
    private function __clone()
    {
    }
    
    
    // Get mysql pdo connection
    public function getConnection()
    {
        return $this->_connection;
    }
}
