<?php use App\Models\flashMessage;?>    
    <main id="js-page-content" role="main" class="page-content mt-3">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-sun'></i> Установить статус
            </h1>
        </div>
            
        <form action="/statusSet/<?=$vars['users']['user_id'];?>" method="POST">
            <div class="row">
                <div class="col-xl-6">
                    <div id="panel-1" class="panel">
                        <div class="panel-container">
                            <div class="panel-hdr">
                                <h2>Установка текущего статуса</h2>
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
                                        <button class="btn btn-warning">Set Status</button>
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