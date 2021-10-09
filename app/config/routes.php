<?php
return [
    '/' => [
        'controller' => 'users',
        'action' => 'users',   
    ],
    '/user/{id:\d+}' => [
        'controller' => 'users',
        'action' => 'user_profile',   
    ],
    '/edit/{id:\d+}' => [
        'controller' => 'users',
        'action' => 'edit',   
    ],
    '/media/{id:\d+}' => [
        'controller' => 'users',
        'action' => 'media',   
    ],
    '/mediaSet/{id:\d+}' => [
        'controller' => 'users',
        'action' => 'mediaSet',   
    ],
    '/statusShow/{id:\d+}' => [
        'controller' => 'users',
        'action' => 'statusShow',   
    ],
    '/statusSet/{id:\d+}' => [
        'controller' => 'users',
        'action' => 'statusSet',   
    ],
    '/create_user' => [
        'controller' => 'users',
        'action' => 'create_user',   
    ],
    '/security/{id:\d+}' => [
            'controller' => 'users',
            'action' => 'security',   
        ],
    '/change_email/{id:\d+}' => [
        'controller' => 'users',
        'action' => 'change_email',   
    ],
    '/search' => [
        'controller' => 'users',
        'action' => 'search',   
    ],



    '/register' => [
        'controller' => 'auth',
        'action' => 'page_register',   
    ],
    '/login' => [
        'controller' => 'auth',
        'action' => 'page_login',   
    ],
    
    '/logout' => [
        'controller' => 'auth',
        'action' => 'logout',   
    ],
    '/confirm_password/{id:\d+}' => [
        'controller' => 'auth',
        'action' => 'confirm_password',   
    ],
    '/delete/{id:\d+}' => [
        'controller' => 'auth',
        'action' => 'delete',   
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
