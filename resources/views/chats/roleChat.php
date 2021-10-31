<?php use App\Models\flashMessage;?>    
    <main id="js-page-content" role="main" class="page-content mt-6">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-sun'></i> Установить роль
            </h1>
        </div>
<!-- флеш сообщения -->
<?php if(isset($_SESSION['success'])):;?>
    <div class="alert alert-success mt-5" >
        <?php flashMessage::display_flash('success') ;?>
    </div>
<?php endif;?>

<?php if(isset($_SESSION['danger'])):;?>
    <div class="alert alert-danger mt-5" ">
        <?php flashMessage::display_flash('danger') ;?>
    </div>
<?php endif;?> 
                                            
<?php if(isset($_SESSION['info'])):;?>
    <div class="alert alert-info mt-5" ">
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
        <form action="/setRoleChat/<?=$_SESSION['chat_id'];?>" method="POST">
            <div class="row">
                <div class="col-xl-6">
                    <div id="panel-1" class="panel">
                        <div class="panel-container">
                            <div class="panel-hdr">
                                <h2>Установка роли</h2>
                            </div>
                            <div class="panel-content">
                                <div class="row">
                                    <div class="col-md-4">
                                        <!-- status -->
                                        <div class="form-group">
                                            <label class="form-label" for="example-select">Выберите статус</label>
                                            <select class="form-control" id="example-select" name="role">
                                            <?php foreach ($statuses as $key => $status):?>       
                                                    <option><?=$status;?></option>      
                                            <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <!-- status -->
                                        <div class="form-group">
                                            <label class="form-label" for="example-select">Выберите статус</label>
                                            
                                            <select class="form-control" id="example-select" name="user">
                                            <?php foreach ($users as $key => $user):?> 
                                                          
                                                    <option value="<?=$user['user_id'];?>">Имя пользователя : <?=$user['name'];?>;   Текущая роль : <?=$user['role_chat'];?></option>       
                                            <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                        <button class="btn btn-warning" onclick="return confirm('ВНИМАНИЕ! предоставляя роль author другому пользователю, вы теряете эту роль. Вам автоматически будет присвоена роль moderator, вы потеряете часть возможностей. Are you sure?');">Set Role</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            
                        
        </form>
    </main>

    <script src="/lesson-project-php-mvc/public/js/vendors.bundle.js"></script>
    <script src="/lesson-project-php-mvc/public/js/app.bundle.js"></script>
