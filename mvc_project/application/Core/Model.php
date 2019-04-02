<?php
namespace application\Core;

use application\Helpers\Validator;


class Model
{
    private $db;
    public $connection;
    public $validator;

    public function __construct()
    {
        $this->db = new Database();
        $this->connection = $this->db->getConnection();
        $this->validator = new Validator();
    }
}