<?php
namespace App\Controllers;
session_start();

use Models\Users;
use App\Core\Model;
use App\Models\Auth;
use Database\MakePdo;
use App\lib\Pagination;
use App\Core\Controller;
use App\Models\Validator;
use App\Models\flashMessage;
use App\Models\MediaBuilder;


class UsersController extends Controller {

    public function usersAction(){
        $pagination = new Pagination($this->route, $this->model->usersCount('users'));
		$vars = [
			'pagination' => $pagination->get(),
			'usersList' => $this->model->usersListAll($this->route['page']),
		];   
        $this->view->render('Users list page', $vars);
    }

    public function user_profileAction(){

        if($this->model->getOneUser_oneTable('users','id',$this->route['id']) == false){
            flashMessage::addFlash('info', 'Такого пользователя нет!');
            $this->view->redirect('/');
        }

        if($_SESSION['admin'] != 1 && $_SESSION['user_id'] != $this->route['id']){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/');
        } 
        $tables = ['users', 'infos', 'socials'];
        $vars = $this->model->getUsersOne($tables,$this->route['id']);
        $this->view->render('User profile page', $vars);
    }


    public function editAction(){
        $vars =[];
        $errors = [];
        if($this->model->getOneUser_oneTable('users','id',$this->route['id']) == false){
            flashMessage::addFlash('info', 'Такого пользователя нет!');
            $this->view->redirect('/');
        }

        if($_SESSION['admin'] != 1 && $_SESSION['user_id'] != $this->route['id']){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/');
        } 
        
        $vars = $this->model->getUsersOne(['users', 'infos', 'socials'],$this->route['id']);

        if(!empty($_POST['name']) || !empty($_POST['occupation']) || !empty($_POST['phone']) || isset($_POST['location'])){

            $validation = new Validator($_POST);

            if( $validation->validateEditForm() == null){
                $data = [
                    'occupation' => $_POST['occupation'],
                    'location' => $_POST['location'],
                    'phone' => $_POST['phone']
                ];
                $this->model->updateUser('infos',$data,$vars['info_id']);

                $data_users = [
                    'name' => $_POST['name']
                ];
                
                $this->model->updateUser('users',$data_users,$vars['user_id']);
                flashMessage::addFlash('success', 'Вы успешно изменили данные профиля');
                $this->view->redirect('/user/'.$vars['user_id']);
            }
            else{
                flashMessage::addFlash('ganger', 'Вы допустили ошибку при заполнении формы, исправьте данные');
                $errors = $validation->validateEditForm();
            }    
        }
        $this->view->render('Edit user profile page', $vars, $errors);
    }


    public function mediaAction(){
        if($this->model->getOneUser_oneTable('users','id',$this->route['id']) == false){
            flashMessage::addFlash('info', 'Такого пользователя нет!');
            $this->view->redirect('/');
        }

        if($_SESSION['admin'] != 1 && $_SESSION['user_id'] != $this->route['id']){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/');
        } 
        $errors =[];
        $vars = $this->model->getOneTableWhereUser_id('infos','user_id',$this->route['id']);

        if(!empty($_FILES)){
            $validate = new Validator($_POST);
            if($validate->validateImageAvatar() != null){
                $errors = $validate->validateImageAvatar();
            }
            else{
                $media = new MediaBuilder;
                $new_avatar=$media->makeNewAvatar();
                if($media->loadingFileAvatar() == false){
                    flashMessage::addFlash('denger', 'Не удалось загрузить файл');
                }
                else{
                    $dataAvatar = ['avatar' => $new_avatar];
                    $imageId = $this->model->getOneTableWhereUser_id('infos','user_id',$this->route['id']);
                    $media->delete_file('infos','id',$imageId['id']);
                    $media->updateAvatar('infos',$dataAvatar,$imageId['id']); 
                    flashMessage::addFlash('success', 'Вы успешно загрузили новый аватар');
                    $this->view->redirect('/user/'.$this->route['id']); 
                }
            }
        }
        $this->view->render('Media user page', $vars, $errors);
    }


