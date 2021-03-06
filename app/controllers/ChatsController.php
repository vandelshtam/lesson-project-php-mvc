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
        if($_SESSION['admin'] != 1 && $_SESSION['auth'] != true){
            flashMessage::addFlash('danger', 'У вас нет прав доступа!');
            $this->view->redirect('/chats');
        } 
        $navigate = [
            'myChats' => 0,
            'favorites' => 0,
            'chatsAll' => 1,
            'openChat' => 0,
            'redirect' => 1
            ];
        $_SESSION['navigate'] = $navigate;    
        $data = ['users', 'infos', 'chats'];
        $data_userlist = ['users', 'infos', 'userlists']; 
        if($_SESSION['admin'] == 1){
            $vars = [
                'chats' => $this->model->chatsAll($data,'user_id', 'users.id','', ''),
                'navigate'  => $navigate
                ];
        }
        else{
            $chats = $this->model->userlistChat($data_userlist, $_SESSION['user_id'],'user_id','user_id', 'user_id', 'users.id',' INNER JOIN chats ON chats.id = userlists.chat_id ', '');
            $vars = [
                'chats' => $chats,
                'navigate'  => $navigate
                ];
        }
        $this->view->render('Chats list page', $vars);
    }






    public function favoritesChatsAction(){
        if($_SESSION['admin'] != 1 && $_SESSION['auth'] != true){
            flashMessage::addFlash('danger', 'У вас нет прав доступа!');
            $this->view->redirect('/chats');
        } 
        $navigate = [
            'myChats' => 0,
            'favorites' => 1,
            'chatsAll' => 0,
            'openChat' => 0,
            'redirect' => 2
        ];
        $_SESSION['navigate'] = $navigate;
        $data = ['users', 'infos','chats'];
        
        if($_SESSION['admin'] == 1){
            $chats = $this->model->chatsAllFavorites($data, 1, 'favorites', 'value', 'user_id', 'users.id','','');
            if(count($chats) == false){flashMessage::addFlash('danger', 'У вас нет избранных чатов');}
            $vars = [
                'chats' => $chats,
                'navigate'  => $navigate
                ];
        }
        else{
            $data_userlist = ['users', 'infos','userlists']; 
            $chats = $this->model->userlistChat($data_userlist, $_SESSION['user_id'],'user_id','user_id', 'user_id', 'users.id',' INNER JOIN chats ON chats.id = userlists.chat_id ', ' AND userlists.favorites_chat LIKE 1');
            if(count($chats) == false){flashMessage::addFlash('danger', 'У вас нет избранных чатов');}
                $vars = [
                    'chats' => $chats,
                    'navigate'  => $navigate
                    ];
        }
            
           
        $this->view->render('Chats favorites page', $vars);
    }







    public function myChatsAction(){
        if($_SESSION['admin'] != 1 && $_SESSION['auth'] != true){
            flashMessage::addFlash('danger', 'У вас нет прав доступа!');
            $this->view->redirect('/chats');
        } 
        $navigate = [
            'myChats' => 1,
            'favorites' => 0,
            'chatsAll' => 0,
            'openChat' => 0,
            'redirect' => 2
        ];
        $_SESSION['navigate'] = $navigate;    
        $data = ['users', 'infos', 'chats'];
        if($_SESSION['admin'] == 1){
            $chats = $this->model->chatsAllMy($data, $_SESSION['user_id'], 'author_user_id', 'value', 'user_id', 'users.id','','');
            if(count($chats) == false){flashMessage::addFlash('danger', ' Вы пока не создали ни одного чата');}
        $vars = [
            'chats' => $chats,
            'navigate'  => $navigate
            ];
        }
        else{
            $data_userlist = ['users', 'infos','userlists']; 
            $chats = $this->model->userlistChat($data_userlist, $_SESSION['user_id'],'user_id','user_id', 'user_id', 'users.id',' INNER JOIN chats ON chats.id = userlists.chat_id ', ' AND chats.author_user_id LIKE '.$_SESSION['user_id'].'');
            if(count($chats) == false){flashMessage::addFlash('danger', ' Вы пока не создали ни одного чата');}
                $vars = [
                    'chats' => $chats,
                    'navigate'  => $navigate
                    ];    
        }
        $this->view->render('My Chats list', $vars);
    }






    public function openChatAction(){
        $get_chat = $this->model->getChat('chats','id',$this->route['id']);
        if(empty($get_chat)){
            flashMessage::addFlash('danger', ' Чат не найден');
            $this->view->redirect('/chats');
        }
        $data_userlist = ['users', 'infos', 'userlists']; 
        $chats = $this->model->userlistChat($data_userlist, $_SESSION['user_id'],'user_id','user_id', 'user_id', 'users.id',' INNER JOIN chats ON chats.id = userlists.chat_id ', '');
        if($_SESSION['admin'] != 1 && $chats == false){
            flashMessage::addFlash('danger', 'У вас нет прав доступа!');
            $this->view->redirect('/chats');
        }
        
        $this->view->layout = 'custom_openChat';
        $data_messages = ['users', 'infos', 'messages']; 
        $tables = ['users', 'infos', 'chats']; 
        $chat = $this->model->chatOne($tables,$this->route['id'], 'chat_id','chat_id', 'user_id', 'users.id','','');

        $navigate = [
            'myChats' => 0,
            'favorites' => 0,
            'chatsAll' => 0,
            'openChat' => 1,
            'redirect' => 4
        
            ];
        $_SESSION['navigate'] = $navigate; 
        $this -> model -> set_session_chat($chat[0]);
        $vars = [
            'chat' => $chat,
            'messages' => $this->model->messagesChat($data_messages, $this->route['id'], 'chat_id','chat_id', 'user_id', 'users.id','',''),
            ]; 
        $this->view->render('Chat  page', $vars);
    }






    public function unBannedChatAction(){
        if($_SESSION['admin'] != 1 ){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/chats');
        }

        $data = ['banned' => 0];
        $this -> model -> updateChat('chats',$data,'id',$this->route['id']); 
        flashMessage::addFlash('success', 'Вы успешно раззаблокировали чат');
        $this->redirectRoute();
    }






    public function bannedChatAction(){
        if($_SESSION['admin'] != 1 ){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/chats');
        }

        $data = ['banned' => 1];
        $this -> model -> updateChat('chats',$data,'id',$this->route['id']); 
        flashMessage::addFlash('success', 'Вы успешно заблокировали чат');
        $this->redirectRoute();
    }






    public function addChatShowAction(){
        if($_SESSION['admin'] != 1 && $_SESSION['auth'] != true){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/chats');
        }

        $errors = [];
        $navigate = [
            'myChats' => 0,
            'favorites' => 0,
            'chatsAll' => 0,
            'openChat' => 0]; 
        $tables = ['users', 'infos']; 
        $users =   $this -> model -> usersAll($tables,'user_id', 'users.id');
        $users_all_id = $this -> model -> arrey_all_users_id($users);
        $user_arrey_in_chat[] = $_SESSION['user_id'];
        $user_id_not_chat = $this -> model -> list_add_user($users_all_id, $user_arrey_in_chat); 
        $users_add = [];
        foreach($user_id_not_chat as $id){
            $users_add[] =  $this->model->userOne($tables,$id, 'user_id','user_id', 'user_id', 'users.id','','');
        } 
        foreach($users_add as $users){
            foreach($users as $user){               
                $users_add_not_in_chat[] = $user;    
            }
        }
        
        $vars = [
            'navigate'  => $navigate,
            'users' => $users_add_not_in_chat
            ]; 
            
        $validation = new Validator($_POST);
        
        if(empty($_POST['name_chat'])){
            flashMessage::addFlash('info', 'Нужно обязательно заполнить пол: "name chat"');    
        }
        else{
            
            if($validation->validateChatForm() != null){
                $errors = $validation->validateChatForm();
                $this->view->render('Add new chat', $vars, $errors); die;
            }
            else{
                
                $chat = $this->model->getChat('chats','name_chat',$_POST['name_chat']);

                if(!empty($chat)){
                    flashMessage::addFlash('info', 'Не возможно добавить чат с таким названием, это название уже занято');    
                }
                else{
                    //получение массива id всех выбранных пользователей
                    $arrey_user_new_chat = $this->model->listsIdUserInChat($users_add_not_in_chat);

                    //проверка добавления в чат пользователей, если никто не добвален вернуть пользователя назад и вывести сообщение
                    if(count($arrey_user_new_chat)==0){
                        flashMessage::addFlash('danger','Вы  не выбрали ни одного участника нового чата!');
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
                        // проверка наличия аватара и валидация до создания запимси в таблице
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
                    //создание записи чата в таблицу    
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
                    foreach($arrey_user_new_chat as $user_id){
                        $arrey_db[] = ['user_id' => $user_id,  'chat_id' => $newChatId, 'userlistable_id' => $newChatId, 'name_list_chat' => $_POST['name_chat'], 'role_chat' => 'participant'];    
                    }
                    //запись пользователей в таблицу userlists
                    foreach($arrey_db as $data){  
                        $this->model->createUserlist('userlists',$data);
                    }
                    //добавление записи автора чата в таблицу 'userlists'
                    $data_chat = ['user_id' => $_SESSION['user_id'],  'chat_id' => $newChatId, 'userlistable_id' => $newChatId, 'name_list_chat' => $_POST['name_chat'], 'role_chat' => 'author'];
                    $this->model->createUserlist('userlists',$data_chat);

                    //запись аватара в таблицу после валидации имени чата и записи миени в таблицу
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







    public function editChatShowAction(){
        if($_SESSION['auth'] != true){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/chats');
        } 
        $userInChat = $this->model->getUserInChat('userlists','chat_id','user_id',$this->route['id'],$_SESSION['user_id']);
        $chat = $this->model->getChat('chats','id',$this->route['id']);

        if(empty($chat)){
            flashMessage::addFlash('danger', ' Чат не найден');
            $this->view->redirect('/chats');
        }
        
        $this->model->set_session_chat($chat);
        
        if($_SESSION['admin'] != 1  && $userInChat[0]['role_chat'] != 'moderator' && $chat['author_user_id'] != $_SESSION['user_id']){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/chats');
        }

        $chat = $this->model->getChat('chats','id',$this->route['id']);
        $errors =[];
        $navigate = [
            'myChats' => 0,
            'favorites' => 0,
            'chatsAll' => 0,
            'openChat' => 0];
        $tables = ['users', 'infos']; 
        $data_userlist = ['users', 'infos', 'userlists']; 
        $userlists = $this->model->userlistChat($data_userlist, $this->route['id'], 'chat_id','chat_id', 'user_id', 'users.id','','');
        $users =   $this -> model -> usersAll($tables,'user_id', 'users.id'); 
        $users_all_id = $this -> model -> arrey_all_users_id($users);
        //получение списка пользователей для добавления в чат, за исключением тех которые уже добавлены в чат
        $users_add_not_in_chat = $this->users_add_not_in_chat($userlists,$users_all_id);
        $vars = [
            'chat' => $this->model->getChat('chats','id',$this->route['id']),
            'navigate'  => $navigate,
            'users' => $users_add_not_in_chat,
            'userlists' => $userlists,
             ]; 

        if(!empty($_FILES['avatar_chat']['name'])){
            $this->updateAvatar($vars,$errors);
        }
        
        //добавление участников чата и изменение названия чата
        if(!empty($_POST)){
            //изменение названия чата
            if($_POST['name_chat'] != $chat['name_chat']){
                $this->changeNameChat($vars,$errors);
            }
            //запись в таблицу нового состава уастников чата
            if(!empty($_POST['add_user'])){   
                $this->addNewUserInChat($users_add_not_in_chat,$chat);
            }
            $this->view->redirect('/editChatShow/'.$this->route['id']);  
        }
        $this->view->render('Edit chat', $vars,$errors);
    }

    



    public function messageAction(){
        if($_SESSION['auth'] != true){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/chats');
        } 
        $data_userlist = ['users', 'infos', 'userlists']; 
        $userlists = $this->model->userlistChat($data_userlist, $this->route['id'], 'chat_id','chat_id', 'user_id', 'users.id','','');

        if($_SESSION['admin'] != 1  && $this->model->isUserInChat($userlists,$_SESSION['user_id']) !=true){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/chats');
        }

        $tables = ['users', 'infos', 'chats']; 
        $chat = $this->model->chatOne($tables,$this->route['id'], 'chat_id','chat_id', 'user_id', 'users.id','',''); 
        $data_messages = [ 
            'user_id' => $_SESSION['user_id'],
            'message' => $_POST['message'],
            'chat_id' => $this->route['id'], 
            'info_id' => $chat[0]['info_id']   
        ];
        $this->model->createMessage('messages',$data_messages);

        //получение из таблицы id последней записанной записи чата
        $new_message_id = $this->model->newChatId();
        $data = [    
            'message_id' => $new_message_id,
            'messageable_id' => $new_message_id,     
        ];
        $this -> model -> updateMessage('chats',$data,'id',$this->route['id']);     
        $this->view->redirect('/openChat/'.$this->route['id']);  
    }





    public function delete_messageAction(){
        $get_message = $this->model->getChat('messages','id',$this->route['id']);
        if(empty($get_message)){
            flashMessage::addFlash('danger', ' сообщение не найдено');
            $this->view->redirect('/openChat/'.$_SESSION['chat_id']);
        }
        if($get_message['user_id'] != $_SESSION['user_id'] && $_SESSION['admin'] !=1){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/chats');
        } 
        $userMessegeInChat = $this->model->getMessageUserInChat('messages','id','user_id',$this->route['id'],$_SESSION['user_id']);

        if($_SESSION['admin'] != 1  && $userMessegeInChat == false){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/chats');
        }

        $this->model->deleteMessage('messages','id',$this->route['id']);    
        $this->view->redirect('/openChat/'.$_SESSION['chat_id']);  
    }





    public function onFavoritesAction(){
        if($_SESSION['admin'] != 1 && $_SESSION['auth'] != true){
            flashMessage::addFlash('danger', 'У вас нет прав доступа!');
            $this->view->redirect('/chats');
        } 
        
        if($_SESSION['admin'] == 1){
            $data = ['favorites' => 1];
            $this -> model -> updateChat('chats',$data,'id',$this->route['id']); 
            flashMessage::addFlash('success', 'Вы успешно добавили чат в избранное');
            $this->redirectRoute();
        }
        else{
            $data = ['favorites_chat' => 1];
            $this -> model -> updateTableTwoParam('userlists',$data,'chat_id',$this->route['id'],'user_id',$_SESSION['user_id']); 
            flashMessage::addFlash('success', 'Вы успешно добавили чат в избранное');
            $this->redirectRoute();
        }   
    }





    public function offFavoritesAction(){
        if($_SESSION['admin'] != 1 && $_SESSION['auth'] != true){
            flashMessage::addFlash('danger', 'У вас нет прав доступа!');
            $this->view->redirect('/chats');
        } 
        
        if($_SESSION['admin'] == 1){
            $data = ['favorites' => 0];
            $this -> model -> updateChat('chats',$data,'id',$this->route['id']); 
            flashMessage::addFlash('success', 'Вы успешно добавили чат в избранное');
            $this->redirectRoute();
        }
        else{
            $data = ['favorites_chat' => 0];
            $this -> model -> updateTableTwoParam('userlists',$data,'chat_id',$this->route['id'],'user_id',$_SESSION['user_id']); 
            flashMessage::addFlash('success', 'Вы успешно добавили чат в избранное');
            $this->redirectRoute();
        }   
    }





   
    public function deleteChatAction(){
        $chat = $this->model->getChat('chats','id',$this->route['id']);
        if($chat == false){
            flashMessage::addFlash('info', 'Ошибка! Такого чата нет!');
            $this->view->redirect('/chats');
        }

        if($_SESSION['admin'] != 1 && $_SESSION['user_id'] != $chat['author_user_id']){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/chats');
        } 

        $this -> model -> deleteFileAvatar('chats','id',$this->route['id']); 
        
        $this->model->deleteChat('chats','id', $this->route['id']);
        $this->model->deleteChat('userlists','chat_id',$this->route['id']);
        $this->model->deleteChat('messages','chat_id',$this->route['id']);
        flashMessage::addFlash('success', 'Вы успешно удалили чат!');
        $this->view->redirect('/chats');
    }





    public function roleModeratorAction(){
        if($_SESSION['auth'] != true){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/chats');
        } 
        
        $userInChat = $this->model->getUserInChat('userlists','chat_id','user_id',$_SESSION['chat_id'],$this->route['id']);
        $chat = $this->model->getChat('chats','id',$_SESSION['chat_id']);
        
        if($_SESSION['admin'] != 1  && $userInChat['role_chat'] != 'moderator' && $chat['author_user_id'] != $_SESSION['user_id']){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/chats');
        }

        $data = ['role_chat' => 'moderator'];
        $this -> model -> updateTableTwoParam('userlists',$data,'user_id',$this->route['id'], 'chat_id', $_SESSION['chat_id']); 
        flashMessage::addFlash('success', 'Вы успешно предоставили пользователю роль "Moderator"');
        $this->view->redirect('/editChatShow/'.$_SESSION['chat_id']);
    }





    public function roleParticipantAction(){
        if($_SESSION['auth'] != true){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/chats');
        } 
        
        $userInChat = $this->model->getUserInChat('userlists','chat_id','user_id',$_SESSION['chat_id'],$this->route['id']);
        $chat = $this->model->getChat('chats','id',$_SESSION['chat_id']);
        
        if($_SESSION['admin'] != 1  && $userInChat['role_chat'] != 'moderator' && $chat['author_user_id'] != $_SESSION['user_id']){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/chats');
        }
   
        $data = ['role' => 'participant'];
        $this -> model -> updateTableTwoParam('userlists',$data,'user_id',$this->route['id'], 'chat_id', $_SESSION['chat_id']); 
        flashMessage::addFlash('success', 'Вы успешно предоставили пользователю роль "Participant"');
        $this->view->redirect('/editChatShow/'.$_SESSION['chat_id']);
    }





    public function deleteUserChatAction(){
        if($_SESSION['auth'] != true){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/editChatShow/'.$_SESSION['chat_id']);
        } 
        
        $userInChat = $this->model->getUserInChat('userlists','chat_id','user_id',$_SESSION['chat_id'],$this->route['id']);
        $chat = $this->model->getChat('chats','id',$_SESSION['chat_id']);
        
        if($_SESSION['admin'] != 1  && $userInChat['role_chat'] != 'moderator' && $chat['author_user_id'] != $_SESSION['user_id']){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/editChatShow/'.$_SESSION['chat_id']);
        }
        $this->model->deleteUserInChat('userlists','chat_id','user_id',$_SESSION['chat_id'],$this->route['id']);
        $this->view->redirect('/editChatShow/'.$_SESSION['chat_id']);
    }





    public function exitChatAction(){
        
        if($_SESSION['auth'] != true){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/openChat/'.$_SESSION['chat_id']);
        } 
        
        $userInChat = $this->model->getUserInChat('userlists','chat_id','user_id',$_SESSION['chat_id'],$this->route['id']);
        $chat = $this->model->getChat('chats','id',$_SESSION['chat_id']);
        
        if($userInChat == false){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/openChat/'.$_SESSION['chat_id']);
        }
        elseif($userInChat[0]['role_chat'] == 'author'){
            flashMessage::addFlash('danger', 'Прежде чем покинуть чат вы должны назначить нового автора чата!');
            $this->view->redirect('/roleChat/'.$_SESSION['chat_id']);
        }
        $this->model->deleteUserInChat('userlists','chat_id','user_id',$_SESSION['chat_id'],$this->route['id']);
        $this->model->deleteUserInChat('messages','chat_id','user_id',$_SESSION['chat_id'],$this->route['id']);
        $this->view->redirect('/openChat/'.$_SESSION['chat_id']);
    }



    


    public function roleChatAction(){
        
        if($_SESSION['auth'] != true){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/chats');
        } 
        
        $chat = $this->model->getChat('chats','id',$_SESSION['chat_id']);
        
        if($_SESSION['admin'] != 1  && $chat['author_user_id'] != $_SESSION['user_id']){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/chats');
        }
        
        $errors = [];
        $navigate = [
            'myChats' => 0,
            'favorites' => 0,
            'chatsAll' => 0,
            'openChat' => 0]; 
        $data_userlist = ['users', 'infos', 'userlists'];     
        $userlists = $this->model->userlistChat($data_userlist, $_SESSION['chat_id'], 'chat_id','chat_id', 'user_id', 'users.id','','');
        
        $statuses = [
            'participant' ,
            'moderator',
            'author'
        ];
        $vars = [
            'chat' => $this->model->getChat('chats','id',$this->route['id']),
            'navigate'  => $navigate,
            'users' => $userlists,
            'statuses' => $statuses
             ]; 
        $this->view->render('roleChat', $vars,$errors);
    }






    public function setRoleChatAction(){
        
        if($_SESSION['auth'] != true){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/chats');
        } 
        
        $chat = $this->model->getChat('chats','id',$_SESSION['chat_id']);
        
        if($_SESSION['admin'] != 1  && $chat['author_user_id'] != $_SESSION['user_id']){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/chats');
        }
        
        $errors = [];
        $navigate = [
            'myChats' => 0,
            'favorites' => 0,
            'chatsAll' => 0,
            'openChat' => 0]; 
        $data_userlist = ['users', 'infos', 'userlists'];   
        $selected_userlist_id = $this->model->getUserInChat('userlists','chat_id','user_id',$this->route['id'],$_POST['user']);
        $userlists = $this->model->userlistChat($data_userlist, $this->route['id'], 'chat_id','chat_id', 'user_id', 'users.id','','');
         
        if($_POST['role'] == 'author'){
            //изменение в таблице  chats
            $data_chat = ['author_user_id'  => $_POST['user'],'user_id' => $_POST['user']];
            $this -> model -> updateChat('chats',$data_chat,'id',$chat['id']);
            //изменение в таблице userlists 
            $data_old_author = [
                'role_chat' => 'moderator'
            ];
            $selected_old_userlist_id = $this->model->getUserInChat('userlists','chat_id','user_id',$chat['id'],$_SESSION['user_id']);
            
            $this -> model -> updateChat('userlists',$data_old_author,'id',$selected_old_userlist_id[0]['id']); 
            
            $data_new_author = [
                'role_chat' => 'author'
            ];

            $this -> model -> updateChat('userlists',$data_new_author,'id',$selected_userlist_id[0]['id']); 
        }
        else{
            //изменение в таблице userlists 
            $data = [
            'role_chat' => $_POST['role'],
            'user_id' => $_POST['user']
        ];
            $this -> model -> updateChat('userlists',$data,'id',$selected_userlist_id[0]['id']); 
        }
        flashMessage::addFlash('success', 'Вы успешно изменили роль участника чата');
        $this->view->redirect('/openChat/'.$this->route['id']);
    }






    private function redirectRoute(){
        
        switch($_SESSION['navigate']['redirect']){
            case 2:
                $this->view->redirect('/favoritesChats');
                break;
            case 3:
                $this->view->redirect('/myChats');
                break;
            case 1:
                $this->view->redirect('/chats');
                break;
            case 4: 
                $this->view->redirect('/openChat/'.$_SESSION['chat_id']);
                break;
        }
    }




    private function updateAvatar($vars,$errors){
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
                    $this -> model -> deleteFileAvatar('chats','id',$this->route['id']); 
                    $dataAvatar = ['chat_avatar' => $new_avatar];
                    $media->updateAvatar('chats',$dataAvatar,'id',$this->route['id']); 
                    flashMessage::addFlash('success', 'Вы успешно  изменили аватар чата');    
                    $this->view->redirect('/editChatShow/'.$this->route['id']);  
                }
            }
    }





    private function changeNameChat($vars,$errors){
       
            $validate = new Validator($_POST);
            if($validate->validateChatForm() != null){
                $errors = $validate->validateChatForm();
                $this->view->render('Add new chat', $vars, $errors); die;
            }
            else{   
                $dataChat = ['name_chat' => $_POST['name_chat'],'names' => $_POST['name_chat'],'search' => strtolower($_POST['name_chat'])];  
                $data_userlist = ['name_list_chat' => $_POST['name_chat']];
                $this -> model -> updateChat('chats',$dataChat,'id',$this->route['id']); 
                $this -> model -> updateUserlist('userlists',$data_userlist,'chat_id',$this->route['id']); 
                flashMessage::addFlash('success', 'Вы успешно  обновили название чата');        
            }   
    }





    private function addNewUserInChat($users_add_not_in_chat,$chat){
        //получение массива id всех выбранных пользователей
        $arrey_user_new_chat = $this->model->listsIdUserInChat($users_add_not_in_chat);
        //формирование массива данных о пользователях и чате в котором они участвуют, для групповой записи в таблицу ''userlists'
        $arrey_db = [];
        if(!empty($_POST['name_chat'])){
            $post = $_POST['name_chat'];
        }
        else{
            $post = $chat['name_list_chat'];
        }
        foreach($arrey_user_new_chat as $user_id){
            $arrey_db[] = ['user_id' => $user_id,  'chat_id' => $chat['chat_id'], 'userlistable_id' => $chat['chat_id'], 'userlistable_type' => 'App\Models\Chat','name_list_chat' => $post, 'role_chat' => 'participant'];    
        }
        foreach($arrey_db as $db){
                         
                $db_arrey[] = $db;    
            
        } 
        foreach($arrey_db as $data){           
            $this->model->createUserlist('userlists',$data);
        } 
    }



    private function users_add_not_in_chat($userlists,$users_all_id){
        //получение списка пользователей для добавления в чат, за исключением тех которые уже добавлены в чат
        $usersists_id = $this -> model -> arrey_all_users_id($userlists); 
        $user_id_not_chat = $this -> model -> list_add_user($users_all_id, $usersists_id); 
        $tables_users = ['users', 'infos']; 
        $users_add = [];
        foreach($user_id_not_chat as $id){
            $users_add[] =  $this->model->userOne($tables_users,$id, 'user_id','user_id', 'user_id', 'users.id','','');
        }  
        foreach($users_add as $users){
            foreach($users as $user){               
                $users_add_not_in_chat[] = $user;    
            }
        } 
        return $users_add_not_in_chat;
    }
    
}
