<?php
namespace App\Models;
//session_start();

use App\Core\Model;
use App\Models\flashMessage;

class Auth extends Model{
   
    public function loginUser(){
        $table = 'users';
        $value = $_POST['email'];
        $param = 'email';
        $password = $_POST['password'];
        $user = $this->db->getOneOnParam($table, $param, $value);
        
        if(empty($user))
        {   
            $key = 'info';
            $value = 'Логин указан не верно!';
            flashMessage::addFlash($key, $value);
        }
        else
        {
        $hash = $user['password'];
            if(password_verify($password, $hash))
            {        
                return $user;
            }
            else
            {       
                return false;
            }
        }    
    }


    public function registerUser(){
        $email=$_POST['email'];
        $password = $_POST['password'];
        $table = 'users';
        $value = $_POST['email'];
        $param = 'email';
        $name = $_POST['name'];
        $user = $this->db->getOneOnParam($table, $param, $value);
        $password = $_POST['password'];
        if(!empty($user))
        {
            $key = 'info';
            $value = 'Не удалось зарегистрироваться, этот логин занят';
            $flashMessage = flashMessage::addFlash($key, $value);
            return $flashMessage;
        }
        else
        {   
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $data = [
                'name' => $name,
                'email' => $email,
                'password' => $password   
            ];
            $newUser = $this->db->create($table,$data);
            if($newUser == true){
                return true;
            }
            else{
                return false;
            }
        }
    }

    public function set_session_auth($user_id,$email,$name,$admin)
    {    
        $_SESSION['user_id']=$user_id; 
        $_SESSION['login']=$email;
        $_SESSION['name']=$name;
        $_SESSION['admin']=$admin;
        $_SESSION['auth']=true;
    }

    public function logoutUser()
    {    
        $this->set_session_auth('NULL','NULL','NULL','NULL');    
    }
}