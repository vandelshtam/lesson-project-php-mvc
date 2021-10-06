<?php
namespace App\Models;

use App\Core\Model;

class Users extends Model{
    //вызывается метод получения данных из любых таблиц и любого количества таблиц
    //получаем юзеров
    public function getUsersAll(){
        //для получения юзеров заполняем массив с названиями теблиц, первой в массив записываем основную таблицу
        //к которой будут джойнится другие
        $tables = ['users', 'infos', 'socials'];
        $users = $this->db->getUserAllTable($tables);
        return $users;
    }

    public function getUsersOne($user_id){
        $tables = ['users', 'infos', 'socials'];
        $id = $user_id;
        $user = $this->db->getOneAllTable($tables, $id);
        return $user;
    }

    public function getUserOnTable($table, $email){
        $user = $this->db->getOneEmail($table, $email);
        return $user;
    }

    public function updateUser($table,$data,$user_id){
        $id = $user_id;
        $user = $this->db->update($table, $data, $id);
        return $user;
    }

    public function getOneData($table,$user_id){
        $id = $user_id;
        $user = $this->db->getOne($table, $id);
        return $user;
    }

    public function createUser($table, $data){
        $this->db->create($table,$data);
    }

    public function newUserId(){
        $newUserId = $this->db->userId();
        return $newUserId;
    }

    public function loadingFileAvatar($image_name_tmp,$direct,$image_name){
        is_uploaded_file($image_name_tmp);
        move_uploaded_file($image_name_tmp, $direct.$image_name );
    }

    public function updateAvatar($data, $id, $table){
        $this->db->update($data,$id,$table);   
    }

    public function getOneOnUserId($table,$user_id){
        $user = $this->db->getOneUserId($table, $user_id);
        return $user;
    }
}