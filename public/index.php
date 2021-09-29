<?php
include '/Applications/MAMP/htdocs/lesson-project-php-mvc/app/lib/function.php';
echo 123;
$routes = [
    "/lesson-project-php-mvc/public/home" => 'functions/homepage.php',
    "/php/lessons_php/module_1/about" => 'functions/about.php',
    "/php/lessons_php/module_1/edit.php" => 'functions/about.php'
];

$route = $_SERVER['REQUEST_URI'];
//dd($route);
if(array_key_exists($route, $routes))
{
    //dd($routes[$route]);
    include '/Applications/MAMP/htdocs/lesson-project-php-mvc/'.$routes[$route];exit;
}
else
{
    dd(404);
}

