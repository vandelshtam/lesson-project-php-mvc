<?php 
namespace App\Models;

class flashMessage {

  public $message = [];
  
  public static function addFlash($key, $val){  
    $_SESSION[$key] = $val;
  }

  public static function display_flash($name){    
    echo $_SESSION[$name];
    unset($_SESSION[$name]);    
}  
}
?>