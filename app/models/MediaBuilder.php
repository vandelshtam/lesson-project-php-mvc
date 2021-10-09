<?php 
namespace App\Models;

use App\Core\Model;
use Imagick;

class MediaBuilder extends Model{

  
  
  public function set_file_image($image_name_tmp,$direct,$image_name){
    is_uploaded_file($image_name_tmp);
    move_uploaded_file($image_name_tmp, $direct.$image_name);
}




public function updateAvatar($data, $id, $table){
  $this->db->update($data,$id,$table);   
}




public function makeNewAvatar($image_name){        
  $new_avatar='uploads/'.$image_name;
  return $new_avatar;
}





public function loadingFileAvatar($image_name_tmp,$direct,$image_name){
  if(is_uploaded_file($image_name_tmp)){
    if(move_uploaded_file($image_name_tmp, $direct.$image_name )){
      return true;
    }
    else {
      return false;
    }
  }
  else{
    return false;
  }  
}



function delete_file($table,$id)
{    
    $user = $this->db->getOne($table,$id);   
    if($user['avatar']!=null)
    {
        unlink($user['avatar']);
    }    
}

}