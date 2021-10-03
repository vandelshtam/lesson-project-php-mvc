<?php
namespace App\Models;


use App\Core\Model;

class Auth extends Model{
    
    public function loginUser(){
        $table = 'users';
        $value = $_POST['email'];
        $param = 'email';
        $password = $_POST['password'];
        $user = $this->db->getOneOnParam($table, $param, $value);
        if(!empty($user))
        {
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
        else
        {   
            return false;
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
            return 'этот логин занят';
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
            //set_session_auth($user_id, $email);
            //set_flash_message('success','You have successfully registered!');
        }
    }

    public function LogoutUser(){
        
        echo 'Модель работает';
    }
}