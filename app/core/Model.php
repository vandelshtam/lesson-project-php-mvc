<?php
namespace App\Core;

use Database\MakePdo;

abstract class  Model{

    public $db;
    public function __construct(){
        $this->db = MakePdo::query();
    }
}