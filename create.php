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
            <form action="/php/lessons_php/module_1/store.php" method="POST">
                <div class="form-group">
                    <label for="">Title</label>
                    <input type="text" name="title" class="form-control">
                </div>
                <div class="form-group"><button class="btn btn-success" type="send">Add Post</button></div>
            </form>
        </div>
    </div>
  </div>
  </body>
</html>