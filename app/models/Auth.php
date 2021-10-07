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


    public function registerUser($table,$name,$email){
        
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

    public function isUser($table, $param, $value){
        $user = $this->db->getOneOnParam($table, $param, $value);
        return $user;
    }

    public function newLastUserId(){
        $newUserId = $this->db->userId();
        return $newUserId;
    }

    public function getTableUser($table,$user_id){
        $user = $this->db->getOneUserId($table, $user_id);
        return $user;
    }

    public function createNewUser($table, $data){
        $this->db->create($table,$data);
    }

    public function updateUsersTable($table,$data,$user_id){
        $id = $user_id;
        $user = $this->db->update($table, $data, $id);
        return $user;
    }
}