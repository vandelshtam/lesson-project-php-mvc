<?php 
namespace App\Models;

use App\Core\Model;
use Imagick;

class MediaBuilder extends Model{


//создание имени новой картинки
public function makeNewImage($name_image_file){ 
  $image_name=$_FILES[''.$name_image_file.'']['name']; 
  $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $strength = 10; 
  $random_string = $this ->  generate_string($permitted_chars,$strength);      
  $new_avatar = 'uploads/'.$random_string.$image_name;
  return $new_avatar;
}




//загрузка новой картинки в папку проекта
public function loadingFileImage($new_image, $name_image_file){
  $direct='/Applications/MAMP/htdocs/lesson-project-php-mvc/public/';
  $image_name_tmp=$_FILES[''.$name_image_file.'']['tmp_name'];
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




//удаление картинки из папки проекта
public function delete_image($table,$param,$param2,$value)
{     
    $image = $this->db->getOneParam($table,$param,$value);
    if(isset($image[''.$param2.'']))
    {
        $image_param = strchr($image[''.$param2.''], '/');
        $image = strtr($image_param, '/', '');
        unlink('uploads/'.$image);
    }    
}



//удаление картинок из папки проекта
public function delete_images($table,$param,$param2,$value)
{     
    $images = $this->db->getAllParam($table,$param,$value);

      foreach($images as $image){
        if(isset($image[''.$param2.'']))
        {
            $image_param = strchr($image[''.$param2.''], '/');
            $image = strtr($image_param, '/', '');
            unlink('uploads/'.$image);
        } 
      } 
   
}




//запись новой картинки в галерею поста
public function createImage($table,$data){
  $this->db->create($table,$data);
}




//обновление аватара поста
public function updateAvatar($table, $data, $param, $value){
  $this->db->updateAny($table, $data, $param, $value);   
}




 // удалить запись ссылки на фотографию из таблицы
 public function  deleteImage($table,$id){          
  return $this->db->delete($table,$id);
} 





//удаление группы картинок
public function delete_all_images_file($table,$value,$param_value,$param_where,$param_order,$param_sort){     
  $images = $this->db->getTableParams($table,$value,$param_value,$param_where,$param_order,$param_sort); 
  foreach($images as $image){
    if(isset($image['image']))
    {
        $image_param = strchr($image['image'], '/');
        $image = strtr($image_param, '/', '');
        unlink('uploads/'.$image);
    }
  }    
}





//генерирование приставки к имени картинки, для создания нового названия 
private function generate_string($input,$strength){
  $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
    return $random_string;  
}

}