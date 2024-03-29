<?php use App\Models\flashMessage;?>
    <!-- Call App Mode on ios devices -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <!-- base css -->
    <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="css/vendors.bundle.css">
    <link id="appbundle" rel="stylesheet" media="screen, print" href="css/app.bundle.css">
    <link id="mytheme" rel="stylesheet" media="screen, print" href="#">
    <link id="myskin" rel="stylesheet" media="screen, print" href="css/skins/skin-master.css">
    <!-- Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
    <link rel="mask-icon" href="img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="stylesheet" media="screen, print" href="css/fa-brands.css">
    <link rel="stylesheet" type="text/css" href="/lesson-project-php-mvc/public/css/style.css">
</head>
<body>
    <div class="page-wrapper auth">
        <div class="page-inner bg-primary bg-danger-gradient">
            <div class="page-content-wrapper bg-transparent m-0">
                <div class="height-10 w-100 shadow-lg px-4 bg-danger bg-primary-gradient">
                    <div class="d-flex align-items-center container p-0">
                        <div class="page-logo width-mobile-auto m-0 align-items-center justify-content-center p-0 bg-transparent bg-img-none shadow-0 height-9 border-0">
                            <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
                                <img src="img/message.png" alt="SmartAdmin WebApp" aria-roledescription="logo">
                                <span class="page-logo-text mr-1">Book of friends</span>
                            </a>
                        </div>
                        <span class="text-white opacity-50 ml-auto mr-2 hidden-sm-down">
                            Уже зарегистрированы?
                        </span>
                        <a href="/login" class="btn-link text-white ml-auto ml-sm-0">
                            Войти
                        </a>
                    </div>
                </div>
                <div class="flex-1" style="background: url(img/svg/pattern-1.svg) no-repeat center bottom fixed; background-size: cover;">
                    <div class="container py-4 py-lg-5 my-lg-5 px-4 px-sm-0">
                        <div class="row">
                            <div class="col-xl-12">
                                <h2 class="fs-xxl fw-500 mt-4 text-white text-center">
                                    Регистрация
                                    <small class="h3 fw-300 mt-3 mb-5 text-white opacity-60 hidden-sm-down">
                                        Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться.
                                        <br> 
                                        По своей сути рыбатекст является альтернативой традиционному lorem ipsum
                                        
                                    </small>
                                </h2>
                            </div>
                            <div class="col-xl-6 ml-auto mr-auto">
                                <div class="card p-4 rounded-plus bg-faded">
                                    <!-- сообщения об ошибках-->
                                    <?php if(!empty($errors)):?> 
                                        <div class="alert alert-danger text-dark" role="alert">
                                            <strong>Уведомление!</strong>   
                                                <?php foreach($errors as $error):?>
                                                    <p><?=$error; ?></p>
                                                <?php endforeach;?>        
                                        </div>
                                    <?php endif;?>    
                                    <!-- сообщения об ошибках-->
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
                                    <form id="js-login" novalidate="" action="" method="POST">
                                    <div class="form-group">
                                            <label class="form-label" for="emailverify">Name</label>
                                            <input type="text" id="emailverify" class="form-control" placeholder="Имя" required name="name" value="<?php if(isset($_POST['name'])){echo $_POST['name'];}?>">
                                            <div class="invalid-feedback">Заполните поле.</div>
                                            <div class="help-block">Это будет вашим ником в сети</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="emailverify">Email</label>
                                            <input type="email" id="emailverify" class="form-control" placeholder="Эл. адрес" required name="email" value="<?php if(isset($_POST['email'])){echo $_POST['email'];}?>">
                                            <div class="invalid-feedback">Заполните поле.</div>
                                            <div class="help-block">Эл. адрес будет вашим логином при авторизации</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="userpassword">Пароль <br></label>
                                            <input type="password" id="userpassword" class="form-control" placeholder="" required name="password">
                                            <div class="invalid-feedback">Заполните поле.</div>
                                        </div>
                                       
                                        <div class="row no-gutters">
                                            <div class="col-md-4 ml-auto text-right">
                                                <button id="js-login-btn" type="submit" class="btn btn-block btn-danger btn-lg mt-3">Регистрация</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="/lesson-project-php-mvc/public/js/vendors.bundle.js"></script>
    <script>
        $("#js-login-btn").click(function(event)
        {

            // Fetch form to apply custom Bootstrap validation
            var form = $("#js-login")

            if (form[0].checkValidity() === false)
            {
                event.preventDefault()
                event.stopPropagation()
            }

            form.addClass('was-validated');
            // Perform ajax submit here...
        });

    </script>
</body>
</html>
