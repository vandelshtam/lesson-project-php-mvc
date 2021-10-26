<?php use App\Models\flashMessage;?>
<main id="js-page-content" role="main" class="page-content mt-6">

<!-- флеш сообщения -->
<?php if(isset($_SESSION['success'])):;?>
    <div class="alert alert-success" >
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
<!-- флеш сообщения -->

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

<main id="js-page-content" role="main" class="page-content mt-3">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-user'></i> Редактирование чата
        </h1>
    </div>

    <div class="row ">
    <form action="" method="POST" enctype="multipart/form-data" class="col-lg-12 col-xl-12 m-auto">
        
      <div class="col-lg-12 col-xl-12 m-auto">
            <!-- новый чат -->
            <div class="card mb-g rounded-top">
                <div class="row no-gutters row-grid">
                    <div class="col-12">
                        <div class="d-flex flex-column align-items-center justify-content-center p-4">  
                            <!-- аватар чата --> 
                        <form action="/editChatShow/<?=$chat['id'];?>" method="POST" enctype="multipart/form-data" class="col-lg-12 col-xl-12 m-auto">   
                            <h2 align="center">Аватар чата</h2>
                            <div class="panel-container col-lg-12 col-xl-12 m-auto" >    
                                <div class="panel-content" > 
                                    <div class="panel-hdr">
                                        <h2>Текущий аватар</h2>
                                    </div>
                                    <div class="panel-content">
                                        <div class="form-group">
                                            <img src="/lesson-project-php-mvc/public/uploads/<?=$chat['chat_avatar'];?>" alt="" class="img-responsive" width="200">
                                        </div>      
                                        <div class="form-group">
                                            <label class="form-label" for="example-fileinput">Выберите аватар</label>
                                            <input type="file" id="example-fileinput" class="form-control-file" name="avatar_chat">
                                        </div> 
                                        <div class="col-lg-11 col-xl-11 m-auto d-flex flex-row-reverse">   
                                        <button class="btn btn-warning" type="submit" name="submit_avatar">Загрузить аватар</button>
                                    </div>  
                                </div>
                            </div>
                            <br>
                            <hr> 
                        </form>
                            <!-- Название чата -->
                            <h5 class="col-md-12 text-center mt-3">    
                                <div class="form-group ">
                                    <label class="form-label" for="simpleinput">Введите новое название чата</label>
                                    <input type="text" id="simpleinput" class="form-control" name="name_chat" value="<?php if(isset($_POST['name_chat'])){echo $_POST['name_chat'];}else{echo $chat['name_chat'];}?>">
                                </div>
   
                            <!--  участники чата  -->
                            <h4><span class="text-truncate text-truncate-xl">Участники чата</span></h4>
                            
                            <div class="row" id="js-contacts">    
                            <?php foreach ($userlists as $user):?>
                                <?php if($_SESSION['admin'] == 1 || $chat['author_user_id'] == $_SESSION['user_id']):?>
                                <div class="col-xl-4 ">
                                    <div class="card border shadow-0 mb-g shadow-sm-hover bg-blue bg-info-gradient" >
                                        <div class="card-body border-faded border-top-0 border-left-0 border-right-0 rounded-top">
                                            <div class="d-flex flex-row align-items-center">
                                                    <span class="rounded-circle profile-image d-block" style="background-image:url('/lesson-project-php-mvc/public/uploads/<?=$user['avatar'];?>'); background-size: cover;"></span>
                                                </span>
                                                <div class="info-card-text flex-1 md-1">
                                                    <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg text-info" data-toggle="dropdown" aria-expanded="false">
                                                        <?=$user['name'];?>  
                                                        <i class="fal fas fa-cog fa-fw d-inline-block ml-1 fs-md"></i>
                                                        <i class="fal fa-angle-down d-inline-block ml-1 fs-md"></i>    
                                                    </a>
                                                <div class="info-card-text flex-1">
                                    
                                            <!--подменю-->
                                                <?php if ($_SESSION['auth'] == true):?>
                                                    <div class="dropdown-menu">    
                                                        <a class="dropdown-item md-1" href="/user/<?=$user['user_id'];?>">
                                                            <i class="fa fa-edit md-1"></i>
                                                        Открыть  профиль</a>
                                                        
                                                        <p class="dropdown-item md-1" href="/roleParticipantShow/<?=$user['user_id'];?>">
                                                                <i class="fa fa-sun md-1"></i>        
                                                            Текущая роль - "<?=$user['role_chat'];?>"</p>
                                                        <?php if ($_SESSION['admin'] == 1 || $chat['author_user_id'] == $_SESSION['user_id'] || $user['role_chat'] == 'moderator'):?>
                                                            <?php if($user['role_chat'] == 'participant'):?>
                                                                <a class="dropdown-item md-1" href="/roleModerator/<?=$user['user_id'];?>">
                                                                    <i class="fa fa-lock md-1"></i>
                                                                Предоставить роль модератора</a>
                                                            <?php elseif ($user['role_chat'] == 'moderator'):?>
                                                                <a class="dropdown-item md-1" href="/roleParticipant/<?=$user['user_id'];?>">
                                                                    <i class="fa fa-lock md-1"></i>
                                                                Предоставить роль пользователя</a>
                                                            <?php endif;?> 
                                                        <?php endif;?>
                                                        <a class="dropdown-item md-1" href="/deleteUserChat/<?=$user['user_id'];?>" onclick="return confirm('are you sure?');">
                                                            <i class="fa fa-window md-1"></i>
                                                        Удалить пользователя из чата</a>
                                                        
                                                    </div>
                                                <?php endif;?>      
                                                    <span class="text-truncate text-truncate-xl"><?=$user['occupation'];?></span>
                                            </div>
                                            <button class="js-expand-btn btn btn-sm btn-default d-none" data-toggle="collapse" data-target="#c_1 > .card-body + .card-body" aria-expanded="false">
                                                <span class="collapsed-hidden">+</span>
                                                <span class="collapsed-reveal">-</span>
                                            </button>        
                                        </div>    
                                    </div>
                                </div>
                              </div> 
                            </div>
                            <?php endif;?>
                            <?php endforeach;?>    
                            </div> 

                            <!--  выбор пользователя для добавления в чат -->
                            <h4><span class="text-truncate text-truncate-xl">Выберите и добавьте пользователя  в чат</span></h4>
                            <div class="row" id="js-contacts">
                                
                                <?php foreach ($users as $user):?>
                                <?php if($_SESSION['admin'] == 1  || $_SESSION['user_id'] == $chat['author_user_id']):?>
                                <div class="col-xl-4">
                                    <div id="c_1" class="card border shadow-0 mb-g shadow-sm-hover" >
                                        <div class="card-body border-faded border-top-0 border-left-0 border-right-0 rounded-top">
                                            <div class="d-flex flex-row align-items-center">
                                                    <span class="rounded-circle profile-image d-block" style="background-image:url('/lesson-project-php-mvc/public/uploads/<?=$user['avatar'];?>'); background-size: cover;"></span>
                                                </span>
                                                <div class="info-card-text flex-1 md-1">
                                                    <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg text-info" data-toggle="dropdown" aria-expanded="false">
                                                        <?=$user['name'];?>
                                                    </a>
                
                                                    <!--подменю-->
                                                    <?php if ($_SESSION['auth'] == true || $_SESSION['admin'] == 1):?>
                                                        
                                                        <a class="dropdown-item md-auto" href="/user/<?=$user['user_id'];?>">
                                                            <i class="fa fa-edit md-auto"></i>
                                                        Открыть  профиль</a>
                                                    <?php endif;?>      
                                                      
                                                </div>
                                                <button class="js-expand-btn btn btn-sm btn-default d-none" data-toggle="collapse" data-target="#c_1 > .card-body + .card-body" aria-expanded="false">
                                                    <span class="collapsed-hidden">+</span>
                                                    <span class="collapsed-reveal">-</span>
                                                </button>
                                                <span>
                                                    <div class="form-group text-left">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="text" class="custom-control-input" name="add_user"   value="<?=$user['user_id'];?>" hidden>
                                                                <input type="checkbox" class="custom-control-input" name="rememberme_<?=$user['user_id'];?>" id="rememberme_<?=$user['user_id'];?>">
                                                                <label class="custom-control-label" for="rememberme_<?=$user['user_id'];?>">Добавить пользователя</label>
                                                            </div>
                                                    </div>     
                                                </span>
                                            </div>
                                        </div> 
                                           
                                    </div>
                                      
                                </div> 
                                <?php endif;?> 
                                <?php endforeach;?>     
                            </div> 
                               
                    </div> 
                     
                </div>
                
            </div>
       </div>

       <!-- конопка добавления поста -->
        <div class="col-md-12 mt-3 mb-3 d-flex flex-row-reverse">
            <button class="btn btn-info" type="submit" name="submit">Сохранить выбранные изменения в чате</button>
        </div>
        <div class="col-md-12 mt-3 mb-3 d-flex flex-row-reverse">
            <a class="btn btn-success" href="/openChat/<?=$chat['id'];?>" onclick="return confirm('are you sure?');">Закончить редактирование и выйти</a>
        </div>
    </form>
    </div>
</main>
<script src="/lesson-project-php-mvc/public/js/vendors.bundle.js"></script>
<script src="/lesson-project-php-mvc/public/js/app.bundle.js"></script>
    <script>

        $(document).ready(function()
        {

        });

    </script>


