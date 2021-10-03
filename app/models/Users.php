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

    public function getUsersOne(){
        $tables = ['users', 'infos', 'socials'];
        $id = 1;
        $user = $this->db->getOneAllTable($tables, $id);
        return $user;
        //dd($user);
        echo 'Модель работает';
    }
}