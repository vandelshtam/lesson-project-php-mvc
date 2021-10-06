<?php 
namespace App\Models;


class Validator {

  private $data;
  private $errors = [];
  private static $fields = ['name', 'email', 'password'];
  private static $fieldsEdit;

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
      $this->addError('occupation', 'name cannot be empty');
    } else {
      if(!preg_match('/^[a-zA-Z0-9]{3,36}$/', $val)){
        $this->addError('name','username must be 3-36 chars & alphanumeric');
      }
    }
  }

  private function validateLocation(){

    $val = trim($this->data['location']);

    if(empty($val)){
      $this->addError('location', 'name cannot be empty');
    } else {
      if(!preg_match('/^[a-zA-Z0-9]{3,36}$/', $val)){
        $this->addError('name','username must be 3-36 chars & alphanumeric');
      }
    }
  }

  private function validatePhone(){

    $val = trim($this->data['phone']);

    if(empty($val)){
      $this->addError('phone', 'name cannot be empty');
    } else {
      if(!preg_match('/^[0-9]{6,12}$/', $val)){
        $this->addError('name','username must be 3-36 chars & alphanumeric');
      }
    }
  }


  private function addError($key, $val){
    
    $this->errors[$key] = $val;
  }

}

?>