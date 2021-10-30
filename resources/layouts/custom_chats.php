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
</head>
    <body class="mod-bg-1 mod-nav-link">
    <nav class="navbar navbar-expand-lg navbar-dark bg-info bg-primary-gradient fixed-top">
    <a class="navbar-brand d-flex align-items-center fw-500" href="users.html"><img alt="logo" class="d-inline-block align-top mr-2" src="/lesson-project-php-mvc/public/img/message.png" style="width:35px;">Book of friends - chats</a> <button aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-target="#navbarColor02" data-toggle="collapse" type="button"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="navbarColor02">
        <ul class="navbar-nav md-3">
            <li class="nav-item active">
                <a class="nav-link" href="/">Главная <span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <?php if($navigate['chatsAll']==1):?>
        <ul class="navbar-nav md-3">
            <li class="nav-item active">
                <a class="nav-link text-danger" href="/chats" >Все чаты <span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <?php else:?>
        <ul class="navbar-nav md-3">
            <li class="nav-item active">
                <a class="nav-link" href="/chats">Все чаты <span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <?php endif;?>
        <?php if ($navigate['myChats']==1):?>
        <ul class="navbar-nav md-3">
            <li class="nav-item active">
                <a class="nav-link text-danger" href="/myChats" >Мои чаты <span class="sr-only">(current)</span></a>
            </li>
        </ul>    
        <?php else:?>
        <ul class="navbar-nav md-3">
            <li class="nav-item active">
                <a class="nav-link" href="/myChats">Мои чаты <span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <?php endif;?>
        <?php if ($navigate['favorites']==1):?>
        <ul class="navbar-nav md-3">
            <li class="nav-item active">
                <a class="nav-link text-danger" href="/favoritesChats" >Избранные чаты <span class="sr-only">(current)</span></a>
            </li>
        </ul> 
        <?php else:?>
        <ul class="navbar-nav md-3">
            <li class="nav-item active">
                <a class="nav-link" href="/favoritesChats">Избранные чаты<span class="sr-only">(current)</span></a>
            </li>
        </ul>   
        <?php endif;?>
        
        <ul class="navbar-nav md-3">
            <li class="nav-item active">
                <a class="nav-link text-warning" href="/posts" >Перейти на страницу постов <span class="sr-only">(current)</span></a>
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
                <a class="nav-link">Вы вошли как - "<?=$_SESSION['name'];?>"</a>
            </li>
            <?php endif;?>
        </ul>
        <ul class="navbar-nav md-3">
            <?php if($_SESSION['auth'] == true):?>
            <li class="nav-item">
                <a class="nav-link" href="/logout">Выйти</a>
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

