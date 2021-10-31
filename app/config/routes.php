<?php
return [
    '/' => [
        'controller' => 'users',
        'action' => 'users',   
    ],
    '/users/users/{page:\d+}' => [
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
    '/setAdmin/{id:\d+}' => [
        'controller' => 'auth',
        'action' => 'setAdmin',   
    ],
    '/setUser/{id:\d+}' => [
        'controller' => 'auth',
        'action' => 'setUser',   
    ],
    '/confirm_password_delete_post/{id:\d+}' => [
        'controller' => 'auth',
        'action' => 'confirm_password_delete_post',   
    ],               



    '/posts' => [
        'controller' => 'posts',
        'action' => 'posts',   
    ],
    '/posts/posts/{page:\d+}' => [
        'controller' => 'posts',
        'action' => 'posts',   
    ],
    '/posts/pagination_comments/{page:\d+}' => [
        'controller' => 'posts',
        'action' => 'pagination_comments',   
    ],
    '/favoritesPosts' => [
        'controller' => 'posts',
        'action' => 'favoritesPosts',   
    ],
    '/myPosts/{id:\d+}' => [
        'controller' => 'posts',
        'action' => 'myPosts',   
    ],
    '/post/{id:\d+}' => [
        'controller' => 'posts',
        'action' => 'post',   
    ],
    '/addNewComment/{id:\d+}' => [
        'controller' => 'posts',
        'action' => 'addNewComment',   
    ],
    '/deleteComment/{id:\d+}' => [
        'controller' => 'posts',
        'action' => 'deleteComment',   
    ],
    '/editPost/{id:\d+}' => [
        'controller' => 'posts',
        'action' => 'editPost',   
    ],
    '/bannedPost/{id:\d+}' => [
        'controller' => 'posts',
        'action' => 'bannedPost',   
    ],
    '/unBannedPost/{id:\d+}' => [
        'controller' => 'posts',
        'action' => 'unBannedPost',   
    ],
    '/bannedComment/{id:\d+}' => [
        'controller' => 'posts',
        'action' => 'bannedComment',   
    ],
    '/unBannedComment/{id:\d+}' => [
        'controller' => 'posts',
        'action' => 'unBannedComment',   
    ],
    '/changeAvatar/{id:\d+}' => [
        'controller' => 'posts',
        'action' => 'changeAvatar',   
    ],
    '/addFavorites/{id:\d+}' => [
        'controller' => 'posts',
        'action' => 'addFavorites',   
    ],
    '/deleteFavorites/{id:\d+}' => [
        'controller' => 'posts',
        'action' => 'deleteFavorites',   
    ],
    '/imagePostShow/{id:\d+}' => [
        'controller' => 'posts',
        'action' => 'imagePostShow',   
    ],
    '/delete_image/{id:\d+}' => [
        'controller' => 'posts',
        'action' => 'delete_image',   
    ],
    '/addPost/{id:\d+}' => [
        'controller' => 'posts',
        'action' => 'addPost',   
    ],
    '/deletePost/{id:\d+}' => [
        'controller' => 'posts',
        'action' => 'deletePost',   
    ],


    '/chats' => [
        'controller' => 'chats',
        'action' => 'chats',   
    ],
    '/myChats' => [
        'controller' => 'chats',
        'action' => 'myChats',   
    ],
    '/favoritesChats' => [
        'controller' => 'chats',
        'action' => 'favoritesChats',   
    ],
    '/openChat/{id:\d+}' => [
        'controller' => 'chats',
        'action' => 'openChat',   
    ],
    '/bannedChat/{id:\d+}' => [
        'controller' => 'chats',
        'action' => 'bannedChat',   
    ],
    '/unBannedChat/{id:\d+}' => [
        'controller' => 'chats',
        'action' => 'unBannedChat',   
    ],
    '/addChatShow/{id:\d+}' => [
        'controller' => 'chats',
        'action' => 'addChatShow',   
    ],
    '/editChatShow/{id:\d+}' => [
        'controller' => 'chats',
        'action' => 'editChatShow',   
    ],
    '/message/{id:\d+}' => [
        'controller' => 'chats',
        'action' => 'message',   
    ],
    '/delete_message/{id:\d+}' => [
        'controller' => 'chats',
        'action' => 'delete_message',   
    ],
    '/onFavorites/{id:\d+}' => [
        'controller' => 'chats',
        'action' => 'onFavorites',   
    ],
    '/offFavorites/{id:\d+}' => [
        'controller' => 'chats',
        'action' => 'offFavorites',   
    ],
    '/deleteChat/{id:\d+}' => [
        'controller' => 'chats',
        'action' => 'deleteChat',   
    ],
    '/roleModerator/{id:\d+}' => [
        'controller' => 'chats',
        'action' => 'roleModerator',   
    ],
    '/roleParticipant/{id:\d+}' => [
        'controller' => 'chats',
        'action' => 'roleParticipant',   
    ],
    '/deleteUserChat/{id:\d+}' => [
        'controller' => 'chats',
        'action' => 'deleteUserChat',   
    ],
    '/exitChat/{id:\d+}' => [
        'controller' => 'chats',
        'action' => 'exitChat',   
    ],
    '/roleChat/{id:\d+}' => [
        'controller' => 'chats',
        'action' => 'roleChat',   
    ],
    '/setRoleChat/{id:\d+}' => [
        'controller' => 'chats',
        'action' => 'setRoleChat',   
    ],
];
