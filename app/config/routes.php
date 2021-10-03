<?php
return [
    '/' => [
        'controller' => 'users',
        'action' => 'users',   
    ],
    '/user' => [
        'controller' => 'users',
        'action' => 'user_profile',   
    ],
    '/edit/1' => [
        'controller' => 'users',
        'action' => 'edit',   
    ],
    '/media' => [
        'controller' => 'users',
        'action' => 'media',   
    ],
    '/status' => [
        'controller' => 'users',
        'action' => 'status',   
    ],
    '/create_user' => [
        'controller' => 'users',
        'action' => 'create_user',   
    ],

    '/register' => [
        'controller' => 'auth',
        'action' => 'page_register',   
    ],
    '/login' => [
        'controller' => 'auth',
        'action' => 'page_login',   
    ],
    '/security' => [
        'controller' => 'auth',
        'action' => 'security',   
    ],
    '/logout' => [
        'controller' => 'auth',
        'action' => 'logot',   
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