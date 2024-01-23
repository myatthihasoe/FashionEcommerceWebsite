<?php
class Connection
{
    private $host, $dbname, $username, $password;

    function __construct($host, $dbname, $username, $password)
    {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
    }

    function getConnection()
    {
        try {
            $pdo = new PDO(
                "mysql:host=$this->host; dbname=$this->dbname; password=$this->password;",//set mysql password
                $this->username,
                // $this->password (use if no password)
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //For warning error in user mode
            return $pdo;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return NULL;
        }
    }
}
