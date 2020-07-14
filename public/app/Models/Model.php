<?php

namespace Frontend\Models;


use PDO;

class Model
{
    public $db;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
      $this->db= new PDO("mysql:host=".DB['host'].";dbname=".DB['name'], DB['user'], DB['password']);
    }
}