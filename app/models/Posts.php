<?php
namespace App\Models;

use App\Core\Model;

class Posts extends Model{

    //вызывается метод получения данных всех постов, из нескольких таблиц,  из любого количества таблиц
    public function postsAll($tables){
        //$tables = ['posts'];
        //return $this->db->getPostsAllTable();
        return $this->db->getUserAllTable($tables);
        
    }

    //получение всех избранных постов
    public function postsAllWhere($tables,$where, $value){
        return $this->db->getAllTableWhereParam($tables,$where, $value);    
    }

    //получение одного поста из нескольких связанных таблиц
    public function postOne($tables,$id,$where_param){
        //return $this->db->getPostAllTable($id);
        return $this->db->getOneAllTable($tables, $id,$where_param);
    }

    //получение поста из одной таблицы Posts
    public function getPost($table,$param,$value){
        return $this->db->getOneParam($table,$param,$value);
    }

    //все картинки к посту
    public function  imagesPost($table,$id,$param_where,$param_order,$param_sort){
        
        return $this->db->getTableParams($table,$id,$param_where,$param_order,$param_sort);
    }

    

    //все комментарии к посту
    public function  comments($tables, $id, $where_param){
        //dd($fetch);
        //return $this->db->comments($id);
        return $this->db->getOneAllTable($tables, $id, $where_param);
    }

    //новый комментарий
    public function  createComment($table,$data){
            
        return $this->db->create($table,$data);
    }

    //удалить комментарий
    public function  deleteComment($table,$id){
            
        return $this->db->delete($table,$id);
    }

    //обновление в таблице постов
    public function updatePost($table,$data,$param,$param2){
        $this->db->updateAny($table, $data, $param,$param2);
    }

     // удалить запись из таблицы Удалить фотографию
     public function  deleteImage($table,$id){
            
        return $this->db->delete($table,$id);
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