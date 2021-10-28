<?php 
namespace App\Models;


class Validator {

  private $data;
  private $errors = [];
  private static $fields = ['username', 'surname', 'phone', 'company_name', 'password', 'confirm_password'];
  

  public function __construct($post_data){
    $this->data = $post_data;
  }



  //валидация формы регистрации пользователя
  public function validateForm(){

    foreach(self::$fields as $field){
      if(!array_key_exists($field, $this->data)){
        trigger_error("'$field' is not present in the data");
        return;
      }
    }
    $this->validateUsername();
    $this->validateSurname();
    $this->validatePhone();
    $this->validatePassword();
    $this->validateCompany_name();
    $this->validateConfirm_password();
    return $this->errors;
  }
 

  
//===========методы валидации ==============
  private function validateUsername(){
    $val = trim($this->data['username']);
    if(empty($val)){
      $this->addError('username', 'username cannot be empty');
    } else {
      if(!preg_match('/^[a-zA-Z]{6,16}$/', $val)){
        $this->addError('username','username must be between 6-16 letters, no spaces, numbers and special characters');
      }
    }
  }



  private function validateSurname(){
    $val = trim($this->data['surname']);
    if(empty($val)){
      $this->addError('surname', 'surname cannot be empty');
    } else {
      if(!preg_match('/^[a-zA-Z]{6,16}$/', $val)){
        $this->addError('name','surname must be between 6-16 letters, no spaces, numbers and special characters');
      }
    }
  }

  private function validatePassword() 
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


  private function validateConfirm_password() 
  {
    $val = trim($this->data['confirm_password']);
    if(empty($val)){
      $this->addError('confirm_password', 'You did not enter your password');
    } 
    else{
      if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $val)){
        $this->addError('confirm_password','confirm_password must be at least 8 any characters, and have at least 1 capital letter, at least one small letter, and at least 1 digit');
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

  


  private function validateCompany_name(){
    $val = trim($this->data['company_name']);
    if(empty($val)){
      $this->addError('company_name', 'company_name cannot be empty');
    } else {
      if(!preg_match('/^[a-zA-Z0-9]{3,36}$/', $val)){
        $this->addError('company_name','company_name must be 3-36 chars & alphanumeric');
      }
    }
  }

  

  private function validatePhone(){
    $val = trim($this->data['phone']);
    if(empty($val)){
      $this->addError('phone', 'phone cannot be empty');
    } else {
      if(!preg_match('/^[0-9]{6,16}$/', $val)){
        $this->addError('phone','phone must be 6-16 chars & alphanumeric');
      }
    }
  }

  

  private function addError($key, $val){  
    $this->errors[$key] = $val;
  }
}