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

<main id="js-page-content" role="main" class="page-content mt-3">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-user'></i> Фотография из поста: <?=$post['name_post'];?> 
        </h1>
    </div> 
    <div class="row">
      <div class="col-lg-10 col-xl-10 m-auto">
            <!-- profile summary -->
            <div class="card mb-g rounded-top">
                <div class="row no-gutters row-grid">
                    <div class="col-12">
                        <div class="d-flex flex-column align-items-center justify-content-center p-4">
                            <!-- menu edit -->
                                <a class="dropdown-item" href="/post/<?=$image[0]['post_id'];?>">
                                    <i class="fa fa-edit btn btn-info"></i>
                                Закрыть фотографию</a>
                                <?php if ( $_SESSION['admin'] == 1 || $_SESSION['user_id'] == $image[0]['user_id']):?>
                                <!-- повторное подтверждение пароля для безопасности -->
                                <a class="dropdown-item" onclick="return confirm('are your sure?')" href="/delete_image/<?=$image[0]['id'];?>" >
                                    <i class="fa fa-window-close btn btn-info"></i>
                                Удалить фотографию</a>    
                                <?php endif;?>
                                
                            <div class="container">
                                <h2 align="center">Фотография из галереи поста</h2>
                                
                                <div class="row">    
                                    <div class="coll-ml-auto ">        
                                        <img  src="/lesson-project-php-mvc/public/<?=$image[0]['image'];?>" alt="" class="img-fluid img-thumbnail gallery-image" >
                                    </div>    
                                </div>    
                            </div>          
                    </div>    
                </div>
            </div>
       </div>   
    </div>
    <br>
    <br>
    
      <script src="js/vendors.bundle.js"></script>
      <script src="js/app.bundle.js"></script>
      <script>
  
          $(document).ready(function()
          {
  
          });
  
      </script>      
      
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

        