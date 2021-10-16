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

public function makeNewAvatarPost(){ 
  $image_name=$_FILES['avatar_post']['name']; 
  $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $strength = 6; 
  $random_string = $this ->  generate_string($permitted_chars,$strength);      
  $new_avatar='uploads/'.$random_string.$image_name;
  return $new_avatar;
}

public function makeNewImagePost(){ 
  $image_name=$_FILES['image']['name'];
  $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $strength = 6;
  $random_string = $this ->  generate_string($permitted_chars,$strength);     
  $new_image='uploads/'.$random_string.$image_name;
  return $new_image;
}

public function generate_string($input,$strength){
  $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
 
    return $random_string;  
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

public function loadingFileAvatarPost($new_avatar){
  $direct='/Applications/MAMP/htdocs/lesson-project-php-mvc/public/';
  $image_name_tmp=$_FILES['avatar_post']['tmp_name'];
  if(is_uploaded_file($image_name_tmp)){
    if(move_uploaded_file($image_name_tmp, $direct.$new_avatar )){
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

public function loadingFileImagePost($new_image){
  $direct='/Applications/MAMP/htdocs/lesson-project-php-mvc/public/';
  $image_name_tmp=$_FILES['image']['tmp_name'];
  if(is_uploaded_file($image_name_tmp)){
    if(move_uploaded_file($image_name_tmp, $direct.$new_image )){
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

function delete_file_post($table,$param,$id)
{     
    $user = $this->db->getOneParam($table,$param,$id);   
    if($user['avatar_post']!=null)
    {
        unlink($user['avatar_post']);
    }    
}

function delete_image_post($table,$param,$param2,$id)
{     
    $image = $this->db->getOneParam($table,$param,$id);   
    if($image['image']!=null)
    {
        unlink($image['image']);
    }    
}

public function createImage($table,$data){
  $this->db->create($table,$data);
}

}