
<?php use App\Models\flashMessage;?>    
<main id="js-page-content" role="main" class="page-content mt-3">

            <!-- флеш сообщения -->
            <?php if(isset($_SESSION['success'])):?>
            <div class="alert alert-success" ">
            <?php flashMessage::display_flash('success') ;?>
            </div>
            <?php endif;?>

            <?php if(isset($_SESSION['danger'])):?>
            <div class="alert alert-danger" ">
            <?php flashMessage::display_flash('danger') ;?>
            </div>
            <?php endif;?> 
                                            
            <?php if(isset($_SESSION['info'])):?>
            <div class="alert alert-info" ">
            <?php flashMessage::display_flash('info') ;?>
            </div>
            <?php endif;?>
            <!-- флеш сообщения -->

            <!-- добавить пост -->
            <div class="row p-3 ">
                <div class="col-xl-12">
                <?php if ($_SESSION['auth'] == true || $_SESSION['admin'] == 1):?>
                    <a class="btn btn-info" href="/addPost/<?=$_SESSION['user_id'];?>">Добавить пост</a>
                <?php endif;?>       
                </div>
            </div>
  

    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-user'></i><?=$post[0]['name_post'];?>
        </h1>
    </div> 
    <div class="row">
      <div class="col-lg-12 col-xl-12 m-auto">
            <!-- profile summary -->
            <div class="card mb-g rounded-top">
                <div class="row no-gutters row-grid">
                    <div class="col-12">
                        <div class="d-flex flex-column align-items-center justify-content-center p-4">
                            <!-- menu edit -->
                                <a class="dropdown-item" href="/editPost/<?=$post[0]['post_id'];?>">
                                    <i class="fa fa-edit btn btn-info"></i>
                                Редактировать пост</a>
                                <?php if ($post[0]['favorites'] ==1 ):?>
                                    <a class="dropdown-item"  href="/deleteFavorites/<?=$post[0]['post_id'];?>">
                                        <i class="fa fa-sun btn btn-warning"></i>Удалить из избранного</a>   
                                <?php else:?>
                                    <a class="dropdown-item"  href="/addFavorites/<?=$post[0]['post_id'];?>">
                                        <i class="fa fa-sun btn btn-info"></i>Добавить в избранное</a>
                                <?php endif;?> 
                                <?php if ($_SESSION['admin'] == 1 || $_SESSION['user_id'] == $post[0]['user_id']):?>
                                <!-- повторное подтверждение пароля для безопасности -->
                                <a class="dropdown-item" onclick="return confirm('are your sure?')" href="/confirm_password_delete_post/<?=$post[0]['id'];?>">
                                    <i class="fa fa-window-close btn btn-info"></i>
                                Удалить пост</a>    
                                <?php endif;?>
                                <?php if ($_SESSION['admin'] == 1 && $post[0]['banned'] ==1 ):?>
                                    <a class="dropdown-item"  href="/unBannedPost/<?=$post[0]['post_id'];?>">
                                        <i class="fa fa-unlock btn btn-warning"></i>Разблокировать пост</a>   
                                <?php elseif ($_SESSION['admin'] == 1):?>
                                    <a class="dropdown-item"  href="/bannedPost/<?=$post[0]['post_id'];?>">
                                        <i class="fa fa-lock btn btn-danger"></i>Заблокировать пост</a>
                                <?php endif;?>     
                            <!-- show post -->    
                            <?php if ($_SESSION['admin'] == 1 && $post[0]['banned'] == 1):?>
                            <img src="/lesson-project-php-mvc/public/<?=$post[0]['avatar_post'];?>" class="rounded-circle shadow-2 img-thumbnail bt btn-warning" alt="logo" style="width: 80%">
                            <?php elseif ($post[0]['banned'] == 1):?> 
                            <img src="/lesson-project-php-mvc/public/img/demo/avatars/avatar-admin-lg.png" class="rounded-circle shadow-2 img-thumbnail" alt="" style="width: 80%">  
                            <?php else:?>
                            <img src="/lesson-project-php-mvc/public/<?=$post[0]['avatar_post'];?>" class="rounded-circle shadow-2 img-thumbnail" alt="" style="width: 80%">
                            <?php endif;?>
                            <br>
                            <hr> 

                            <!-- вывод галереи заблокированного поста для админа-->
                            <?php if($_SESSION['admin'] == 1 && $post[0]['banned'] == 1):?>           
                            <div class="container">
                                <h2 align="center">Галерея заблокированного поста</h2>
                                <div class="row">
                                    <?php foreach ($images as $image):?>
                                        <div class="col-md-3 galery-item col-lg-4 col-xl-4" style="width:400px; hight:200px>
                                            <div>
                                                <img src="/lesson-project-php-mvc/public/<?=$image['image'];?>" alt="" class="img-fluid img-thumbnail col-lg-4 col-xl-4" style="width:400px; hight:200px">
                                            </div>
                                        <input type="file" id="example-fileinput" class="form-control-file" name="delete_image" hidden>    
                                        <a href="/imagePostShow/<?=$image['id'];?>" onclick="return confirm('are your sure?')" class="btn btn-info my-button">Open image</a>
                                        </div>
                                    <?php endforeach;?>   
                                </div>
                            </div>
                            <?php endif;?>
                            <?php if($post[0]['banned'] == 0):?>
                            <!-- галерея  не заблокированного поста -->
                            <div class="container">
                                <h2 align="center">Галерея поста</h2>
                                <div class="row">
                                    <?php foreach ($images as $image):?>
                                        <div class="col-md-3 galery-item">
                                            <div>
                                                <img src="/lesson-project-php-mvc/public/<?=$image['image'];?>" alt="" class="img-fluid img-thumbnail" ">
                                            </div>
                                           
                                        <a href="/imagePostShow/<?=$image['id'];?>"  class="btn btn-info my-button">Open image</a>
                                        </div>
                                    <?php endforeach;?>   
                                </div>
                            </div>
                            <?php endif;?>
                            <?php if( $_SESSION['admin'] == 1 && $post[0]['banned'] ==1 ):?>    
                            <h5 class="mb-0 fw-700 text-center mt-3">
                                <small class="text-muted mb-0 bt btn-danger">Пост заблокирован из-за нарушения правил изспользования веб сайта
                                </small>
                                <?php echo $post[0]['title_post'];?>
                                <small class="text-muted mb-0"><?=$post[0]['text'];?>
                                    </small>
                                    <hr>
                            </h5>
                            <?php elseif ($post[0]['banned'] == 1):?>
                                <div class="row">        
                                    <div class="coll-md-12">        
                                        <img  src="img/demo/avatars/avatar-admin-lg.png" alt="" class="img-fluid img-thumbnail gallery-image">
                                    </div>    
                                </div>      
                            <h5 class="mb-0 fw-700 text-center mt-3 bt btn-danger">
                                Пост заблокирован из-за нарушения правил изспользования веб сайта
                                <small class="text-muted mb-0 bt btn-danger">Пост заблокирован из-за нарушения правил изспользования веб сайта
                                    </small>
                                    <hr>
                            </h5>
                            <?php else: ?>
                            <h5 class="mb-0 fw-700 text-center mt-3">
                                <?=$post[0]['title_post'];?> 
                                <small class="text-muted mb-0"><?=$post[0]['text'];?>
                                    </small>
                                    <hr>
                            </h5>
                            <?php endif;?>
                            <h5 class="mb-0 fw-700 text-center mt-3">
                                <?=$post[0]['name'];?>
                                <small class="text-muted mb-0"><?=$post[0]['location'];?></small>
                            </h5>
                            <div class="mt-4 text-center demo">
                                <a href="javascript:void(0);" class="fs-xl" style="color:#C13584">
                                    <i class="fab fa-instagram"><?=$post[0]['instagram'];?></i>
                                </a>
                                <a href="javascript:void(0);" class="fs-xl" style="color:#4680C2">
                                    <i class="fab fa-vk"><?=$post[0]['vk'] ;?></i>
                                </a>
                                <a href="javascript:void(0);" class="fs-xl" style="color:#0088cc">
                                    <i class="fab fa-telegram"><?=$post[0]['telegram'];?></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 text-center">
                            <a href="tel:+13174562564" class="mt-1 d-block fs-sm fw-400 text-dark">
                                <i class="fas fa-mobile-alt text-muted mr-2"></i><?=$post[0]['phone'];?></a>
                            <a href="mailto:oliver.kopyov@marlin.ru" class="mt-1 d-block fs-sm fw-400 text-dark">
                                <i class="fas fa-mouse-pointer text-muted mr-2"></i><?=$post[0]['email'];?></a>
                            <address class="fs-sm fw-400 mt-4 text-muted">
                                <i class="fas fa-map-pin mr-2"></i><?=$post[0]['occupation'];?>
                            </address>
                        </div>
                    </div>
                </div>
            </div>
       </div>
       <!-- форма ввода коментария -->
       <form action="/addNewComment/<?=$post[0]['post_id'];?>" method="POST" enctype="multipart/form-data" class="col-lg-12 col-xl-12 m-auto">
        
        <div class="col-lg-12 col-xl-12 m-auto">
                <!-- текст коментария -->
                    <div class="form-group">
                        <label class="form-label" for="simpleinput">Введите текст комментария</label>
                        <input type="text" id="simpleinput" class="form-control" name="comment" value="<?php if(isset($_POST['comment'])){echo $_POST['comment'];}?>">
                        <input type="text" id="simpleinput" class="form-control" name="user_id" value="<?=$_SESSION['user_id'];?> "  hidden>
                    </div>                                     
        </div>       
         <div class="col-md-12 mt-3 d-flex flex-row-reverse">
          <button class="btn btn-info" type="submit" name="submit">Отправить комментарий</button>
        </div>
      </form>   
    </div>
 </div>
    <br>
    <br>
    
    
