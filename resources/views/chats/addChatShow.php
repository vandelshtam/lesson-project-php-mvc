<?php use App\Models\flashMessage;?>  
<main id="js-page-content" role="main" class="page-content mt-3 mt-6">

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
            <i class='subheader-icon fal fa-user'></i> Добавление нового чата
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
                            <h2 align="center">Аватар чата</h2>
                            <div class="panel-container col-lg-12 col-xl-12 m-auto" >    
                                <div class="panel-content" >        
                                    <div class="form-group">
                                        <label class="form-label" for="example-fileinput">Выберите аватар</label>
                                        <input type="file" id="example-fileinput" class="form-control-file" name="avatar_chat">
                                    </div>   
                                </div>
                            </div>
                            <br>
                            <hr> 

                            <!-- Название чата -->
                            <h5 class="col-md-12 text-center mt-3">
                                <div class="form-group ">
                                    <label class="form-label" for="simpleinput">Введите название чата</label>
                                    <input type="text" id="simpleinput" class="form-control" name="name_chat" value="<?php if(isset($_POST['name_chat'])){echo $_POST['name_chat'];}?>">
                                </div>
   
                            <!--  выбор пользователя для добавления в чат -->
                            <h4><span class="text-truncate text-truncate-xl">Выберите и добавьте пользователя  в чат</span></h4>
                            <div class="row p-2" id="js-contacts">
                                <?php if($_SESSION['admin'] == 1 || $_SESSION['auth'] == true):?>
                                <?php foreach ($users as $user):?>
                                
                                <div class="col-xl-4 m-auto">
                                    <div id="c_1" class="card border shadow-0 mb-g shadow-sm-hover" data-filter-tags="">
                                        <div class="card-body border-faded border-top-0 border-left-0 border-right-0 rounded-top">
                                            <div class="d-flex flex-row align-items-center">
                                                    <span class="rounded-circle profile-image d-block" style="background-image:url('/lesson-project-php-mvc/public/uploads/<?=$user['avatar'];?>'); background-size: cover;"></span>
                                                </span>
                                                <div class="info-card-text flex-1 md-1">
                                                    <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg text-info" data-toggle="dropdown" aria-expanded="false">
                                                        <?=$user['name'];?>   
                                                    </a>
                
                                                    <!--подменю-->
                                                    <?php if ($_SESSION['admin'] == 1 || $_SESSION['auth'] == true):?>
                                                        
                                                        <a class="dropdown-item col-md-4" href="/user/<?=$user['id'];?>">
                                                            <i class="fa fa-edit md-1"></i>
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
                                                            <input type="text" class="custom-control-input" name="user_<?=$user['id'];?>"   value="<?=$user['id'];?>" hidden>
                                                            <input type="checkbox" class="custom-control-input" name="rememberme_<?=$user['id'];?>" id="rememberme_<?=$user['id'];?>">
                                                            <label class="custom-control-label" for="rememberme_<?=$user['id'];?>">Добавить пользователя</label>
                                                        </div>
                                                    </div>     
                                                    </span>
                                            </div>
                                        </div>    
                                    </div>

                                </div> 
                               <?php endforeach;?>
                    <?php endif;?>     
                               
                            </div> 
                          
                    </div> 
                    
                      <!-- конопка добавления чата -->
                    <div class="col-md-12 mb-3  d-flex flex-row-reverse">
                    <button class="btn btn-info" type="submit" name="submit">Создать новый чат</button>
                    </div>
                </div>        
            </div>
       </div>   
    </form>
    </div>
</main>
<script src="js/vendors.bundle.js"></script>
    <script src="js/app.bundle.js"></script>
    <script>

        $(document).ready(function()
        {

        });

    </script>

    