<?php
namespace App\Models;
//session_start();

use App\Core\Model;
use App\Models\flashMessage;

class Auth extends Model{
   
    //проверка наличия логина
    public function isLogin($table, $param, $value){
        if($this->db->getOneParam($table, $param, $value) == true){
            return true;
        }
        else{
            return false;
        }
    }

    //авторизация 
    public function loginUser($table,$param,$value,$password){
        $user = $this->db->getOneParam($table, $param, $value);
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
    
    //регистрация
    public function registerUser($table,$name,$email,$password_register){   
        $password = password_hash($password_register, PASSWORD_DEFAULT);
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'search' =>  strtolower($name)  
        ];
        $newUser = $this->db->create($table,$data);
            if($newUser == true){
                return true;
            }
            else{
                return false;
            }   
    }

    //запись в сессию данных авторизованного пользователя
    public function set_session_auth($user_id,$email,$name,$admin,$time)
    {
        ini_set('session.gc_maxlifetime', $time);
        ini_set('session.cookie_lifetime', $time);
        $_SESSION['user_id']=$user_id; 
        $_SESSION['login']=$email;
        $_SESSION['name']=$name;
        $_SESSION['admin']=$admin;
        $_SESSION['auth']=true;
    }

    //выход из сиситемы
    public function logoutUser()
    {    
        $this->set_session_auth('NULL','NULL','NULL','NULL',172800);    
    }

    //проверка наличия и получение пользователя
    public function getUser($table, $param, $value){
        return $this->db->getOneParam($table, $param, $value);
    }

    //ID последней записи в таблицу БД
    public function newLastUserId(){
        return $this->db->lastId();
    }
    
    //запись нового пользователя в таблицу
    public function createNewUser($table, $data){
        $this->db->create($table,$data);
    }

    //обновление данных пользователя
    public function updateUser($table,$data,$param,$param2){  
        return $this->db->updateAny($table, $data, $param,$param2);
    }

    //проверка пароля
    public function password_verification($table,$param,$value,$password){
        $user = $this->db->getOneParam($table,$param,$value);
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
 
    //запись пароля в таблицу
    public function setPassword($new_password,$id){
        
        $password = password_hash($new_password, PASSWORD_DEFAULT);
        $data = [
            'password' => $password   
        ];
        $this->db->updateAny('users', $data,'id', $id);
    }

    //проверка почты
    public function email_verification($table,$param,$value,$email){
        $user = $this->db->getOneParam($table,$param,$value);
            if($user['email'] == $email)
            {        
                return true;
            }
            else
            {       
                return false;
            }
    } 
    
    //удаление данных пользователя из таблицы
    public function deleteTable($table,$id){
        $this->db->delete($table,$id);
    }

}