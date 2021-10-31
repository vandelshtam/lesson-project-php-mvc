<?php use App\Models\flashMessage;?>    
<main id="js-page-content" role="main" class="page-content mt-6">

            <!-- флеш сообщения -->
            <?php if(isset($_SESSION['success'])):;?>
            <div class="alert alert-success mt-3" >
            <?php flashMessage::display_flash('success') ;?>
            </div>
            <?php endif;?>

            <?php if(isset($_SESSION['danger'])):;?>
            <div class="alert alert-danger mt-3" >
            <?php flashMessage::display_flash('danger') ;?>
            </div>
            <?php endif;?> 
                                            
            <?php if(isset($_SESSION['info'])):;?>
            <div class="alert alert-info mt-3" >
            <?php flashMessage::display_flash('info') ;?>
            </div>
            <?php endif;?>
            <!-- флеш сообщения -->
            
            <div class="row sticky-top bg-white mt-5">
                <div class="col-xl-12">
                <?php if ($_SESSION['auth'] == true || $_SESSION['admin'] == 1):?>
                    <a class="btn btn-info" href="/addPost">Добавить пост</a>
                <?php endif;?>
                    
                    <div class="border-faded bg-faded p-3 mb-g d-flex mt-3">
                        <input type="text" id="js-filter-contacts" name="filter-contacts" class="form-control shadow-inset-2 form-control-lg" placeholder="Найти пост">
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

<div class="row" id="js-contacts">
    <?php foreach ($posts as $post):?>
        <div class="col-xl-4">
        <div id="<?php echo $post['c'];?>" class="card border shadow-0 mb-g shadow-sm-hover" data-filter-tags="<?php echo $post['search_post'];?>">
    <!-- не заблокированные посты -->
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-user'></i> <?=$post['name_post'];?>
        </h1>
    </div> 
    
                <div class="row no-gutters row-grid">   
                    <div class="col-12">   
                        <div class="d-flex flex-column align-items-center justify-content-center p-4"> 
                            
                            <?php if($_SESSION['auth'] == true):?>
                                <?php if($post['banned'] == 0 || $_SESSION['admin'] == 1):?>
                                <a class="dropdown-item"  href="/post/<?=$post['post_id'];?>">
                                    <i class="fa fa-edit btn btn-info"></i>
                                Открыть пост</a>
                                <?php endif;?>
                                <?php if ($post['banned'] == 0 && $post['favorites'] == 1):?>
                                    <a class="dropdown-item"  href="/deleteFavorites/<?=$post['post_id'];?>">
                                        <i class="fa fa-sun btn btn-warning"></i>Удалить из избранного</a>    
                                <?php endif;?>
                                <?php if($post['banned'] == 0 && $post['favorites'] == 0):?>
                                    <a class="dropdown-item"  href="/addFavorites/<?=$post['post_id'];?>">
                                        <i class="fa fa-sun btn btn-info"></i>Добавить в избранное</a>    
                                 <?php endif;?> 
                                 <?php if ($post['banned'] == 1 && $_SESSION['admin'] == 1):?>
                                    <a class="dropdown-item"  href="/unBannedPost/<?=$post['post_id'];?>">
                                        <i class="fa fa-unlock btn btn-warning"></i>Разблокировать пост</a>   
                                <?php endif;?>
                                <?php if($post['banned'] == 0 && $_SESSION['admin'] == 1):?> 
                                    <a class="dropdown-item"  href="/bannedPost/<?=$post['post_id'];?>">
                                        <i class="fa fa-lock btn btn-danger"></i>Заблокировать пост</a>
                                <?php endif;?> 
                                <button class="js-expand-btn btn btn-sm btn-default d-none" data-toggle="collapse" data-target="#<?php echo $post['c'];?> > .card-body + .card-body" aria-expanded="false">
                                    <span class="collapsed-hidden">+</span>
                                    <span class="collapsed-reveal">-</span>
                                </button>
                            <?php endif;?>   
                            <br>
                            <br>
                            <br> 
                            <?php if($post['banned'] == 1):?>
                            <img src="'/lesson-project-php-mvc/public/img/demo/avatars/avatar-m.png'" class="rounded-circle shadow-2 img-thumbnail" alt=""">
                            <?php else:?>
                            <img src="/lesson-project-php-mvc/public/<?=$post['avatar_post'];?>" class="rounded-circle shadow-2 img-thumbnail" alt=""">
                            <?php endif;?>
                            <h5 class="mb-0 fw-700 text-center mt-3">
                                <?php if($post['banned'] == 1):?>
                                <h5 class="mb-0 fw-700 text-center mt-3 btn btn-danger">
                                    Пост заблокирован из-за нарушения правил веб сайта о публикации материалов
                                    <small class="text-muted mb-0 btn btn-danger">Пост заблокирован из-за нарушения правил веб сайта о публикации материалов</small>
                                        <hr>
                                </h5>
                                <?php else:?>
                                    <?=$post['title_post'];?>
                                <small class="text-muted mb-0"><?=$post['text'];?></small>
                                    <hr>
                                </h5>
                                <h5 class="mb-0 fw-700 text-center mt-3">
                                <?=$post['name'];?>
                                    <small class="text-muted mb-0"><?=$post['location'];?></small>
                            </h5> 
                                <?php endif;?>   
                        </div>
                    </div>   
                </div>
            
        </div>
        </div>
    <?php endforeach;?> 
</div>
</main>
<script src="/lesson-project-php-mvc/public/js/vendors.bundle.js"></script>
    <script src="/lesson-project-php-mvc/public/js/app.bundle.js"></script>
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

        