    public function statusShowAction(){

        if($this->model->getOneUser_oneTable('users','id',$this->route['id']) == false){
            flashMessage::addFlash('info', 'Такого пользователя нет!');
            $this->view->redirect('/');
        }

        if($_SESSION['admin'] != 1 && $_SESSION['user_id'] != $this->route['id']){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/');
        } 

        $users = $this->model->getOneTableWhereUser_id('infos','user_id',$this->route['id']);
        $vars = [
                'status' => [ 0 => 'Онлайн',
                        1 => 'Не беспокоить',
                        2 => 'Отошел'
                    ],
                'users'  => $users,
                ];            
        $this->view->render('Status user page', $vars);
    }

    public function statusSetAction(){
        
        if($this->model->getOneUser_oneTable('infos','id',$this->route['id']) == false){
            flashMessage::addFlash('info', 'Такого пользователя нет!');
            $this->view->redirect('/');
        }

        if($_SESSION['admin'] != 1 && $_SESSION['user_id'] != $this->route['id']){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/');
        } 
        
        $statuses = [
            'Онлайн' => 0,
            'Не беспокоить' => 1,
            'Отошел' => 2
        ];
        $status = $statuses[$_POST['status']];
        $data = [
            'status' => $status
        ];
        
        $this->model->updateUser('infos',$data,$this->route['id']);
        flashMessage::addFlash('success', 'Вы успешно изменили статус');
        $this->view->redirect('/');
    }


    public function create_userAction(){
        $vars = [];
        $errors = [];
        $validation = new Validator($_POST);

        if($_SESSION['admin'] != 1 ){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/');
        } 

        if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password'])){
            flashMessage::addFlash('info', 'Нужно обязательно заполнить 3 поля: "name", "email", "password"');    
        }
        else{
            if($validation->validateCreateUserForm() != null){
                $errors = $validation->validateCreateUserForm();
            }
            else{
                
                $user = $this->model->getOneUser_oneTable('users','email',$_POST['email']);

                if(!empty($user))
                {
                    flashMessage::addFlash('info', 'Не возможно добавить пользователя, этот логин занят');    
                }
                else{
                    $passwordNewUser = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    $dataUsers = [ 
                            'name' => $_POST['name'],
                            'email' => $_POST['email'],
                            'password' => $passwordNewUser,
                            'admin' => 0 
                        ];
                    $this->model->createUser('users', $dataUsers);
                    $newUserId =  $this->model->newUserId();

                    $dataInfos = [ 
                        'status' => 0,
                        'location' => '',
                        'phone' => '',
                        'occupation' => '',
                        'user_id' => $newUserId,
                        'infosable_id' => $newUserId   
                    ];
                    
                    $this->model->createUser('infos', $dataInfos);
                    $userInfo = $this->model->getOneUser_oneTable('infos','user_id',$newUserId);
                    $data = ['info_id' => $userInfo['id']];
                    $this->model->updateUser('users',$data,$newUserId);

                    $dataSocials = [ 
                        'vk' => '',
                        'telegram' => '',
                        'instagram' => '',
                        'user_id' => $newUserId, 
                    ];

                    
                    $this->model->createUser('socials', $dataSocials);
                    $userSocial = $this->model->getOneUser_oneTable('socials','user_id',$newUserId);
                    
                    $data = ['social_id' => $userSocial['id']];
                    $this->model->updateUser('users',$data,$newUserId); 
                
               
                    if(!empty($_POST['location']) || !empty($_POST['occupation']) || !empty($_POST['phone']) || !empty($_POST['status'])){
                        $list_statuses_set=[ 'онлайн' => 0,  'не беспокоить' => 1,  'отошел' => 2];
                        $status_key = $list_statuses_set[$_POST['status']];

                        $validation = new Validator($_POST);
                        
                        $dataInfos = [ 
                                'status' => $status_key,
                                'location' => $_POST['location'],
                                'phone' => $_POST['phone'],
                                'occupation' => $_POST['occupation'],
                                'user_id' => $newUserId,
                                'infosable_id' => $newUserId   
                             ];
                            
                            $this->model->updateUser('infos',$dataInfos,$userInfo['id']);   
                    }
                    
                    if(!empty($_POST['vk']) || !empty($_POST['telegram']) || !empty($_POST['instagram'])){
                        
                            $dataSocials = [ 
                                    'vk' => $_POST['vk'],
                                    'telegram' => $_POST['telegram'],
                                    'instagram' => $_POST['instagram'],
                                    'user_id' => $newUserId, 
                                ];
                            $tableSocials = 'socials';
                            $this->model->updateUser($tableSocials,$dataSocials,$userSocial['id']);  
                       
                    }
                    
                    if(!empty($_FILES['avatar']['name'])){
                       
                        $media = new MediaBuilder;
                        if($media->loadingFileAvatar() == false){
                            flashMessage::addFlash('denger', 'Не удалось загрузить файл'); 
                        }
                        else{
                            $dataAvatar = ['avatar' => $media->makeNewAvatar()];
                            $media->updateAvatar('infos',$dataAvatar,$userInfo['id']); 
                        }    
                    }
                    flashMessage::addFlash('success', 'Вы успешно добавили нового пользователя'); 
                    $this->view->redirect('/');   
                } 
            }    
        }
        
