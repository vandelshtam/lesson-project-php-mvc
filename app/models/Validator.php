<?php 
namespace App\Models;


class Validator {

  private $data;
  private $errors = [];
  private static $fields = ['name', 'email', 'password'];
  private static $fieldsSecurity = ['new_password', 'confirm_password'];
  private static $fieldsEdit = ['name', 'occupation', 'location', 'phone'];
  private static $fieldsEditPost = ['name_post', 'title_post', 'text'];
  private static $fieldsChatForm = ['name_chat'];
  private static $fieldsInfo = [ 'occupation', 'location', 'phone'];
  private static $fieldsSocial = [ 'vk', 'telegram', 'instagram'];
  private static $fieldsAvatar = [ 'avatar'];
  private static $fieldsAvatarPost = [ 'avatar_post'];
  private static $fieldsAvatarChat = [ 'avatar_chat'];
  private static $fieldsEmail = [ 'new_email'];
  private static $fieldsCreate = ['name', 'email', 'password', 'occupation', 'location', 'phone','vk', 'telegram', 'instagram'];
  



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
    $this->validateEmail();
    $this->validatePassword();
    return $this->errors;
  }



  //форма смены пароля
  public function validateSecurityForm(){
    foreach(self::$fieldsSecurity as $field){
      if(!array_key_exists($field, $this->data)){
        trigger_error("'$field' is not present in the data");
        return;
      }
    }
    $this->validateNewPassword();
    $this->validateConfirmPassword();
    return $this->errors;
  }



  //валидация данных формы редактирования данных пользователя
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



  //валидация данных формы редактирования данных пользователя
  public function validateEditPost(){
    foreach(self::$fieldsEditPost as $field){
      if(!array_key_exists($field, $this->data)){
        trigger_error("'$field' is not present in the data");
        return;
      }
    }
      $this->validateNamePost();
      $this->validateTitlePost();
      $this->validateTextPost();

    return $this->errors;
  }

  //валидация данных формы редактирования данных пользователя
  public function validateChatForm(){
    foreach(self::$fieldsChatForm as $field){
      if(!array_key_exists($field, $this->data)){
        trigger_error("'$field' is not present in the data");
        return;
      }
    }
      $this->validateChat();
    return $this->errors;
  }



  //валидация данных для таблицы infos информации о пользователе
  public function validateInfoUserForm(){
    foreach(self::$fieldsInfo as $field){
      if(!array_key_exists($field, $this->data)){
        trigger_error("'$field' is not present in the data");
        return;
      }
    }
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



  //валидация данных из формы создания нового пользователя
  public function validateCreateUserForm(){
    foreach(self::$fieldsCreate as $field){
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



  //валидация аватара пользователя
  public function validateAvatarForm(){
    foreach(self::$fieldsAvatar as $field){
      if(!array_key_exists($field, $this->data)){
        trigger_error("'$field' is not present in the data");
        return;
      }
    }
      $this->validateImage();
      return $this->errors;
  }



  //валидация аватара поста
  public function validateAvatarPostForm(){
    foreach(self::$fieldsAvatarPost as $field){
      if(!array_key_exists($field, $this->data)){
        trigger_error("'$field' is not present in the data");
        return;
      }
    }
      $this->validateImage();
      return $this->errors;
  }

  //валидация аватара чата пока не нужен!!!!!======!!!!!!!
  public function validateAvatarChat(){
    foreach(self::$fieldsAvatarChat as $field){
      if(!array_key_exists($field, $this->data)){
        trigger_error("'$field' is not present in the data");
        return;
      }
    }
      $this->validateImage();
      return $this->errors;
  }


  //валидация из формы смены почты
  public function validateChangeEmailForm(){
    foreach(self::$fieldsEmail as $field){
      if(!array_key_exists($field, $this->data)){
        trigger_error("'$field' is not present in the data");
        return;
      }
    }
      $this->validateChangeEmail();
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

private function validateImage(){
    $expensions= array("image/jpeg","image/jpg","image/png", "image/webp");
    $file_type = $_FILES['image']['type'];
      if(in_array($file_type,$expensions)=== false){
        $this->addError('image','Image extension not allowed, please choose a JPEG or PNG or webp or jpg file');
      }
        /*
        if($file_size > 2097152) {
          $errors[]='File size must be excately 2 MB';
        }  
        */
  }


  //применяю пока этот метод валидации аватара юзера
  public function validateImageAvatar(){  
    $expensions= array("image/jpeg","image/jpg","image/png", "image/webp");  
    $file_type = $_FILES['avatar']['type'];
    if(empty($file_type)){
        $this->addError('avatar','image cannot be empty');
    }
    else{
      if(in_array($file_type,$expensions)=== false){
        $this->addError('avatar','extension not allowed, please choose a JPEG or PNG or webp or jpg file');
      }
    }
    return $this->errors;
  }


  //пока применяю этот метод валидации аватара поста
  public function validateImageAvatarPost(){  
    $expensions= array("image/jpeg","image/jpg","image/png", "image/webp");  
    $file_type = $_FILES['avatar_post']['type'];
    if(empty($file_type)){
        $this->addError('avatar_post','image cannot be empty');
    }
    else{
      if(in_array($file_type,$expensions)=== false){
        $this->addError('avatar_post','avatar extension not allowed, please choose a JPEG or PNG or webp or jpg file');
      }
    }
    return $this->errors;
  }


  //пока применяю этот метод валидации аватара чата
  public function validateImageAvatarChat(){  
    $expensions= array("image/jpeg","image/jpg","image/png", "image/webp");  
    $file_type = $_FILES['avatar_chat']['type'];
    if(empty($file_type)){
        $this->addError('avatar_chat','image cannot be empty');
    }
    else{
      if(in_array($file_type,$expensions)=== false){
        $this->addError('avatar_chat','avatar extension not allowed, please choose a JPEG or PNG or webp or jpg file');
      }
    }
    return $this->errors;
  }


  //применяю пока этот метод валидации картинки для  загрузки в пост
  public function validateImagePost(){  
    $expensions= array("image/jpeg","image/jpg","image/png", "image/webp");  
    $file_type = $_FILES['image']['type'];
    if(empty($file_type)){
        $this->addError('image','image cannot be empty');
    }
    else{
      if(in_array($file_type,$expensions)=== false){
        $this->addError('image','image extension not allowed, please choose a JPEG or PNG or webp or jpg file');
      }
    }
    return $this->errors;
  }




//===========методы валидации ==============


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

  private function validateNewPassword() 
  {
    $val = trim($this->data['new_password']);
    if(empty($val)){
      $this->addError('new_password', 'You did not enter your password');
    } 
    else{
      if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $val)){
        $this->addError('new_password','new_password must be at least 8 any characters, and have at least 1 capital letter, at least one small letter, and at least 1 digit');
      }
    }
  }

  private function validateConfirmPassword() 
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

  private function validateChangeEmail(){
    $val = trim($this->data['new_email']);
    if(empty($val)){
      $this->addError('new_email', 'email cannot be empty');
    } else {
      if(!filter_var($val, FILTER_VALIDATE_EMAIL)){
        $this->addError('new_email', 'new_email must be a valid email address');
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

  

  private function validateNamePost(){
    $val = trim($this->data['name_post']);
    if(empty($val)){
      $this->addError('name_post', 'name post cannot be empty');
    } else {
      if(!preg_match('/[a-zA-Z0-9]{3,36}/', $val)){
        $this->addError('name_post','name post must be 3-36 chars & alphanumeric');
      }
    }
  }


  private function validateChat(){
    $val = trim($this->data['name_chat']);
    if(empty($val)){
      $this->addError('name_chat', 'name chat cannot be empty');
    } else {
      if(!preg_match('/[a-zA-Z0-9]{3,36}/', $val)){
        $this->addError('name_chat','name chat must be 3-36 chars & alphanumeric');
      }
    }
  }

  private function validateTitlePost(){
    $val = trim($this->data['title_post']);
    if(empty($val)){
      $this->addError('title_post', 'title post cannot be empty');
    } else {
      if(!preg_match('/[a-zA-Z0-9]{3,36}/', $val)){
        $this->addError('title_post','title post must be 3-36 chars & alphanumeric');
      }
    }
  }

  private function validateTextPost(){
    $val = trim($this->data['text']);
    if(empty($val)){
      $this->addError('text', 'text post cannot be empty');
    } else {
      if(!preg_match('/[a-zA-Z0-9]{3,360}/', $val)){
        $this->addError('text','text post must be 3-360 chars & alphanumeric');
      }
    }
  }


  private function validateNameChat(){
    $val = trim($this->data['name_chat']);
    if(empty($val)){
      $this->addError('name_chat', 'name chat cannot be empty');
    } else {
      if(!preg_match('/[a-zA-Z0-9]{3,36}/', $val)){
        $this->addError('name_chat','name chat must be 3-36 chars & alphanumeric');
      }
    }
  }

  private function addError($key, $val){  
    $this->errors[$key] = $val;
  }
}