<?php 
namespace App\Models;

use App\Core\Model;
use Imagick;

class MediaBuilder extends Model{


public function updateAvatar($table, $data, $id){
  $this->db->update($table, $data, $id);   
}


public function makeNewAvatar(){ 
  $image_name=$_FILES['avatar']['name'];       
  $new_avatar='uploads/'.$image_name;
  return $new_avatar;
}

public function loadingFileAvatar(){
  $direct='/Applications/MAMP/htdocs/lesson-project-php-mvc/public/uploads/';
  $image_name=$_FILES['avatar']['name'];
  $image_name_tmp=$_FILES['avatar']['tmp_name'];
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

function delete_file($table,$param,$id)
{     
    $user = $this->db->getOneParam($table,$param,$id);   
    if($user['avatar']!=null)
    {
        unlink($user['avatar']);
    }    
}

}