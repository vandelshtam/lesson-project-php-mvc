<?php use App\Models\flashMessage;?> 
<main id="js-page-content" role="main" class="page-content mt-6">

        <!-- флеш сообщения - начало блока -->
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
            <!-- флеш сообщения - окончание блока -->
        <div class="sticky-top bg-white">
            
            <div class="subheader  mt-5">
                <h1 class="subheader-title">
                    <i class='subheader-icon fal fa-users'></i> Список чатов
                </h1>
            </div>
            
                <!--  блоки: добавить чат и поиск чатов -->
            <div class="row  ">
                
                <div class="col-xl-12">
                    <?php if ($_SESSION['auth'] == true || $_SESSION['admin'] == 1):?>
                        <a class="btn btn-info" href="/addChatShow/<?=$_SESSION['user_id'];?>">Добавить чат</a>
                    <?php endif;?>
                    
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
        </div>
    

            <!-- вывод списка всех чатов  -->
            <div class="row" id="js-contacts">
                <?php if($_SESSION['admin'] == 1 || $_SESSION['auth'] == true):?>
                <?php foreach ($chats as $chat):?>
                
                <div class="col-xl-4">
                    <div id="<?=$chat['c'];?>" class="card border shadow-0 mb-g shadow-sm-hover" data-filter-tags="<?=$chat['search'];?>">
                        <div class="card-body border-faded border-top-0 border-left-0 border-right-0 rounded-top">
                            <div class="d-flex flex-row align-items-center">
                                <!-- статус чата -->
                                <?php if ($chat['banned'] == 0):?>
                                    <span class="status status-success mr-3">
                                <?php endif;?>
                                <?php if ($chat['banned'] == 1):?>
                                    <span class="status status-danger mr-3">
                                <?php endif;?>
                                    <span class="rounded-circle profile-image d-block " style="background-image:url('/lesson-project-php-mvc/public/uploads/<?=$chat['chat_avatar'];?>'); background-size: cover;"></span>
                                </span>
                                
                                <div class="info-card-text flex-1">
                                    
                                    <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg text-info" data-toggle="dropdown" aria-expanded="false">
                                        
                                        <?=$chat['names'];?>
                                        <i class="fal fas fa-cog fa-fw d-inline-block ml-1 fs-md"></i>
                                        <i class="fal fa-angle-down d-inline-block ml-1 fs-md"></i>
                                        <?php if($_SESSION['admin'] != 1 && $chat['favorites'] == 1):?>
                                            <span class="star ml-3">В избранном</span>
                                        
                                        <?php elseif($_SESSION['admin'] != 1 && $chat['favorites_chat'] == 1):?> 
                                            <span class="star ml-3">В избранном</span>
                                        <?php endif;?>
                                    </a>

                                    <!--выпадающее подменю-->
                                    <?php if ($_SESSION['admin'] == 1  || ($_SESSION['auth'] == true && $chat['banned'] !=1)):?>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="/openChat/<?=$chat['id'];?>">
                                            <i class="fa fa-edit"></i>
                                        Открыть чат</a> 
                                        <?php if ($chat['favorites'] == 1 || $chat['favorites_chat'] == 1):?>
                                        <a class="dropdown-item btn-warning" href="/offFavorites/<?=$chat['chat_id'];?>">
                                            <i class="fa fa-lock"></i>
                                        Удалить из  избранного</a>    
                                        <?php else:?>
                                        <a class="dropdown-item" href="/onFavorites/<?=$chat['chat_id'];?>">
                                            <i class="fa fa-lock"></i>
                                        Добавить в избранные</a>
                                        <?php endif;?>
                                        
                                        <?php if ($_SESSION['admin'] == 1 || ($_SESSION['user_id'] == $chat['author_user_id'] &&  $chat['banned'] !=1) || $chat['role_chat'] == 'moderator'):?>
                                        <a href="/editChatShow/<?=$chat['id'];?>" class="dropdown-item" >
                                            <i class="fa fa-window-close"></i>
                                        Редактировать чат
                                        </a>
                                        <?php endif;?>
                                        <?php if ($_SESSION['admin']):?>
                                            <?php if ($chat['banned'] == 1):?>
                                            <a class="dropdown-item btn-warning" href="/unBannedChat/<?=$chat['id'];?>">
                                                <i class="fa fa-lock"></i>
                                            Разблокировать чат</a>
                                            <?php else:?>
                                            <a class="dropdown-item btn-warning" href="/bannedChat/<?=$chat['id'];?>">
                                                <i class="fa fa-lock"></i>
                                            Заблокировать чат</a>      
                                            <?php endif;?>   
                                        <?php endif;?> 
                                        <?php if ($_SESSION['admin'] == 1  || ($_SESSION['user_id'] == $chat['author_user_id'] &&  $chat['banned'] !=1)):?>  
                                        <a href="/deleteChat/<?=$chat['id'];?>" class="dropdown-item" onclick="return confirm('are you sure?');">
                                            <i class="fa fa-window-close"></i>
                                        Удалить чат</a>
                                        <?php endif;?>   
                                    </div>
                                    <?php endif;?>
                                    <?php if ( $_SESSION['admin'] == 1 || ($_SESSION['user_id'] == $chat['author_user_id'] && ($chat['banned'] !=1))):?>
                                    <div class="dropdown-menu">  
                                    </div>
                                    <?php endif;?>
                                    <span class="text-truncate text-truncate-xl"><?=$chat['location'];?></span>
                                </div>
                                    <span class="text-truncate text-truncate-xl">Автор чата - <?=$chat['name'];?> </span>
                                    
                                <?php if ($chat['banned'] == 1):?>
                                    <span class="text-truncate text-truncate-xl ml-3 bt btn-danger">Чат заблокирован</span>
                                    
                                <?php else:?>
                                    <span class="text-truncate text-truncate-xl ml-3 bt btn-success">Активный чат</span>
                                <?php endif;?>
                                <button class="js-expand-btn btn btn-sm btn-default d-none" data-toggle="collapse" data-target="#c_1 > .card-body + .card-body" aria-expanded="false">
                                    <span class="collapsed-hidden">+</span>
                                    <span class="collapsed-reveal">-</span>
                                </button>
                            </div>
                        </div>    
                    </div>
                </div> 
                <?php endforeach;?> 
                <?php endif;?> 
            </div>
        <div>   
    </div> 
</main>

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

        