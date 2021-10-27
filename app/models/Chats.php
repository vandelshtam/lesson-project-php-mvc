<?php
namespace App\Models;

use App\Core\Model;
use App\Core\View;

class Chats extends Model{
    
    //метод получения данных всех чатов, из нескольких таблиц ===
    public function chatsAll($tables,$table_param,$table_param_2,$join, $where_param_3){
        return $this->db->getAllTableAll($tables,$table_param,$table_param_2,$join, $where_param_3);   
    }



    //получение одного чата  и связанной информации из нескольких связанных таблиц
    public function chatOne($tables,$id,$where_param,$where_param_2,$table_param,$table_param_2 ,$join,$where_param_3){
        return $this->db->getWhereTableAll($tables, $id,$where_param,$where_param_2,$table_param,$table_param_2,$join,$where_param_3 );
    }



    //получение всех чатов по двум параметрам из всех связанных таблиц
    public function chatsAllTwoParam($tables, $value, $where_param, $where_param_2, $table_param,$table_param_2,$where_param_3,$where_param_4){
        $this->db->getWhereTableAllTwoParam($tables, $value, $where_param, $where_param_2, $table_param,$table_param_2,$where_param_3,$where_param_4);
    }



    //получение всех чатов по двум параметрам из всех связанных таблиц
    public function chatsAllThreeParam($tables, $value){
        $this->db->getWhereTableAllThreeParam($tables, $value);
    }



    // метод получения  всех  сообщений из чата, из нескольких таблиц ===
    public function messagesChat($tables, $id,$where_param,$where_param_2,$table_param,$table_param_2,$join, $where_param_3){
        return $this->db->getWhereTableAll($tables, $id,$where_param,$where_param_2,$table_param,$table_param_2,$join, $where_param_3 );   
    }



    // метод получения  списка всех участников  чата, из нескольких таблиц ===
    public function userlistChat($tables, $id,$where_param,$where_param_2,$table_param,$table_param_2,$join, $where_param_3){
        //return $this->db->getAllTableAll($tables,$table_param,$table_param_2);
        return $this->db->getWhereTableAll($tables, $id,$where_param,$where_param_2,$table_param,$table_param_2,$join, $where_param_3);   
    }



    // метод получения  списка всех  ID чатов  по двум параметрам, из нескольких таблиц ===
    public function userlistChatTwoParam($table,$param,$param2,$value,$value2 ){
        //return $this->db->getAllTableAll($tables,$table_param,$table_param_2);
        return $this->db->getOneParamTwo($table,$param,$param2,$value,$value2);   
    }




    public function set_session_chat($chat){
        
            $_SESSION['chat_id']  = null;
            $_SESSION['banned'] = null;
            $_SESSION['name_chat'] = null;
            $_SESSION['chat_avatar'] = null;
            $_SESSION['openChat'] = null;
            $_SESSION['author_chat'] = null; 
        
            $_SESSION['chat_id']  = $chat['id'];
            $_SESSION['banned'] = $chat['banned'];
            $_SESSION['name_chat'] = $chat['name_chat'];
            $_SESSION['chat_avatar'] = $chat['chat_avatar'];
            $_SESSION['openChat'] = true; 
            $_SESSION['author_user_id'] = $chat['author_user_id'];  
    }




    //получение всех избранных чатов
    public function chatsAllFavorites($tables,$value,$where_param,$where_param_2,$table_param,$table_param_2,$join,$where_param_3){
        return $this->db->getWhereTableAll($tables, $value,$where_param,$where_param_2,$table_param,$table_param_2,$join,$where_param_3  );   
    }



    //получение всех "моих" чатов
    public function chatsAllMy($tables,$value,$where_param,$where_param_2,$table_param,$table_param_2,$join,$where_param_3){
        return $this->db->getWhereTableAll($tables, $value,$where_param,$where_param_2,$table_param,$table_param_2,$join,$where_param_3);   
    }



    //обновление в одной таблице чатов 'chats'
    public function updateChat($table,$data,$param,$param2){
        $this->db->updateAny($table, $data, $param,$param2);
    }