        $this->view->render('Create user page', $vars, $errors);
    }


    public function securityAction(){
        $errors = [];
        if($this->model->getOneUser_oneTable('users','id',$this->route['id']) == false){
            flashMessage::addFlash('info', 'Такого пользователя нет!');
            $this->view->redirect('/');
        }

        if($_SESSION['admin'] != 1 && $_SESSION['user_id'] != $this->route['id']){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/');
        } 

        if(!empty($_POST['password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])){
            $validate = new Validator($_POST);
            if($validate->validateSecurityForm() == null){

                    $auth = new Auth;
                    
                    if($auth->password_verification('users','id',$this->route['id'],$_POST['password']) == true){
                        if($_POST['new_password'] == $_POST['confirm_password']){
                            $auth->setPassword($_POST['new_password'], $this->route['id']);
                            flashMessage::addFlash('success', 'Вы успешно изменили пароль'); 
                            $this->view->redirect('/');
                        }
                        else{
                            flashMessage::addFlash('info', 'Новый пароль и его подтверждение не совпадают'); 
                        }
                    }
                    else{
                        flashMessage::addFlash('danger', 'Не верно введен текущий пароль'); 
                    }
            }
            else{
                $errors = $validate->validateSecurityForm();
            }
        }
        else{
            flashMessage::addFlash('info', 'Необходимо заполнить все поля формы'); 
        }   
        $vars = null;
        $this->view->render('Security', $vars, $errors);
    }


    public function change_emailAction(){
        $errors = [];
        if($this->model->getOneUser_oneTable('users','id',$this->route['id']) == false){
            flashMessage::addFlash('info', 'Такого пользователя нет!');
            $this->view->redirect('/');
        }

        if($_SESSION['admin'] != 1 && $_SESSION['user_id'] != $this->route['id']){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/');
        } 

        if(!empty($_POST['email']) && !empty($_POST['new_email']) && !empty($_POST['password'])){

            $validate = new Validator($_POST);

            if($validate->validateChangeEmailForm() == null){

                $auth = new Auth;
                
                if($auth->email_verification('users','id',$this->route['id'],$_POST['email']) == true){
                    if($_POST['new_email'] == $_POST['confirm_email']){
                        if($auth->password_verification('users','id',$this->route['id'],$_POST['password']) == true){
                            $data = ['email' => $_POST['new_email']];
                            $this->model->updateUser('users',$data,$this->route['id']);
                            flashMessage::addFlash('success', 'Вы успешно изменили почту'); 
                            $this->view->redirect('/');
                        }
                        else{
                            flashMessage::addFlash('danger', 'Пароль введен неверно'); 
                        }
                    }
                    else{
                        flashMessage::addFlash('danger', 'Новая почта и ее подтверждение не совпадают'); 
                    }
                }
                else{
                    flashMessage::addFlash('danger', 'Не верно введена текущая почта'); 
                }       
            }
            else{
                $errors = $validate->validateChangeEmailForm();
            }
        }
        else{
            flashMessage::addFlash('info', 'Необходимо заполнить все поля формы'); 
        }
        $vars = null;
        $this->view->render('Change email', $vars, $errors);
    }

    



    
    
}