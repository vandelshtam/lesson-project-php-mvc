<?php
require '/Applications/MAMP/htdocs/lesson-project-php-mvc/app/lib/function.php';

use App\Core\Router;

spl_autoload_register(function($class){
    $pach = str_replace('\\', '/', '/Applications/MAMP/htdocs/lesson-project-php-mvc/'.$class.'.php');
    if(file_exists($pach)){
        require $pach;
    }
});

$router = new Router;
$router->run();