<?php use App\Models\flashMessage;?>

     <!-- Call App Mode on ios devices -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <!-- base css -->
    <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="/lesson-project-php-mvc/public/css/vendors.bundle.css">
    <link id="appbundle" rel="stylesheet" media="screen, print" href="/lesson-project-php-mvc/public/css/app.bundle.css">
    <link id="mytheme" rel="stylesheet" media="screen, print" href="#">
    <link id="myskin" rel="stylesheet" media="screen, print" href="/lesson-project-php-mvc/public/css/skins/skin-master.css">
    <!-- Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" sizes="180x180" href="/lesson-project-php-mvc/public/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/lesson-project-php-mvc/public/img/favicon/favicon-32x32.png">
    <link rel="mask-icon" href="/lesson-project-php-mvc/public/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="stylesheet" media="screen, print" href="/lesson-project-php-mvc/public/css/page-login-alt.css">
    <link rel="stylesheet" type="text/css" href="/lesson-project-php-mvc/public/css/style.css">
</head>
<body>
    <div class="blankpage-form-field">
        <div class="page-logo m-0 w-100 align-items-center justify-content-center rounded border-bottom-left-radius-0 border-bottom-right-radius-0 px-4 bg-danger bg-primary-gradient">
            <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
                <img src="img/message.png" alt="SmartAdmin WebApp" aria-roledescription="logo">
                <span class="page-logo-text mr-1">Учебный проект</span>
                <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
            </a>
        </div>
        <div class="card p-4 border-top-left-radius-0 border-top-right-radius-0">
            
        <?php if(isset($_SESSION['success'])):;?>
        <div class="alert alert-success" ">
        <?php flashMessage::display_flash('success') ;?>
        </div>
        <?php endif;?>

        <?php if(isset($_SESSION['danger'])):;?>
        <div class="alert alert-danger" ">
        <?php flashMessage::display_flash('danger') ;?>
        </div>
        <?php endif;?> 
        
        <?php if(isset($_SESSION['info'])):;?>
        <div class="alert alert-info" ">
        <?php flashMessage::display_flash('info') ;?>
        </div>
        <?php endif;?>
            <form action="" method="POST">
                <div class="form-group">
                    <label class="form-label" for="username">Email</label>
                    <input type="email" id="username" class="form-control" placeholder="Эл. адрес" value="" name="email">
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">Пароль</label>
                    <input type="password" id="password" class="form-control" placeholder="" name="password">
                </div>
                <div class="form-group text-left">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="rememberme">
                        <label class="custom-control-label" for="rememberme" name="rememberme">Запомнить меня</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-default float-right">Войти</button>
            </form>
        </div>
        <div class="blankpage-footer text-center text-danger">
            Нет аккаунта? <a class="text-danger" href="/register"><strong>Зарегистрироваться</strong>
        </div>
    </div>
    <video poster="img/backgrounds/clouds.png" id="bgvid" playsinline autoplay muted loop>
        <source src="media/video/cc.webm" type="video/webm">
        <source src="media/video/cc.mp4" type="video/mp4">
    </video>
    <script src="/lesson-project-php-mvc/public/js/vendors.bundle.js"></script>
</body>
</html>
