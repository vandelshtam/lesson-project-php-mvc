<?php

namespace Database;


use Database\QueryBuilder;
use Database\Connection;

class MakePdo{
    
    public static function query()
    {
        $config = include '/Applications/MAMP/htdocs/lesson-project-php-mvc/database/config.php';
        return  new QueryBuilder(Connection::make($config['database']));
   
    }

}