<!-- навигационная строка раздела комментариев -->
<div id="navbar-example2" class="navbar navbar-light bg-info px-3 m-auto col-lg-12 col-xl-12 rounded">
    <a class="navbar-brand" href="#">Комментарии</a>
    <ul class="nav nav-pills">
      <li class="nav-item">
        <a class="nav-link text-white" href="#scrollspyHeading1">Сначала новые</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white"" href="#scrollspyHeading2">Сначала старые</a>
      </li>
    </ul>
  </div>

  <!-- comments -->
  <div  class=" col-lg-12 col-xl-12 m-auto" >
    <?php foreach ($comments as $comment):?>
    <!-- комментарии авторизованного пользователя -->
    <?php if ($_SESSION['user_id'] == $comment['user_id']):?>
    <div class=" col-lg-10 col-xl-10 mt-2 ml-auto" >
        <div class="toast-header bg-info md-3 rounded-top nav-item">
        <span class="rounded-circle profile-image d-block md-3" style="background-image:url('/lesson-project-php-mvc/public/<?=$comment['avatar'];?>'); background-size: cover;"> </span>
        <strong class="ml-auto "><?=$comment['name'];?></strong>
        <small class="ml-auto "><?=$comment['updated_at'];?></small>
        <!-- заблокированные коментарии -->
        <?php if ($_SESSION['admin'] == 1 && $comment['banned'] == 1):?>
            <a class="text-warning ml-auto"  href="/unBannedComment/<?=$comment['id'];?>">
                <i class="fa fa-unlock btn btn-warning"> </i>Разблокировать комментарий</a>   
        <?php elseif ($_SESSION['admin'] == 1):?>
            <a class="bt text-danger ml-auto"  href="/bannedComment/<?=$comment['id'];?>">
                <i class="fa fa-lock btn btn-danger"> </i>Заблокировать комментарий</a>
        <?php endif;?> 
        <form action="/deleteComment/<?=$comment['id'];?>" method="POST"  class=" m-auto">
            <label class="form-label" for="simpleinput"></label>
            <input type="text" id="simpleinput" class="form-control" name="post_id" value="<?=$comment['post_id'];?>" hidden>
            <input type="text" id="simpleinput" class="form-control" name="user_id" value="<?=$_SESSION['user_id'];?> "  hidden> 
          <button class="btn btn-info" type="submit" onclick="return confirm('are your sure?')" name="submit">Удалить комментарий</button>
        </form>       
        <!--<a class=" btn-close ml-auto text-white" onclick="return confirm('are your sure?')" aria-label="Close"  href="/deleteComment/<?=$comment['id'];?>"> Удалить комментарий</a>-->
        </div>
        <?php if ( $_SESSION['admin'] == 1 && $comment['banned'] ==1 ):?>
        <h6 id="scrollspyHeading1 btn-danger" class="bg-danger bg-danger-gradient pt-4 pb-4 pl-4 text-white rounded-bottom"> Комментарий заблокирован из-за нарушения правил пользования веб сайтом : <?=$comment['comment'];?></h6>    
        <?php elseif ($comment['banned'] == 1):?>
        <h6 id="scrollspyHeading1" class="bg-secondary bg-secondary-gradient pt-4 pb-4 pl-4 text-white rounded-bottom">Комментарий заблокирован из-за нарушения правил пользования веб сайтом </h6>
        <?php else:?>
        <h6 id="scrollspyHeading1" class="bg-warning bg-waning-gradient pt-4 pb-4 pl-4 rounded-bottom"><?=$comment['comment'];?></h6>
        <?php endif;?>
    </div> 

    <!-- коментарии других пользователей -->
    <?php else:?>
    <div class="col-lg-10 col-xl-10 mt-2"  >
        <div class="toast-header bg-info rounded-top">
        <span class="rounded-circle profile-image d-block " style="background-image:url('/lesson-project-php-mvc/public/<?=$comment['avatar'];?>'); background-size: cover;"></span>
        <strong class="md-3"><?=$comment['name'];?></strong>
        <small class="ml-auto"><?=$comment['created_at'];?></small>
        <!-- заблокированные коментарии -->
        <?php if ($_SESSION['admin'] == 1 && $comment['banned'] ==1 ):?>
            <a class="text-warning ml-auto"  href="/unBannedComment/<?=$comment['id'];?>">
                <i class="fa fa-lunock btn btn-warning"></i>Разблокировать комментарий</a>   
        <?php elseif ($_SESSION['admin'] == 1 && $comment['banned'] == 0):?>
            <a class="text-danger ml-auto"  href="/bannedComment/<?=$comment['id'];?>">
                <i class="fa fa-lock btn btn-danger"></i>Заблокировать комментарий</a>
        <?php endif;?> 
        <form action="/deleteComment/<?=$comment['id'];?>" method="POST"  class=" m-auto">
            <label class="form-label" for="simpleinput"></label>
            <input type="text" id="simpleinput" class="form-control" name="post_id" value="<?=$comment['post_id'];?>" hidden>
            <input type="text" id="simpleinput" class="form-control" name="user_id" value="<?=$_SESSION['user_id'];?> "  hidden> 
          <button class="btn btn-info" type="submit" onclick="return confirm('are your sure?')" name="submit">Удалить комментарий</button>
        </form>     
        </div>
    <?php if ($_SESSION['admin'] == 1 && $comment['banned'] == 1):?>
    <h6 id="scrollspyHeading1 btn-danger" class="bg-danger bg-danger-gradient pt-4 pb-4 pl-4 text-white rounded-bottom" > Комментарий заблокирован из-за нарушения правил пользования веб сайтом :  <?=$comment['comment'];?></h6>    
    <?php elseif ($comment['banned'] == 1):?>
    <h6 id="scrollspyHeading1 btn-danger" class="bg-secondary bg-secondary-gradient pt-4 pb-4 pl-4 text-white rounded-bottom" > Комментарий заблокирован из-за нарушения правил пользования веб сайтом</h6>
    <?php else:?>
    <h6 id="scrollspyHeading1" class=" bg-info-gradient pt-4 pb-4 pl-4 rounded-bottom" ><?=$comment['comment'];?></h6>
    <?php endif;?>
    </div> 
   <?php endif;?> 
   
   <?php endforeach;?>
  </div>
 
  
</main> 
<script src="js/vendors.bundle.js"></script>
<script src="js/app.bundle.js"></script>
    
        