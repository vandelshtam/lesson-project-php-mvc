<?php 
namespace App\Models;


class Validator {

  private $data;
  private $errors = [];
  private static $fields = ['name', 'email', 'password'];
  private static $fieldsEdit = ['name', 'occupation', 'location', 'phone'];
  private static $fieldsInfo = [ 'occupation', 'location', 'phone'];
  private static $fieldsSocial = [ 'vk', 'telegram', 'instagram'];
  private static $fieldsImage = [ 'avatar'];
  private static $fieldsCreate = ['name', 'email', 'password', 'occupation', 'location', 'phone','vk', 'telegram', 'instagram'];

  public function __construct($post_data){
    $this->data = $post_data;
  }

  public function validateForm(){

    foreach(self::$fields as $field){
      if(!array_key_exists($field, $this->data)){
        trigger_error("'$field' is not present in the data");
        return;
      }
    }

    $this->validateUsername();
    $this->validateEmail();
    $this->validatePassword();
    return $this->errors;

  }

  public function validateEditForm(){

    foreach(self::$fieldsEdit as $field){
      if(!array_key_exists($field, $this->data)){
        trigger_error("'$field' is not present in the data");
        return;
      }
    }

    $this->validatePhone();
    $this->validateOccupation();
    $this->validateLocation();
    $this->validateUsername();
    return $this->errors;

  }

  public function validateInfoUserForm(){

    foreach(self::$fieldsInfo as $field){
      if(!array_key_exists($field, $this->data)){
        trigger_error("'$field' is not present in the data");
        return;
      }
    }


    //$this->validatePhone();
    //$this->validateOccupation();
    //$this->validateLocation();

    
    if(!empty($_POST['phone'])){
      $this->validatePhone();
    }
    if(!empty($_POST['occupation'])){
      $this->validateOccupation();
    }
    if(!empty($_POST['location'])){
      $this->validateLocation();
    }

    return $this->errors;

  }

  public function validateCreateUserForm(){

    foreach(self::$fieldsInfo as $field){
      if(!array_key_exists($field, $this->data)){
        trigger_error("'$field' is not present in the data");
        return;
      }
    }


    $this->validateUsername();
    $this->validateEmail();
    $this->validatePassword();
    
    if(!empty($_POST['phone'])){
      $this->validatePhone();
    }
    if(!empty($_POST['occupation'])){
      $this->validateOccupation();
    }
    if(!empty($_POST['location'])){
      $this->validateLocation();
    }
    if(!empty($_POST['vk'])){
      $this->validateVk();
    }
    if(!empty($_POST['telegram'])){
      $this->validateTelegram();
    }
    if(!empty($_POST['instagram'])){
      $this->validateInstagram();
    }
    if(!empty($_FILES['avatar']['name'])){
      $this->validateImage();
    }

    return $this->errors;

  }


  public function validateInfoLocationForm(){

    foreach(self::$fieldsInfo as $field){
      if(!array_key_exists($field, $this->data)){
        trigger_error("'$field' is not present in the data");
        return;
      }
    }

    
    $this->validateLocation();
    return $this->errors;

  }

  public function validateSocialUserForm(){

    foreach(self::$fieldsSocial as $field){
      if(!array_key_exists($field, $this->data)){
        trigger_error("'$field' is not present in the data");
        return;
      }
    }

    if(isset($_POST['vk'])){
      $this->validateVk();
    }
    if(isset($_POST['telegram'])){
      $this->validateTelegram();
    }
    if(isset($_POST['instagram'])){
      $this->validateInstagram();
    }
    return $this->errors;

  }

  private function validateUsername(){

    $val = trim($this->data['name']);

    if(empty($val)){
      $this->addError('name', 'name cannot be empty');
    } else {
      if(!preg_match('/^[a-zA-Z0-9]{6,12}$/', $val)){
        $this->addError('name','username must be 6-12 chars & alphanumeric');
      }
    }

  }

  public function validatePassword() 
  {
    $val = trim($this->data['password']);

    if(empty($val)){
      $this->addError('password', 'You did not enter your password');
    } 
    else{
      if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $val)){
        $this->addError('password','password must be at least 8 any characters, and have at least 1 capital letter, at least one small letter, and at least 1 digit');
      }
    }
  
  }

  private function validateEmail(){

    $val = trim($this->data['email']);

    if(empty($val)){
      $this->addError('email', 'email cannot be empty');
    } else {
      if(!filter_var($val, FILTER_VALIDATE_EMAIL)){
        $this->addError('email', 'email must be a valid email address');
      }
    }

  }


  private function validateOccupation(){

    $val = trim($this->data['occupation']);

    if(empty($val)){
      $this->addError('occupation', 'occupation cannot be empty');
    } else {
      if(!preg_match('/^[a-zA-Z0-9]{3,36}$/', $val)){
        $this->addError('occupation','occupation must be 3-36 chars & alphanumeric');
      }
    }
  }

  private function validateLocation(){

    $val = trim($this->data['location']);

    if(empty($val)){
      $this->addError('location', 'location cannot be empty');
    } else {
      if(!preg_match('/^[a-zA-Z0-9]{3,36}$/', $val)){
        $this->addError('location','location must be 3-36 chars & alphanumeric');
      }
    }
  }

  private function validatePhone(){

    $val = trim($this->data['phone']);

    if(empty($val)){
      $this->addError('phone', 'phone cannot be empty');
    } else {
      if(!preg_match('/^[0-9]{6,12}$/', $val)){
        $this->addError('phone','phone must be 6-15 chars & alphanumeric');
      }
    }
  }

  private function validateVk(){

    $val = trim($this->data['vk']);

    if(empty($val)){
      $this->addError('vk', 'vk cannot be empty');
    } else {
      if(!preg_match('/^[a-zA-Z0-9]{3,12}$/', $val)){
        $this->addError('vk','vk must be 3-12 chars & alphanumeric');
      }
    }
  }

  private function validateTelegram(){

    $val = trim($this->data['telegram']);

    if(empty($val)){
      $this->addError('telegram', 'telegram cannot be empty');
    } else {
      if(!preg_match('/^[a-zA-Z0-9]{3,12}$/', $val)){
        $this->addError('telegram','telegram must be 3-12 chars & alphanumeric');
      }
    }
  }

  private function validateInstagram(){

    $val = trim($this->data['instagram']);

    if(empty($val)){
      $this->addError('instagram', 'instagram cannot be empty');
    } else {
      if(!preg_match('/^[a-zA-Z0-9]{3,12}$/', $val)){
        $this->addError('instagram','instagram must be 3-12 chars & alphanumeric');
      }
    }
  }

  private function validateImage(){

    //$val = trim($this->data['avatar']);
    $expensions= array("image/jpeg","image/jpg","image/png",);
    $file_type = $_FILES['avatar']['type'];

    //if(empty($val)){
      //$this->addError('avatar', 'avatar cannot be empty');
   // } else {
      if(in_array($file_type,$expensions)=== false){
        $this->addError('avatar','extension not allowed, please choose a JPEG or PNG file');
      }
    //}
    
        /*
        if($file_size > 2097152) {
          $errors[]='File size must be excately 2 MB';
        }  
        */
  }



  private function addError($key, $val){
    
    $this->errors[$key] = $val;
  }

}

?>