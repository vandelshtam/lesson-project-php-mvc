<?php
namespace App\Controllers;
session_start();

use App\Models\Posts;
use App\lib\Pagination;
use App\Core\Controller;
use App\Models\Validator;
use App\Models\flashMessage;
use App\Models\MediaBuilder;

class ChatsController extends Controller{


    public function __construct($route) {
		parent::__construct($route);
		$this->view->layout = 'custom_chats';
	}

    public function chatsAction(){
        
        
        $navigate = [
            'myChats' => 0,
            'favorites' => 0,
            'chatsAll' => 1
            ];
            $data = ['users', 'infos', 'chats'];
            $vars = [
                'chats' => $this->model->chatsAll($data,'user_id', 'users.id'),
                'navigate'  => $navigate
                ];
                //dd($vars);  
            $this->view->render('Chats list page', $vars);
    }


    public function favoritesChatsAction(){
        $navigate = [
            'myChats' => 0,
            'favorites' => 1,
            'chatsAll' => 0,];
            $data = ['users', 'infos', 'chats'];
            $vars = [
                'chats' => $this->model->chatsAllFavorites($data, 1, 'favorites', 'value', 'user_id', 'users.id'),
                'navigate'  => $navigate
                ]; 
                //dd($vars); 
            $this->view->render('Chats favorites page', $vars);
    }


    public function myChatsAction(){
        $navigate = [
            'myChats' => 1,
            'favorites' => 0,
            'chatsAll' => 0,];
            $data = ['users', 'infos', 'chats'];
            $vars = [
                'chats' => $this->model->chatsAllMy($data, $_SESSION['user_id'], 'user_id', 'value', 'user_id', 'users.id'),
                'navigate'  => $navigate
                ]; 
                //dd($vars);   
            $this->view->render('My Chats list', $vars);
    }


    public function openChatAction(){
        //$this -> model -> set_session_chat('null');
        $this->view->layout = 'custom_openChat';

            $data_messages = ['users', 'infos', 'messages']; 
            $tables = ['users', 'infos', 'chats']; 
            $chat = $this->model->chatOne($tables,$this->route['id'], 'chat_id','chat_id', 'user_id', 'users.id');
            //dd($chat);
            //echo $_SESSION['banned'];
            $this -> model -> set_session_chat($chat);
            $vars = [
                //$tables, $this->route['id'], 'post_id', 'post_id', 'user_id', 'users.id'
                'chat' => $chat,
                //'navigate'  => $navigate,
                'messages' => $this->model->messagesChat($data_messages, $this->route['id'], 'chat_id','chat_id', 'user_id', 'users.id'),
                //'messages' => $this->model->messagesChat('images',$this->route['id'], ':id','post_id','created_at',''),
                ]; 
                //dd($vars);
            $this->view->render('Chat  page', $vars);
    }


    public function unBannedChatAction(){
        $data = ['banned' => 0];
        $this -> model -> updateChat('chats',$data,'id',$this->route['id']); 
        flashMessage::addFlash('success', 'Вы успешно раззаблокировали чат');
        $this->view->redirect('/openChat/'.$this->route['id']);
    }

