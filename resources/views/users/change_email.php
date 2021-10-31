<?php use App\Models\flashMessage;?>     
    <main id="js-page-content" role="main" class="page-content mt-3">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-lock'></i> Безопасность
            </h1>
        </div>
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
        <form action="" method="POST">
            <div class="row">
                <div class="col-xl-6">
                    <div id="panel-1" class="panel">
                        <div class="panel-container">
                            <div class="panel-hdr">
                                <h2>Обновление эл. адреса и пароля</h2>
                            </div>
                            <div class="panel-content">
                                <!-- email -->
                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Email</label>
                                    <input type="text" id="simpleinput" class="form-control" value="<?php if(isset($_POST['email'])){echo $_POST['email'];}?>" name="email">
                                </div>

                                <!-- new email -->
                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">New Email</label>
                                    <input type="text" id="simpleinput" class="form-control" value="<?php if(isset($_POST['new_email'])){echo $_POST['new_email'];}?>" name="new_email">
                                </div>

                                <!-- confirm email -->
                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">confirm Email</label>
                                    <input type="text" id="simpleinput" class="form-control" value="<?php if(isset($_POST['confirm_email'])){echo $_POST['confirm_email'];}?>" name="confirm_email">
                                </div>

                                <!-- password -->
                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Введите пароль для подтверждения</label>
                                    <input type="password" id="simpleinput" class="form-control" name="password">
                                </div>

                                <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                    <button class="btn btn-warning" name="submit">Изменить</button>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </form>
    </main>
    </body>
    <script src="/lesson-project-php-mvc/public/js/vendors.bundle.js"></script>
    <script src="/lesson-project-php-mvc/public/js/app.bundle.js"></script>
    