<?php
namespace App\Models;

use App\Core\Model;

class Chats extends Model{

    //метод получения данных всех чатов, из нескольких таблиц ===
    public function chatsAll($tables,$table_param,$table_param_2){
        return $this->db->getAllTableAll($tables,$table_param,$table_param_2);   
    }

    //получение одного чата  и связанной информации из нескольких связанных таблиц
    public function chatOne($tables,$id,$where_param,$where_param_2,$table_param,$table_param_2 ){
        return $this->db->getWhereTableAll($tables, $id,$where_param,$where_param_2,$table_param,$table_param_2 );
    }


    // метод получения  всех  сообщений из чата, из нескольких таблиц ===
    public function messagesChat($tables, $id,$where_param,$where_param_2,$table_param,$table_param_2 ){
        //return $this->db->getAllTableAll($tables,$table_param,$table_param_2);
        return $this->db->getWhereTableAll($tables, $id,$where_param,$where_param_2,$table_param,$table_param_2 );   
    }

    // метод получения  списка всех участников  чата, из нескольких таблиц ===
    public function userlistChat($tables, $id,$where_param,$where_param_2,$table_param,$table_param_2 ){
        //return $this->db->getAllTableAll($tables,$table_param,$table_param_2);
        return $this->db->getWhereTableAll($tables, $id,$where_param,$where_param_2,$table_param,$table_param_2 );   
    }


    public function set_session_chat($chat){
        //if(null){
            //$_SESSION['chat_id']  = null;
            //$_SESSION['banned'] = null;
            //$_SESSION['name_chat'] = null;
            //$_SESSION['chat_avatar'] = null;
        //}
        //else{
            $_SESSION['chat_id']  = $chat[0]['id'];
            $_SESSION['banned'] = $chat[0]['banned'];
            $_SESSION['name_chat'] = $chat[0]['name_chat'];
            $_SESSION['chat_avatar'] = $chat[0]['chat_avatar'];
        //}
        
    }

    //получение всех избранных чатов
    public function chatsAllFavorites($tables,$value,$where_param,$where_param_2,$table_param,$table_param_2 ){
        return $this->db->getWhereTableAll($tables, $value,$where_param,$where_param_2,$table_param,$table_param_2 );   
    }

    //получение всех "моих" чатов
    public function chatsAllMy($tables,$value,$where_param,$where_param_2,$table_param,$table_param_2 ){
        return $this->db->getWhereTableAll($tables, $value,$where_param,$where_param_2,$table_param,$table_param_2 );   
    }

    //обновление в одной таблице чатов 'chats'
    public function updateChat($table,$data,$param,$param2){
        $this->db->updateAny($table, $data, $param,$param2);
    }

    //обновление в одной таблице чатов 'userlists'
    public function updateUserlist($table,$data,$param,$param2){
        $this->db->updateAny($table, $data, $param,$param2);
    }

    //метод получения данных всех пользователей, из нескольких таблиц ===
    public function usersAll($tables,$table_param,$table_param_2){
        return $this->db->getAllTableAll($tables,$table_param,$table_param_2);   
    }

    //получение одного user  и связанной информации из нескольких связанных таблиц
    public function userOne($tables,$id,$where_param,$where_param_2,$table_param,$table_param_2 ){
        return $this->db->getWhereTableAll($tables, $id,$where_param,$where_param_2,$table_param,$table_param_2 );
    }

    //метод получения массива пользователей для добавления в чат
    public function listsIdUserInChat($users){
        //получение id всех пользователей
        $arrey_users_id=[];
        //$users = $this -> usersAll; 
        foreach($users as $user){
             $arrey_users_id[]=$user['user_id'];
        }

        // создание массива id  выбранных пользователей для создания чата
        $arrey_user_new_chat=[];
            foreach($arrey_users_id as $user_id){
                 $rem = 'rememberme_'.$user_id;
                // $user = 'user_'.$user_id;
                 $user = $user_id;
            if(!empty($_POST[$rem])){
                if($_POST[$rem] == 'on'){
                    $arrey_user_new_chat[]=$user_id;
                }
            }
            
        }
        return $arrey_user_new_chat;
    }

 //список массив id  переданного массива пользователей
    public function arrey_all_users_id($users){
        foreach($users as $user){
            $arrey_all_users_id[] = $user['user_id'];
        }
        return $arrey_all_users_id;
    }

    //получение массива id  которых нет в чате
    public function list_add_user($arrey_all_users_id, $list_userlist){
        $result = array_diff ($arrey_all_users_id, $list_userlist);
        return $result;
    }


    //получение чата из одной таблицы Chats
        public function getChat($table,$param,$value){
            return $this->db->getOneParam($table,$param,$value);
        }

    //создание нового файла аватвра чата
        public function makeNewAvatar($name_avatar){
            $media = new MediaBuilder;
            return $media -> makeNewImage($name_avatar);
        }

    //загрузка имени файла аватара чата в папку проекта
        public function loadingFileAvatar($new_avatar){
            $media = new MediaBuilder;
            return $media -> loadingFileImage($new_avatar,'avatar_chat');
        }

    //запись нового чата
        public function  createChat($table,$data){       
            $this->db->create($table,$data);
        }
        
        //получение из таблицы id последней записанной записи чата
        public function newChatId(){
            return $this->db->lastId();    
        }

    //запись нового чата
    public function  createUserlist($table,$data){       
        $this->db->create($table,$data);
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

    

    //создание нового файла картинки галереи поста
    public function makeNewImage($name_image){
        $media = new MediaBuilder;
        return $media -> makeNewImage($name_image);
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

   
    //получение  одного комментария  из одной таблицы 'comments'
    public function getComment($table,$param,$value){
        return $this->db->getOneParam($table,$param,$value);
    }

    

    //обновление в одной таблице постов 'comments'
    public function updateComment($table,$data,$param,$param2){
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

    

    public function deleteAllImagesInPost($table,$value,$param_value,$param_where,$param_order,$param_sort){
        $media = new MediaBuilder;
        $media->delete_all_images_file($table,$value,$param_value,$param_where,$param_order,$param_sort);
    }

    //удалить данные из любой таблицы 
    public function deleteTablePost($table,$param,$value){
        $this -> db -> deleteParam($table,$param,$value);
    }


    //получение количества постов
    public function postsCount($table) {
		return $this->db->countColumn($table);   
	}

    //получение постов из нескольких таблиц по условиям выборки пагинации ДОДЕЛАТЬ!!!!!
    public function postsListAll($route) {
        $tables = ['users', 'infos', 'posts'];
		$max = 4;
		$params = [
			'max' => $max,
			'start' => ((($route ?? 1) - 1) * $max),
		];
		return $this->db->getUsersListPaginate( $tables, $params);
	}
}