    public function bannedChatAction(){
        $data = ['banned' => 1];
        $this -> model -> updateChat('chats',$data,'id',$this->route['id']); 
        flashMessage::addFlash('success', 'Вы успешно заблокировали чат');
        $this->view->redirect('/openChat/'.$this->route['id']);
    }

//===========новый чат ====================
    public function addChatShowAction(){
        $errors = [];
        $navigate = [
            'myChats' => 0,
            'favorites' => 0,
            'chatsAll' => 0]; 
        $tables = ['users', 'infos']; 
        $users =   $this -> model -> usersAll($tables,'user_id', 'users.id');
        $vars = [
            'navigate'  => $navigate,
            'users' => $users
            ]; 
            
        $validation = new Validator($_POST);

        if($_SESSION['admin'] != 1 && $_SESSION['auth'] != true){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/posts');
        } 

        
        if(empty($_POST['name_chat'])){
            flashMessage::addFlash('info', 'Нужно обязательно заполнить пол: "name chat"');    
        }
        else{
            
            if($validation->validateChatForm() != null){
                $errors = $validation->validateChatForm();
            }
            else{
                
                $chat = $this->model->getChat('chats','name_chat',$_POST['name_chat']);

                if(!empty($chat))
                {
                    flashMessage::addFlash('info', 'Не возможно добавить чат с таким названием, это название уже занято');    
                }
                else{
                    //получение массива id всех выбранных пользователей
                    $arrey_user_new_chat = $this->model->listsIdUserInChat($users);

                    //проверка добавления в чат пользователей, если никто не добвален вернуть пользователя назад и вывести сообщение
                    if(count($arrey_user_new_chat)==0){
                        flashMessage::addFlash('danger','Вы  не выбрали ни одного участника нового чата!');
                        //$this->view->redirect('/addChatShow/'.$this->route['id']);
                        $this->view->render('Add new chat', $vars, $errors); die;
                    }
                    $dataChat = [ 
                            'name_chat' => $_POST['name_chat'],
                            'names' => $_POST['name_chat'],
                            'user_id' => $_SESSION['user_id'],
                            'banned' => 0, 
                            'author_user_id' => $_SESSION['user_id'],
                            'c' => 0,
                            'search' => strtolower($_POST['name_chat']),   
                        ];

                        if(!empty($_FILES['avatar_chat']['name'])){
                            $validate = new Validator($_POST);
                            if($validate->validateImageAvatarChat() != null){
                                $errors = $validate->validateImageAvatarChat();
                                $this->view->render('Add new chat', $vars, $errors); die;  
                            }
                            else{
                                $new_avatar=$this->model->makeNewAvatar('avatar_chat');
                                if($this->model->loadingFileAvatar($new_avatar) == false){
                                    flashMessage::addFlash('danger', 'Не удалось загрузить файл'); 
                                    $this->view->render('Add new chat', $vars, $errors); die;     
                                }
                            }
                        }
                        
                    $this->model->createChat('chats', $dataChat);
                    $newChatId =  $this->model->newChatId();
                    $c = 'c_'.$newChatId;
                    $data = [ 
                        'chat_id' => $newChatId,
                        'c' => $c,   
                    ];
                    $this->model->updateChat('chats',$data,'id',$newChatId);

                    //формирование массива данных о пользователях и чате в котором они участвуют, для групповой записи в таблицу ''userlists'
                    $arrey_db = [];
                    foreach($arrey_user_new_chat as $user_id)
                    {
                        $arrey_db[] = ['user_id' => $user_id,  'chat_id' => $newChatId, 'userlistable_id' => $newChatId, 'userlistable_type' => 'App\Models\Chat','name_list' => $_POST['name_chat'], 'role' => 'participant'];    
                    
                    }
                   
                    foreach($arrey_db as $data){
                       
                        $this->model->createUserlist('userlists',$data);
                    }

                    if(!empty($_FILES['avatar_chat']['name'])){
                                            
                        $media = new MediaBuilder;
                        $dataAvatar = ['chat_avatar' => $new_avatar];
                        $media->updateAvatar('chats',$dataAvatar,'id',$newChatId);                            
                    } 

                    flashMessage::addFlash('success', 'Вы успешно добавили новый чат'); 
                    $this->view->redirect('/openChat/'.$newChatId);   

                }   
            }       
        }
        $this->view->render('Add new chat', $vars, $errors);   
    }

    //=================== конец экшена нового чата =============













    public function editChatShowAction(){
        if($_SESSION['admin'] != 1 && $_SESSION['user_id'] != $this->route['id']){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/post/'.$this->route['id']);
        }
        $errors =[];
        $navigate = [
            'myChats' => 0,
            'favorites' => 0,
            'chatsAll' => 0];
            $data_userlist = ['users', 'infos', 'userlists']; 
            $tables = ['users', 'infos']; 
            $users =   $this -> model -> usersAll($tables,'user_id', 'users.id'); 
            $userlists = $this->model->userlistChat($data_userlist, $this->route['id'], 'chat_id','chat_id', 'user_id', 'users.id');
            $users_all_id = $this -> model -> arrey_all_users_id($users);
            $usersists_id = $this -> model -> arrey_all_users_id($userlists); 
            $user_id_not_chat = $this -> model -> list_add_user($users_all_id, $usersists_id); 
            
            $tables_users = ['users', 'infos']; 
            $users_add = [];
            foreach($user_id_not_chat as $id){
            $users_add[] =  $this->model->userOne($tables_users,$id, 'user_id','user_id', 'user_id', 'users.id');
            }
           //dd($users_add);
        $vars = [
            'chat' => $this->model->getChat('chats','id',$this->route['id']),
            'navigate'  => $navigate,
            'users' => $users_add,
            'userlists' => $userlists,
            //'userlists' => $this->model->imagesPost('usrlists',$this->route['id'], ':id','post_id','created_at',''),
             ]; 
            //dd($vars);       
        if(!empty($_FILES['avatar_chat']['name'])){
            $validate = new Validator($_POST);
            if($validate->validateImageAvatarChat() != null){
                $errors = $validate->validateImageAvatarChat();
                $this->view->render('Add new chat', $vars, $errors); die;  
            }
            else{
                $new_avatar=$this->model->makeNewAvatar('avatar_chat');
                if($this->model->loadingFileAvatar($new_avatar) == false){
                    flashMessage::addFlash('danger', 'Не удалось загрузить файл'); 
                    $this->view->render('Add new chat', $vars, $errors); die;     
                }
                else{
                    $media = new MediaBuilder;
                    $dataAvatar = ['chat_avatar' => $new_avatar];
                    $media->updateAvatar('chats',$dataAvatar,'id',$this->route['id']); 
                    flashMessage::addFlash('success', 'Вы успешно  изменили аватар чата'); 
                    $this->view->redirect('/editChatShow/'.$this->route['id']);  
                }
            }
        }
        
        if(!empty($_POST['add_user'])){
            //получение массива id всех выбранных пользователей
            $arrey_user_new_chat = $this->model->listsIdUserInChat($users);
            //формирование массива данных о пользователях и чате в котором они участвуют, для групповой записи в таблицу ''userlists'
            $arrey_db = [];
            foreach($arrey_user_new_chat as $user_id)
            {
                $arrey_db[] = ['user_id' => $user_id,  'chat_id' => $this->route['id'], 'userlistable_id' => $this->route['id'], 'userlistable_type' => 'App\Models\Chat','name_list' => $_POST['name_chat'], 'role' => 'participant'];    
            
            }
            foreach($arrey_db as $data){
                        
                $this->model->createUserlist('userlists',$data);
            }
            $this->view->redirect('/editChatShow/'.$this->route['id']);  
        }

        if(!empty($_POST['name_post']) || !empty($_POST['title_post']) || !empty($_POST['text'])){
            $validate = new Validator($_POST);
            if($validate->validateEditPost() != null){
                $errors = $validate->validateEditPost();
            }
            else{   
                $post = $this->model->getPost('posts','id',$this->route['id']);
                $dataPost = ['name_post' => $_POST['name_post'], 'title_post' => $_POST['title_post'], 'text' => $_POST['text']];
                $this -> model -> updatePost('posts',$dataPost,'id',$this->route['id']); 
                flashMessage::addFlash('success', 'Вы успешно  обновили информацию поста');
                $this->view->redirect('/post/'.$this->route['id']);       
            }
        }
      
        $this->view->render('Edit chat', $vars,$errors);
    }


