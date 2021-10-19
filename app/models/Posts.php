<?php
namespace App\Models;

use App\Core\Model;

class Posts extends Model{

    //вызывается метод получения данных всех постов, из нескольких таблиц ===
    public function postsAll($tables,$table_param,$table_param_2){
        return $this->db->getAllTableAll($tables,$table_param,$table_param_2);   
    }

    //получение всех избранных постов
    public function postsAllFavorites($tables,$value,$where_param,$where_param_2,$table_param,$table_param_2 ){
        return $this->db->getWhereTableAll($tables, $value,$where_param,$where_param_2,$table_param,$table_param_2 );   
    }

    //получение всех "моих" постов
    public function postsAllMy($tables,$value,$where_param,$where_param_2,$table_param,$table_param_2 ){
        return $this->db->getWhereTableAll($tables, $value,$where_param,$where_param_2,$table_param,$table_param_2 );   
    }

    //получение одного поста  и информации из нескольких связанных таблиц
    public function postOne($tables,$id,$where_param,$where_param_2,$table_param,$table_param_2 ){
        return $this->db->getWhereTableAll($tables, $id,$where_param,$where_param_2,$table_param,$table_param_2 );
    }

    //все комментарии к посту
    public function  commentsAll($tables, $id,$where_param,$where_param_2,$table_param,$table_param_2 ){
        //dd($fetch);
        //return $this->db->comments($id);
        //return $this->db->getOneAllTable($tables, $id, $where_param);
        return $this->db->getWhereTableAll($tables, $id,$where_param,$where_param_2,$table_param,$table_param_2 );
    }

    //все картинки к посту
    public function  imagesPost($table,$value,$param_value,$param_where,$param_order,$param_sort){    
        return $this->db->getTableParams($table,$value,$param_value,$param_where,$param_order,$param_sort);
    }

    //создание нового файла аватвра поста
    public function makeNewAvatar($name_avatar){
        $media = new MediaBuilder;
        return $media -> makeNewImage($name_avatar);
    }

    //создание нового файла картинки галереи поста
    public function makeNewImage($name_image){
        $media = new MediaBuilder;
        return $media -> makeNewImage($name_image);
    }

    //загрузка имени файла аватара в папку проекта
    public function loadingFileAvatar($new_avatar){
        $media = new MediaBuilder;
        return $media -> loadingFileImage($new_avatar,'avatar_post');
    }

    //загрузка имени файла картинки в папку проекта
    public function loadingFileImage($new_image){
        $media = new MediaBuilder;
        return $media -> loadingFileImage($new_image,'image');
    }

    //удалить аватар из папки проекта 
    public function deleteFileAvatar($table,$param,$value){
        $media = new MediaBuilder;
        return $media -> delete_image($table,$param,'avatar_post',$value);
    }

    //получение поста из одной таблицы Posts
    public function getPost($table,$param,$value){
        return $this->db->getOneParam($table,$param,$value);
    }

    //обновление в одной таблице постов 'posts'
    public function updatePost($table,$data,$param,$param2){
        $this->db->updateAny($table, $data, $param,$param2);
    }

    //новый комментарий
    public function  createComment($table,$data){       
        return $this->db->create($table,$data);
    }

    //удалить комментарий
    public function  deleteComment($table,$param,$value){       
        return $this->db->deleteParam($table,$param,$value);
    }

    //удалить фотографию из папки проекта 
    public function deleteFileImage($table,$param,$value){
        $media = new MediaBuilder;
        return $media -> delete_image($table,$param,'image',$value);
    }

    // удалить запись из таблицы Удалить фотографию
    public function  deleteImage($table,$value){
        $media = new MediaBuilder;   
        $media->deleteImage($table,$value);
    } 

    //получение данных из одной таблицы Users
    public function getUser($table,$param,$value){
        return $this->db->getOneParam($table,$param,$value);
    }

    //запись нового поста
    public function  createPost($table,$data){       
        $this->db->create($table,$data);
    }
    
    //получение из таблицы id последней записанной записи
    public function newPostId(){
        return $this->db->lastId();    
    }

    public function deleteAllImagesInPost($table,$value,$param_value,$param_where,$param_order,$param_sort){
        $media = new MediaBuilder;
        $media->delete_all_images_file($table,$value,$param_value,$param_where,$param_order,$param_sort);
    }

    //удалить данные из любой таблицы 
    public function deleteTablePost($table,$param,$value){
        $this -> db -> deleteParam($table,$param,$value);
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