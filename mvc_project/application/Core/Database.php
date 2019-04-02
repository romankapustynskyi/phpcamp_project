<?php
namespace application\Core;

class Database
{
    private $connection;

    public function __construct()
    {
        $this->connection = new \mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        
        if(!$this->connection) {
            echo "Error :" . mysqli_error($this->connection);
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}