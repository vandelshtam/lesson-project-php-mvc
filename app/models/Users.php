<?php
namespace App\Models;

use App\Core\Model;

class Users extends Model{

    //вызывается метод получения данных всех пользователей, из нескольких таблиц,  из любого количества таблиц
    public function getUsersAll(){
        //для получения юзеров заполняем массив с названиями теблиц, первой в массив записываем основную таблицу
        //к которой будут джойнится другие
        $tables = ['users', 'infos', 'socials'];
        return $this->db->getUserAllTable($tables);
    }
    //получение одного пользователя из нескольких связанных таблиц
    public function getUsersOne($tables,$user_id){
        $tables = ['users', 'infos', 'socials'];
        return $this->db->getOneAllTable($tables, $user_id);
    }

    //получение одного пользователя из одной таблицы по email
    public function getUserOnTableEmail($table,$param, $email){
        return $this->db->getOneParam($table, $param, $email);
    }

    //обновление данных в  таблице (по полю id)
    public function updateUser($table,$data,$id){
        $this->db->update($table, $data, $id);
    }

    //обновление данных в таблице по полю user_id
    public function updateTableUserId($table,$data,$user_id){
        $this->db->updateTableUserId($table, $data, $user_id);
    }

    //получение данных из одной таблицы по полю  id
    public function getOneUser_oneTable($table,$param,$id){
        return $this->db->getOneParam($table,$param,$id);
    }

    //добавление данных в таблцу
    public function createUser($table, $data){
        $this->db->create($table,$data);
    }

    //получение из таблицы id последней записанных данных 
    public function newUserId(){
        return $this->db->userId();
        
    }

    public function loadingFileAvatar($image_name_tmp,$direct,$image_name){
        is_uploaded_file($image_name_tmp);
        move_uploaded_file($image_name_tmp, $direct.$image_name );
    }


    //получение данных из таблицы по полю user_id
    public function getOneTableWhereUser_id($table,$param,$user_id){
        return $this->db->getOneParam($table,$param,$user_id);
    }

    //получение количества строк в таблице
    public function usersCount($table) {
		return $this->db->countColumn($table);   
	}

    //получение пользователей из нескольких таблиц по условиям выборки пагинации
    public function usersListAll($route) {
        $tables = ['users', 'infos', 'socials'];
		$max = 4;
		$params = [
			'max' => $max,
			'start' => ((($route ?? 1) - 1) * $max),
		];
		return $this->db->getUsersListPaginate( $tables, $params);
	}
}