    public function addNewCommentAction(){
        $this->route['id'];
        $data = [ 
            'user_id' => $_SESSION['user_id'],
            'comment' => $_POST['comment'],
            'post_id' => $this->route['id']      
        ];
        $this->model->createComment('comments',$data);    
        $this->view->redirect('/post/'.$this->route['id']);  
    }


    public function deleteCommentAction(){
        $this->model->deleteComment('comments','id',$this->route['id']);    
        $this->view->redirect('/post/'.$_POST['post_id']);  
    }

    public function bannedPostAction(){
        $data = ['banned' => 1];
        $this -> model -> updatePost('posts',$data,'id',$this->route['id']); 
        flashMessage::addFlash('success', 'Вы успешно заблокировали пост');
        $this->view->redirect('/post/'.$this->route['id']);
    }

    

    public function unBannedCommentAction(){
        $data = ['banned' => 0];
        $comment = $this -> model -> getComment('comments','id',$this->route['id']);
        $post = $comment['post_id'];
        $this -> model -> updateComment('comments',$data,'id',$this->route['id']); 
        flashMessage::addFlash('success', 'Вы успешно раззаблокировали комментарий');
        $this->view->redirect('/post/'.$post);
    }

    public function addFavoritesAction(){
        $data = ['favorites' => 1];
        $this -> model -> updatePost('posts',$data,'id',$this->route['id']); 
        flashMessage::addFlash('success', 'Вы успешно добавили пост в избранное');
        $this->view->redirect('/post/'.$this->route['id']);
    }

    public function deleteFavoritesAction(){
        $data = ['favorites' => 0];
        $this -> model -> updatePost('posts',$data,'id',$this->route['id']); 
        flashMessage::addFlash('success', 'Вы успешно удалили пост из избранного');
        $this->view->redirect('/post/'.$this->route['id']);
    }


    public function imagePostShowAction(){
        $errors = [];
        $navigate = [
            'myPosts' => 0,
            'favorites' => 0,
            'postsAll' => 0,
            'searchPosts' => 0];
            $image = $this->model->imagesPost('images',$this->route['id'],':id','id','created_at','');   
        $vars = [   
            'navigate'  => $navigate,
            'image' => $image,
            'post' => $this->model->getPost('posts','id',$image[0]['post_id'])
            ];   
        $this->view->render('Image post show', $vars,$errors);
    }

    public function delete_imageAction(){  
        $image = $this->model->imagesPost('images',$this->route['id'],':id','id','created_at','');
        $this-> model -> deleteFileImage('images','id',$this->route['id']);
        $this -> model -> deleteImage('images',$this->route['id']); 
        flashMessage::addFlash('success', 'Вы успешно удалили фотографию');
        $this->view->redirect('/post/'.$image[0]['post_id']);
    }



    
    public function deletePostAction(){
        $post = $this->model->getPost('posts','id',$this->route['id']);
        if($post == false){
            flashMessage::addFlash('info', 'Такого поста нет!');
            $this->view->redirect('/post/'.$this->route['id']);
        }

        if($_SESSION['admin'] != 1 && $_SESSION['user_id'] != $post['user_id']){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/post/'.$this->route['id']);
        }                                   
        $this -> model -> deleteAllImagesInPost('images',$this->route['id'], ':id','post_id','created_at','');
        $this -> model -> deleteFileAvatar('posts','id',$this->route['id']); 
        

        $this->model->deleteTablePost('posts','id', $this->route['id']);
        $this->model->deleteTablePost('images','post_id',$this->route['id']);
        $this->model->deleteTablePost('comments','post_id',$this->route['id']);
        flashMessage::addFlash('success', 'Вы успешно удалили пост!');
        $this->view->redirect('/posts');
    }

    
}
