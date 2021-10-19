<?php
namespace App\Models;

use App\Core\Model;

class Users extends Model{

   
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
    
    //получение данных из одной таблицы по полю  id
    public function getUser($table,$param,$id){
        return $this->db->getOneParam($table,$param,$id);
    }
    
    //получение одного пользователя из нескольких связанных таблиц
    public function getUserAllTable($tables, $value, $where_param, $where_param_2, $table_param,$table_param_2){
        return $this->db->getWhereTableAll($tables, $value, $where_param, $where_param_2, $table_param,$table_param_2);
    }
    
    //получение из таблицы id последней записи данных 
    public function newUserId(){
        return $this->db->lastId();    
    }

    //вызывается метод получения данных всех пользователей, из нескольких таблиц,  из любого количества таблиц
    public function getUsersAll($tables,$table_param,$table_param_2){
        return $this->db->getAllTableAll($tables,$table_param,$table_param_2);
        //return $this->db->getUserAllTable($tables);
    }

    //обновление данных в  таблице (по полю id)
    public function updateUser($table,$data,$param,$param2){
        $this->db->updateAny($table, $data, $param, $param2);
    }
    //получение данных из таблицы по полю user_id
    public function getOneTable($table,$param,$user_id){
        return $this->db->getOneParam($table,$param,$user_id);
    }

    //создание нового файла аватвра поста
    public function makeNewAvatar($name_avatar){
        $media = new MediaBuilder;
        return $media -> makeNewImage($name_avatar);
    }

    //загрузка имени файла аватара в папку проекта
    public function loadingFileAvatar($new_avatar){
        $media = new MediaBuilder;
        return $media -> loadingFileImage($new_avatar,'avatar');
    }

    //удалить аватар из папки проекта 
    public function deleteFileAvatar($table,$param,$value){
        $media = new MediaBuilder;
        return $media -> delete_image($table,$param,'avatar_post',$value);
    }
    
    //добавление данных в таблцу
    public function createUser($table, $data){
        $this->db->create($table,$data);
    }
}