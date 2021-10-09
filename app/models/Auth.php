<?php
namespace App\Models;
//session_start();

use App\Core\Model;
use App\Models\flashMessage;

class Auth extends Model{
   
    public function loginUser($password,$value){

        $user = $this->db->getOneOnParam('users', 'email', $value);
        
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
    //получение данных из таблицы по  полю user_id
    public function getTableUser($table,$user_id){
        $user = $this->db->getOneUserId($table, $user_id);
        return $user;
    }

    public function createNewUser($table, $data){
        $this->db->create($table,$data);
    }

    public function updateUsersTable($table,$data,$id){
        
        $user = $this->db->update($table, $data, $id);
        return $user;
    }


    public function password_verification($id,$password){
        $user = $this->db->getOne('users', $id);
        $hash = $user['password'];
            if(password_verify($password, $hash))
            {        
                return true;
            }
            else
            {       
                return false;
            }
    } 

    public function setPassword($new_password,$id){
        
        $password = password_hash($new_password, PASSWORD_DEFAULT);
        $data = [
            'password' => $password   
        ];
        $this->db->update('users', $data, $id);
    }

    public function email_verification($email){
        $user = $this->db->getOneEmail('users', $email);
        $user_email = $user['email'];
            if($user_email == $email)
            {        
                return true;
            }
            else
            {       
                return false;
            }
    } 
    
    public function deleteTable($table,$id){
        $this->db->delete($table,$id);
    }

}