<?php use App\Models\flashMessage;?>    
   
        <main id="js-page-content" role="main" class="page-content mt-3">
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

            <?php if(isset($_SESSION['warning'])):;?>
            <div class="alert alert-warning" ">
            <?php flashMessage::display_flash('warning') ;?>
            </div>
            <?php endif;?>
            <div class="subheader">
                <h1 class="subheader-title">
                    <i class='subheader-icon fal fa-users'></i> Список пользователей
                </h1>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <a class="btn btn-danger" href="/create_user">Добавить</a>
                    
                    <div class="border-faded bg-faded p-3 mb-g d-flex mt-3">
                        <input type="text" id="js-filter-contacts" name="filter-contacts" class="form-control shadow-inset-2 form-control-lg" placeholder="Найти пользователя">
                        <div class="btn-group btn-group-lg btn-group-toggle hidden-lg-down ml-3" data-toggle="buttons">
                            <label class="btn btn-default active">
                                <input type="radio" name="contactview" id="grid" checked="" value="grid"><i class="fas fa-table"></i>
                            </label>
                            <label class="btn btn-default">
                                <input type="radio" name="contactview" id="table" value="table"><i class="fas fa-th-list"></i>
                            </label>
                            
                        </div>
                    </div>
                    
                </div>
            </div>
            
            <div class="row" id="js-contacts" >        
                 <?php foreach($usersList as $key => $var): ?>  
                <div class="col-xl-4 rounded-3">
                    <div id="<?=$var['c'];?>" class="card border shadow-0 mb-g shadow-sm-hover" data-filter-tags="<?=$var['search'];?>">
                        <div class="card-body border-faded border-top-0 border-left-0 border-right-0 rounded-top">
                        <div class="d-flex flex-row align-items-center">
                                <!-- статус пользователя -->
                                <?php if ($var['status'] == 0):?>
                                    <span class="status status-success mr-3">
                                <?php endif;?>
                                <?php if ($var['status'] == 1):?>
                                    <span class="status status-danger mr-3">
                                <?php endif;?>
                                <?php if ($var['status'] == 2):?>
                                    <span class="status status-warning mr-3">
                                <?php endif;?>
                                    <span class="rounded-circle profile-image d-block " style="background-image:url('/lesson-project-php-mvc/public/uploads/<?=$var['avatar'];?>'); background-size: cover;"></span>
                                </span>
                                <div class="info-card-text flex-1">
                                    <a href="/lesson-project-php-mvc/public/js/javascript:void(0);" class="fs-xl text-truncate text-truncate-lg text-info" data-toggle="dropdown" aria-expanded="false">
                                        <?=$var['name'];?>
                                        <i class="fal fas fa-cog fa-fw d-inline-block ml-1 fs-md"></i>
                                        <i class="fal fa-angle-down d-inline-block ml-1 fs-md"></i>
                                    </a>
                                    <div class="dropdown-menu bg-ganger bg-danger-gradient rounded">
                                    <a class="dropdown-item " href="/user/<?=$var['user_id'];?>">
                                        <?php if(isset($_SESSION['auth']) == true):?>
                                            <i class="fa fa-edit"></i>
                                        Открыть профиль</a>
                                        <?php endif;?>
                                        <?php if(isset($_SESSION['user_id']) == $var['user_id'] || isset($_SESSION['admin']) == 1):?>
                                        <a class="dropdown-item" href="/edit/<?php echo $var['user_id'];?>">
                                            <i class="fa fa-edit"></i>
                                        Редактировать</a>
                                        <a class="dropdown-item" href="/security/<?=$var['user_id'];?>">
                                            <i class="fa fa-lock"></i>
                                        Безопасность</a>
                                        <a class="dropdown-item" href="/change_email/<?=$var['user_id'];?>">
                                            <i class="fa fa-lock"></i>
                                        Изменить почту</a>
                                        <a class="dropdown-item" href="/statusShow/<?=$var['user_id'];?>">
                                            <i class="fa fa-sun"></i>
                                        Установить статус</a>
                                        <a class="dropdown-item" href="/media/<?=$var['user_id'];?>">
                                            <i class="fa fa-camera"></i>
                                        Загрузить аватар
                                        </a>
                                        <a href="/confirm_password/<?=$var['user_id'];?>" class="dropdown-item" onclick="return confirm('are you sure?');">
                                            <i class="fa fa-window-close"></i>
                                        Удалить
                                        </a>
                                        <?php endif;?>
                                        <?php if(isset($_SESSION['admin']) == 1):?>
                                        <?php if($var['admin'] == 1):?>
                                        <a href="/setUser/<?=$var['user_id'];?>" class="dropdown-item" onclick="return confirm('Если вы изменимте пользователю роль админа, он потеряет привелегии, are you sure?');">
                                            <i class="fa fa-window-close">Отозвать роль админа? </i>
                                            текущая роль: Админ
                                        </a>
                                        <?php else:?>
                                        <a href="/setAdmin/<?=$var['user_id'];?>" class="dropdown-item" onclick="return confirm('are you sure?');">
                                            <i class="fa fa-window-close">Назначить роль админа? </i>
                                            текущая роль: Юзер
                                        </a>    
                                        <?php endif;?>
                                        
                                        <?php endif;?>
                                        <?php if(empty($_SESSION['auth'])):?>
                                            <span class="text-truncate text-truncate-xl">У вас нет доступа, войдите в свой аккаунт или зарегистрируйтесь</span>
                                        <?php endif;?>
                                    </div>
                                    <span class="text-truncate text-truncate-xl"><?=$var['occupation'];?></span>
                                </div>
                                <button class="js-expand-btn btn btn-sm btn-default d-none" data-toggle="collapse" data-target="#c_1 > .card-body + .card-body" aria-expanded="false">
                                    <span class="collapsed-hidden">+</span>
                                    <span class="collapsed-reveal">-</span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0 collapse show">
                            <div class="p-3">
                                <a href="tel:+13174562564" class="mt-1 d-block fs-sm fw-400 text-dark">
                                    <i class="fas fa-mobile-alt text-muted mr-2"></i><?=$var['phone'];?></a>
                                <a href="mailto:oliver.kopyov@smartadminwebapp.com" class="mt-1 d-block fs-sm fw-400 text-dark">
                                    <i class="fas fa-mouse-pointer text-muted mr-2"></i><?=$var['email'];?></a>
                                <address class="fs-sm fw-400 mt-4 text-muted">
                                    <i class="fas fa-map-pin mr-2"></i><?=$var['location'];?></address>
                                <div class="d-flex flex-row">
                                    <a href="/lesson-project-php-mvc/public/js/javascript:void(0);" class="mr-2 fs-xxl" style="color:#4680C2">
                                        <i class="fab fa-vk"><?=$var['vk'];?></i>
                                    </a>
                                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#38A1F3">
                                        <i class="fab fa-telegram"><?=$var['telegram'];?></i>
                                    </a>
                                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#E1306C">
                                        <i class="fab fa-instagram"><?=$var['instagram'];?></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>            
    <?php endforeach;?>
    </div>
    <?php echo $pagination; ?>
    </main>
     
        <!-- BEGIN Page Footer -->
        <footer class="page-footer" role="contentinfo">
            <div class="d-flex align-items-center flex-1 text-muted">
                <span class="hidden-md-down fw-700">2021 © Hobby project</span>
            </div>
            <div>
                <ul class="list-table m-0">
                    <li><a href="/" class="text-secondary fw-700">Home</a></li>
                    <li class="pl-3"><a href="info_app_licensing.html" class="text-secondary fw-700">About</a></li>
                </ul>
            </div>
        </footer>
        
    </body>

    <script src="/lesson-project-php-mvc/public/js/vendors.bundle.js"></script>
    <script src="/lesson-project-php-mvc/public/js/app.bundle.js"></script>
    <script>

        $(document).ready(function()
        {

            $('input[type=radio][name=contactview]').change(function()
                {
                    if (this.value == 'grid')
                    {
                        $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-g');
                        $('#js-contacts .col-xl-12').removeClassPrefix('col-xl-').addClass('col-xl-4');
                        $('#js-contacts .js-expand-btn').addClass('d-none');
                        $('#js-contacts .card-body + .card-body').addClass('show');

                    }
                    else if (this.value == 'table')
                    {
                        $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-1');
                        $('#js-contacts .col-xl-4').removeClassPrefix('col-xl-').addClass('col-xl-12');
                        $('#js-contacts .js-expand-btn').removeClass('d-none');
                        $('#js-contacts .card-body + .card-body').removeClass('show');
                    }

                });

                //initialize filter
                initApp.listFilter($('#js-contacts'), $('#js-filter-contacts'));
        });

    </script>

