<?php use App\Models\flashMessage;?>             
            <main id="js-page-content" role="main" class="page-content mt-5">
            <div class="subheader mt-5">   
                <h1 class="subheader-title">
            </div>
            <!-- флеш сообщения - начало блока -->
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
            <!-- флеш сообщения - окончание блока -->

            <!-- название чата  -->
            <div class="subheader mt-5">   
                <h1 class="subheader-title">
                    <i class='subheader-icon fal fa-users'></i><?=$chat[0]['name_chat'];?> 
                </h1>
            </div>

            <!-- отправка сообщения -->
            <form action="/message/<?=$chat[0]['name_chat'];?>" method="GET" class="col-lg-12 col-xl-12 ml-auto fixed-bottom mt-15">
                                
                <div class="border-faded bg-faded p-3 mb-g d-flex mt-3 ">
                    <input type="text"  name="message"  placeholder="Ввести текст сообщения" style="width: 1100px;">
                    <div class="btn-group btn-group-lg btn-group-toggle hidden-lg-down ml-3" data-toggle="buttons">
                    </div>
                    <button class="col-lg-2 col-xl-2 ml-auto btn btn-info" type="submit" name="submit">Отправить</button>
                </div>
            </form>    


            <!-- вывод сообщений чата -->
            <div class="row mb-6">
                <!-- вывод сообщений   участников чата --> 
                <?php foreach ($messages as $message):?>
                <?php if($_SESSION['user_id'] != $message['user_id']):?>
                <div class="col-lg-8 col-xl-8 ml-auto mb-3 mt-3">
                    <div id="c_1" class="card border shadow-0 mb-g shadow-sm-hover rounded">
                        <div class="card-body border-faded border-top-0 border-left-0 border-right-0 rounded-top bg-warning bg-info-gradient" >
                            <div class="d-flex flex-row align-items-center ">
                                
                                <!-- статус пользователя -->
                                
                                <?php if ($message['status'] == 0):?>
                                    <span class="status status-success mr-3">
                                <?php endif;?>
                                <?php if ($message['status'] == 1):?>
                                    <span class="status status-danger mr-3">
                                <?php endif;?>
                                <?php if ($message['status'] == 2):?>
                                    <span class="status status-warning mr-3">
                                <?php endif;?>
                                    <span class="rounded-circle profile-image d-block " style="background-image:url('/lesson-project-php-mvc/public/uploads/<?=$message['avatar'];?>'); background-size: cover;"></span>
                                </span>
                                
                                <div class="info-card-text flex-1">
                                    <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg text-info" data-toggle="dropdown" aria-expanded="false">
                                        <?=$message['name'];?>
                                        <i class="fal fas fa-cog fa-fw d-inline-block ml-1 fs-md"></i>
                                        <i class="fal fa-angle-down d-inline-block ml-1 fs-md"></i>
                                    </a>

                                    <!--выпадающее подменю-->
                                    <?php if ( $_SESSION['admin']):?>
                                        <div class="dropdown-menu">
                                            
                                            <a href="/delete_message/<?=$message['id'];?>" class="dropdown-item" onclick="return confirm('are you sure?');">
                                                <i class="fa fa-window-close"></i>
                                            Удалить сообщение
                                            </a>   
                                        </div>
                                    <?php endif;?>
                                    <span class="text-truncate text-truncate-xl"><?=$message['created_at'];?></span>
                                    <p class="text-truncate text-truncate-xl  md-5">сообщение:</p>
                                    <span class="text-truncate text-truncate-xl  md-5" style="white-space: pre-wrap;"><?=$message['message'];?></span>
                                </div>       
                            </div>
                        </div>    
                    </div>
                    
                </div>  
                <?php endif;?> 
        
            <!-- вывод сообщений  авторизованного участника чата ( свои сообщения) -->
                <?php if($_SESSION['user_id'] == $message['user_id']):?>    
                    <div class="col-lg-8 col-xl-8 mr-auto mb-3 mt-3">
                        <div id="c_1" class="card border shadow-0 mb-g shadow-sm-hover rounded">
                            <div class="card-body border-faded border-top-0 border-left-0 border-right-0 rounded-top bg-blue bg-info-gradient" >
                                <div class="d-flex flex-row align-items-center ">
                                    <!-- статус пользователя -->
                                    
                                    <?php if ($message['status'] == 0):?>
                                        <span class="status status-success mr-3">
                                    <?php endif;?>
                                    <?php if ($message['status'] == 1):?>
                                        <span class="status status-danger mr-3">
                                    <?php endif;?>
                                    <?php if ($message['status'] == 2):?>
                                        <span class="status status-warning mr-3">
                                    <?php endif;?>
                                        <span class="rounded-circle profile-image d-block " style="background-image:url('/lesson-project-php-mvc/public/uploads/<?=$message['avatar'];?>'); background-size: cover;"></span></span>
                                    
                                        <div class="info-card-text flex-1">
                                            <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg text-info" data-toggle="dropdown" aria-expanded="false">
                                                <?=$message['name'];?>
                                                <i class="fal fas fa-cog fa-fw d-inline-block ml-1 fs-md"></i>
                                                <i class="fal fa-angle-down d-inline-block ml-1 fs-md"></i>
                                            </a>

                                            <!--выпадающее подменю-->
                                            <?php if ( $_SESSION['admin'] || $_SESSION['user_id'] == $message['user_id']):?>
                                                <div class="dropdown-menu row">
                                                    
                                                    <a href="/delete_message/<?=$message['id'];?>" class="dropdown-item" onclick="return confirm('are you sure?');">
                                                        <i class="fa fa-window-close"></i>
                                                    Удалить сообщение
                                                    </a>   
                                                </div>   
                                            <?php endif;?>
                                            <span class="text-truncate text-truncate-xl mr-auto"><?=$message['created_at'];?></span>
                                            <p class="text-truncate text-truncate-xl  md-5">сообщение:</p>
                                            <span class="text-truncate text-truncate-xl md-5" style="white-space: pre-wrap;"><?=$message['message'];?></span>
                                        </div>            
                                </div>
                            </div>    
                        </div>
                    </div> 
                <?php endif;?>  
    <?php endforeach;?>  
    </div> 
</main>

<script src="/lesson-project-php-mvc/public/js/vendors.bundle.js"></script>
    <script src="/lesson-project-php-mvc/public/js/app.bundle.js"></script>
    