<?php use App\Models\flashMessage;?>    
    <main id="js-page-content" role="main" class="page-content mt-3">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-sun'></i> Установить роль
            </h1>
        </div>
            
        <form action="/roleChat/<?=$vars['users_id'];?>" method="POST">
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
                                            <select class="form-control" id="example-select" name="status">
                                            <?php foreach ($vars['status'] as $key => $var):?>
                                                
                                                    <?php if ($key == $vars['users']['status']): ?>
                                                        <option selected><?=$vars['status'][$key]; ?></option>
                                                    <?php else:?>
                                                        <option><?=$var;?></option>
                                                    <?php endif;?>
                                            <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                        <button class="btn btn-warning">Set Role</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="row p-2 form-check" id="js-contacts">
            
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
                                                            <input class="form-check-input" type="text"  name="user_<?=$user['id'];?>"   value="<?=$user['id'];?>" hidden>
                                                            <input class="form-check-input" type="radio"  name="flexRadioDefault" id="flexRadioDefault1">
                                                            <label class="form-check-label" for="flexRadioDefault1">Выбрать пользователя</label>
                                                    </span>
                                            </div>
                                        </div>    
                                    </div>

                                </div> 
                    <?php endforeach;?>
                    <?php endif;?> 
                    </div>    
                        
        </form>
    </main>

    <script src="/lesson-project-php-mvc/public/js/vendors.bundle.js"></script>
    <script src="/lesson-project-php-mvc/public/js/app.bundle.js"></script>
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
</body>
</html>