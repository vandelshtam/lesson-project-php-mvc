<?php
include 'function.php';
$db = include 'database/start.php';

$post = $db->getOne('posts', $_GET['id']);

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Create Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  </head>
  <body>
  <div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <form action="/php/lessons_php/module_1/update.php?id=<?php echo $post['id'];?>" method="POST">
            
                <div class="form-group">
                    <label for="">Title</label>
                    <input type="text" name="title" class="form-control" value="<?php echo $post['title'];?>" >
                </div>
                <div class="form-group"><button class="btn btn-success" type="send">Edit Post</button></div>
            </form>
        </div>
    </div>
  </div>
  </body>
</html>