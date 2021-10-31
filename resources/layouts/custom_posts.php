<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=$title;?></title>
    <meta name="description" content="Chartist.html">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="/lesson-project-php-mvc/public/css/vendors.bundle.css">
    <link id="appbundle" rel="stylesheet" media="screen, print" href="/lesson-project-php-mvc/public/css/app.bundle.css">
    <link id="myskin" rel="stylesheet" media="screen, print" href="/lesson-project-php-mvc/public/css/skins/skin-master.css">
    <link rel="stylesheet" media="screen, print" href="/lesson-project-php-mvc/public/css/fa-solid.css">
    <link rel="stylesheet" media="screen, print" href="/lesson-project-php-mvc/public/css/fa-brands.css">
    <link rel="stylesheet" media="screen, print" href="/lesson-project-php-mvc/public/css/fa-regular.css">
    <link rel="stylesheet" type="text/css" href="/lesson-project-php-mvc/public/css/style.css">   
</head>
    <body class="mod-bg-1 mod-nav-link">
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger bg-primary-gradient fixed-top">
    <a class="navbar-brand d-flex align-items-center fw-500" href="users.html"><img alt="logo" class="d-inline-block align-top mr-2 sizeImageNav" src="/lesson-project-php-mvc/public/img/message.png">Book of friends - Page posts</a> <button aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-target="#navbarColor02" data-toggle="collapse" type="button"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="navbarColor02">
        <ul class="navbar-nav md-3">
            <li class="nav-item active">
                <a class="nav-link" href="/">Главная <span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <?php if($navigate['postsAll']==1):?>
        <ul class="navbar-nav md-3">
            <li class="nav-item active">
                <a class="nav-link text-info" href="/posts" >Все посты <span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <?php else:?>
        <ul class="navbar-nav md-3">
            <li class="nav-item active">
                <a class="nav-link" href="/posts">Все посты <span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <?php endif;?>
        <?php if ($navigate['myPosts']==1):?>
        <ul class="navbar-nav md-3">
            <li class="nav-item active">
                <a class="nav-link text-info" href="/myPosts/<?=$_SESSION['user_id'];?>" >Мои посты <span class="sr-only">(current)</span></a>
            </li>
        </ul>    
        <?php else:?>
        <ul class="navbar-nav md-3">
            <li class="nav-item active">
                <a class="nav-link" href="/myPosts/<?=$_SESSION['user_id'];?>">Мои посты <span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <?php endif;?>
        <?php if ($navigate['favorites']==1):?>
        <ul class="navbar-nav md-3">
            <li class="nav-item active">
                <a class="nav-link text-info" href="/favoritesPosts" >Избранные посты <span class="sr-only">(current)</span></a>
            </li>
        </ul> 
        <?php else:?>
        <ul class="navbar-nav md-3">
            <li class="nav-item active">
                <a class="nav-link" href="/favoritesPosts">Избранные посты<span class="sr-only">(current)</span></a>
            </li>
        </ul>   
        <?php endif;?>
        <?php if ($navigate['searchPosts']==1):?>
        <ul class="navbar-nav md-3">
            <li class="nav-item active">
                <a class="nav-link text-danger" href="#" >Вы в режиме поиска <span class="sr-only">(current)</span></a>
            </li>
        </ul> 
        <?php endif;?>
        <ul class="navbar-nav md-3">
            <li class="nav-item active">
                <a class="nav-link text-warning" href="/chats" >Перейти на страницу чатов <span class="sr-only">(current)</span></a>
            </li>
        </ul> 
        <ul class="navbar-nav ml-auto">
            <?php if($_SESSION['auth'] == true  && $_SESSION['admin'] == 1):?>
            <li class="nav-item">
                <a class="nav-link">Вы администратор</a>
            </li>
            <?php endif;?>
        </ul>
        <ul class="navbar-nav md-3">
            <?php if($_SESSION['auth'] == true):?>
            <li class="nav-item">
                <a class="nav-link">Вы вошли как <?=$_SESSION['name'];?></a>
            </li>
            <?php endif;?>
        </ul>
        <ul class="navbar-nav md-3">
            <?php if($_SESSION['auth'] == true):?>
            <li class="nav-item">
                <a class="nav-link" href="/logout" onclick="return confirm('are you sure?');">Выйти</a>
            </li>
            <?php else:?>
            <li class="nav-item">
                <a class="nav-link" href="/login">Войти</a>
            </li>
            <?php endif;?>
        </ul>
    </div>
</nav>

<?=$content;?>
    </body>
</html>

