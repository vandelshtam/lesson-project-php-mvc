<?php use App\Models\flashMessage;?>    
<main id="js-page-content" role="main" class="page-content mt-3">

            <!-- флеш сообщения -->
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
            <i class='subheader-icon fal fa-user'></i> Название поста
        </h1>
    </div>
     
    <!--вывод информации поста -->
    <div class="row ">
    <!--<form action="" method="POST" enctype="multipart/form-data" class="col-lg-12 col-xl-12 m-auto">-->
        
        <div class="col-lg-12 col-xl-12 m-auto">
            <!-- пост -->
            <div class="card mb-g rounded-top">
                <div class="row no-gutters row-grid">    
                    <div class="col-12">        
                        <div class="d-flex flex-column align-items-center justify-content-center p-4">    
                                <?php if($_SESSION['admin'] == 1 || $_SESSION['user_id'] == $post['user_id']):?>
                                <a class="dropdown-item" onclick="return confirm('are your sure?')" href="/post/<?=$post['id'];?>">
                                    <i class="fa fa-sun btn btn-info"></i>
                                 Вернуться к посту</a>        
                                <a class="dropdown-item" onclick="return confirm('are your sure?')" href="/deletePost/<?=$post['id'];?>">
                                    <i class="fa fa-window-close btn btn-info"></i>
                                Удалить пост</a>    
                                <?php endif;?>   

                            <!-- аватар поста --> 
                        <form action="" method="POST" enctype="multipart/form-data" class="col-lg-12 col-xl-12 m-auto">       
                            <h2 align="center">Аватар поста</h2>
                            <img src="/lesson-project-php-mvc/public/<?=$post['avatar_post'];?>" class="rounded-circle shadow-2 img-thumbnail col-lg-10 col-xl-10" alt="" >
                            <div class="panel-container col-lg-12 col-xl-12 m-auto" >
                                <div class="panel-hdr">
                                    <h2>Текущий аватар</h2>
                                </div>
                                <div class="panel-content" >   
                                    <div class="form-group">
                                        <label class="form-label" for="example-fileinput">Выберите аватар</label>
                                        <input type="file" id="example-fileinput" class="form-control-file" name="avatar_post">
                                    </div>    
                                    <div class="col-lg-11 col-xl-11 m-auto d-flex flex-row-reverse">   
                                        <button class="btn btn-warning" type="submit" name="submit">Загрузить аватар</button>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <hr> 
                        </form>
                            <!-- фотографии поста -->
                            <div class="container">
                                <h2 align="center">My galery</h2>
                                <div class="row">
                                    <?php foreach ($images as $image):?>
                                        <div class="col-md-3 galery-item">
                                            <div>
                                                <img src="/lesson-project-php-mvc/public/<?=$image['image'];?>" alt="" class="img-fluid img-thumbnail">
                                            </div>
                                        <input type="file" id="example-fileinput" class="form-control-file" name="delete_image" hidden>    
                                        <a href="/delete_image/<?=$image['id'];?>" onclick="return confirm('are your sure?')" class="btn btn-danger my-button">Delete image</a>
                                        </div>
                                    <?php endforeach;?>   
                                </div>
                            </div>
                            <div class="panel-container col-lg-12 col-xl-12 m-auto" >
                                <div class="panel-hdr">
                                    <h2>Текущие фотографии в галерее</h2>
                                </div>
                                <div class="panel-content" >  
                                    <form action="" method="POST" enctype="multipart/form-data" class="col-lg-12 col-xl-12 m-auto"> 
                                         
                                    <div class="form-group">
                                        <label class="form-label" for="example-fileinput">Выберите фотографии</label>
                                        <input type="file" id="example-fileinput" class="form-control-file" name="image">
                                    </div>
                                    <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                        <button class="btn btn-warning" type="submit" name="submit_image">Загрузить фотографии</button>
                                    </div>
                                    </form>
                                </div>
                            </div> 

            <form action="" method="POST" enctype="multipart/form-data" class="col-lg-12 col-xl-12 m-auto">
                                
                            <!-- Название поста -->
                            <h5 class="col-md-12 text-center mt-3">   
                                <div class="form-group ">
                                    <label class="form-label" for="simpleinput">Введите название поста</label>
                                    <input type="text" id="simpleinput" class="form-control" name="name_post" value="<?=$post['name_post'];?>">
                                </div>

                            <!-- заголовок поста -->
                            <h5 class="col-md-12 text-center mt-3">    
                                <div class="form-group ">
                                    <label class="form-label" for="simpleinput">Введите заголовок поста</label>
                                    <input type="text" id="simpleinput" class="form-control" name="title_post" value="<?=$post['title_post'];?>">
                                </div>

                            <!-- текст поста -->
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Введите текст поста</label>
                                <input type="text" id="simpleinput" class="form-control" name="text" value="<?=$post['text'];?>" style="height: 100px">
                            </div>       
                        </div>
                    </div>    
                </div>
                <div class="col-lg-11 col-xl-11 ml-auto mr-5 mb-4 d-flex flex-row-reverse ">
                <button class="btn btn-info" type="submit" onclick="return confirm('are your sure?')" name="submit">Сохранить изменения</button>
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

<script src="js/vendors.bundle.js"></script>
    <script src="js/app.bundle.js"></script>
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

        