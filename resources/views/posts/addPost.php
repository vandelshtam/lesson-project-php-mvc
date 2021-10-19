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



    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-user'></i> Добавление нового поста
        </h1>
    </div>
    <div class="row ">
    <form action="/addPost/<?=$_SESSION['user_id'];?>" method="POST" enctype="multipart/form-data" class="col-lg-12 col-xl-12 m-auto">
        
      <div class="col-lg-12 col-xl-12 m-auto">
            <!-- пост -->
            <div class="card mb-g rounded-top">
                <div class="row no-gutters row-grid">    
                    <div class="col-12">    
                        <div class="d-flex flex-column align-items-center justify-content-center p-4">    
                            <!-- аватар поста -->    
                            <h2 align="center">Аватар поста</h2>
                            <div class="panel-container col-lg-12 col-xl-12 m-auto" >       
                                <div class="panel-content" >       
                                    <div class="form-group">
                                        <label class="form-label" for="example-fileinput">Выберите аватар</label>
                                        <input type="file" id="example-fileinput" class="form-control-file" name="avatar_post">
                                    </div>   
                                </div>
                            </div>
                            <br>
                            <hr> 

                            <!-- фотографии поста -->
                            <div class="container">
                                <h2 align="center">My galery</h2>    
                            </div>
                            <div class="panel-container col-lg-12 col-xl-12 m-auto" >
                                <div class="panel-content" >   
                                    <div class="form-group">
                                        <label class="form-label" for="example-fileinput">Выберите фотографию</label>
                                        <input type="file" id="example-fileinput" class="form-control-file" name="image">
                                    </div>   
                                </div>
                            </div> 

                            <!-- Название поста -->
                            <h5 class="col-md-12 text-center mt-3">   
                                <div class="form-group ">
                                    <label class="form-label" for="simpleinput">Введите название поста</label>
                                    <input type="text" id="simpleinput" class="form-control" name="name_post" value="<?php if(isset($_POST['name_post'])){echo $_POST['name_post'];}?>">
                                </div>

                            <!-- заголовок поста -->
                            <h5 class="col-md-12 text-center mt-3">    
                                <div class="form-group ">
                                    <label class="form-label" for="simpleinput">Введите заголовок поста</label>
                                    <input type="text" id="simpleinput" class="form-control" name="title_post" value="<?php if(isset($_POST['title_post'])){echo $_POST['title_post'];}?>">
                                </div>

                            <!-- текст поста -->
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Введите текст поста</label>
                                <input type="text" id="simpleinput" class="form-control" name="text" value="<?php if(isset($_POST['text'])){echo $_POST['text'];}?>" style="height: 100px">
                            </div>       
                            </h5>    
                        </div>
                    </div>    
                </div>
            </div>
       </div>

       <!-- конопка добавления поста -->
       <div class="col-md-12 mt-3 d-flex flex-row-reverse">
        <button class="btn btn-info" type="submit" name="submit">Сохранить и добавить пост</button>
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
    
        