    //обновление в одной таблице чатов 'chats' по двум параметрам
    public function updateTableTwoParam($table,$data,$param,$param2,$param3,$param4){
        $this->db->updateAny($table, $data, $param,$param2,$param3,$param4);
    }




    //обновление в одной таблице чатов 'message'
    public function updateMessage($table,$data,$param,$param2){
        $this->db->updateAny($table, $data, $param,$param2);
    }




    //обновление в одной таблице чатов 'userlists'
    public function updateUserlist($table,$data,$param,$param2){
        $this->db->updateAny($table, $data, $param,$param2);
    }




    //метод получения данных всех пользователей, из нескольких таблиц ===
    public function usersAll($tables,$table_param,$table_param_2){
        return $this->db->getTableAll($tables,$table_param,$table_param_2);   
    }




    //получение одного user  и связанной информации из нескольких связанных таблиц
    public function userOne($tables,$id,$where_param,$where_param_2,$table_param,$table_param_2,$join,$where_param_3 ){
        return $this->db->getWhereTableAll($tables, $id,$where_param,$where_param_2,$table_param,$table_param_2,$join,$where_param_3 );
    }




    //метод получения массива пользователей для добавления в чат
    public function listsIdUserInChat($users){
        //получение id всех пользователей
        //dd($users);
        $arrey_users_id=[];
        foreach($users as $user){
             $arrey_users_id[]=$user['user_id'];
        }
        
        // создание массива id  выбранных пользователей для создания чата
        $arrey_user_new_chat=[];
            foreach($arrey_users_id as $user_id){
                 $rem = 'rememberme_'.$user_id;
            if(!empty($_POST[$rem])){
                if($_POST[$rem] == 'on'){
                    $arrey_user_new_chat[]=$user_id;
                }    
            }    
        }
        return $arrey_user_new_chat;
    }



    
    //метод проверка наличия  юзера  в чате
    public function isUserInChat($users,$id){
        //получение id всех пользователей
        $arrey_users_id=[];
        foreach($users as $user){
             $arrey_users_id[]=$user['user_id'];
        }
            foreach($arrey_users_id as $user_id){
                if($id == $user_id){
                    return true;
                }            
        }
    }




    //список массив id  переданного массива пользователей
    public function arrey_all_users_id($users){
        foreach($users as $user){
            $arrey_all_users_id[] = $user['user_id'];
        }
        return $arrey_all_users_id;
    }




    public function arrey_all_chats_id($userlists){
        foreach($userlists as $user){
            $arrey_all_chats_id[] = $user['chat_id'];
        }
        return $arrey_all_chats_id;
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



    //запись нового сообщения
    public function  createMessage($table,$data){       
        $this->db->create($table,$data);
    }



    //удалить сообщение
    public function  deleteMessage($table,$param,$value){       
        return $this->db->deleteParam($table,$param,$value);
    }



    //удалить запись из любой таблицы связанной с чатами
    public function  deleteChat($table,$param,$value){       
        return $this->db->deleteParam($table,$param,$value);
    }



    //удалить запись по  двум параметрам из таблицы 'userlists'
    public function  deleteUserInChat($table,$param,$param2,$value,$value2){       
        return $this->db->deleteTwoParam($table,$param,$param2,$value,$value2);
    }



    //удалить  аватар  чата из папки проекта
    public function deleteFileAvatar($table,$param,$value){
        $media = new MediaBuilder;
        return $media -> delete_image($table,$param,'chat_avatar',$value);
    }


    //получение данных из одной таблицы Users
    public function getUser($table,$param,$value){
        return $this->db->getOneParam($table,$param,$value);
    }



    //получение данных из одной таблицы Userlists по двум параметрам
    public function getUserInChat($table,$param,$param2,$value,$value2){
        return $this->db->getOneParamTwo($table,$param,$param2,$value,$value2);
    }



     //получение данных из одной таблицы messages по двум параметрам
     public function getMessageUserInChat($table,$param,$param2,$value,$value2){
        return $this->db->getOneParamTwo($table,$param,$param2,$value,$value2);
    }
   
}