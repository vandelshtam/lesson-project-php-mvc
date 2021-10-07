<?php 
namespace App\Models;

use App\Core\Model;
use Imagick;

class MediaBuilder extends Model{

  
  
  public function set_file_image($image_name_tmp, $image_name, $direct)
{
  //$direct='/Applications/MAMP/htdocs/lesson-project-php-mvc/public/uploads/';
  //echo $direct;
    
    is_uploaded_file($image_name_tmp);
    move_uploaded_file($image_name_tmp, $direct.$image_name);
}
public function updateAvatar($data, $id, $table){

  $this->db->update($data,$id,$table);   
}
}