<?php
return [
    '/home' => [
        'controller' => 'users',
        'action' => 'home',   
    ],
    '/' => [
        'controller' => 'users',
        'action' => 'index',   
    ],
    '/user/1' => [
        'controller' => 'users',
        'action' => 'user',   
    ],
    '/posts' => [
        'controller' => 'posts',
        'action' => 'posts',   
    ],
    '/post/1' => [
        'controller' => 'posts',
        'action' => 'post',   
    ],
];



/*
$routes = [
    "/php/lessons_php/module_1/home" => 'functions/homepage.php',
    "/php/lessons_php/module_1/about" => 'functions/about.php',
    "/php/lessons_php/module_1/edit.php" => 'functions/about.php'
];

$route = $_SERVER['REQUEST_URI'];

if(array_key_exists($route, $routes))
{
    //dd($routes[$route]);
    include '/Applications/MAMP/htdocs/php/lessons_php/module_1/'.$routes[$route];exit;
}
else
{
    dd(404);
}
*/