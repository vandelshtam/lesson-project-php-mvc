<?php
namespace App\Controllers;
session_start();

use Models\Users;
use App\Core\Model;
use App\Models\Auth;
use Database\MakePdo;
use App\Core\Controller;
use App\Models\Validator;
use App\Models\flashMessage;
use App\Models\MediaBuilder;


class UsersController extends Controller {

    public function usersAction(){
        
        $vars = $this->model->getUsersAll();
        $this->view->render('Users list page', $vars);
    }


    public function user_profileAction(){
        
		$user_id = $this->route['id'];
        $vars = $this->model->getUsersOne($user_id);
        $this->view->render('User profile page', $vars);
    }


    public function editAction(){
        
        if($this->model->getOneData('users',$this->route['id']) == false){
            $key = 'info';
            $value = 'Такого пользователя нет!';
            flashMessage::addFlash($key, $value);
            $this->view->redirect('/');
        }

        $user_id = $this->route['id'];

        if($_SESSION['admin'] != 1 && $_SESSION['id'] != $user_id){
            $key = 'danger';
            $value = 'У вас нет прав доступа к действию!';
            flashMessage::addFlash($key, $value);
            $this->view->redirect('/');
        } 
        
        $vars = $this->model->getUsersOne($user_id);
        $infoId = $vars['info_id'];
        $socialId = $vars['social_id'];
        $usersId = $vars['user_id'];

        if(!empty($_POST['name']) || !empty($_POST['occupation']) || !empty($_POST['phone']) || isset($_POST['location'])){

            $validation = new Validator($_POST);

            if( $validation->validateEditForm() == null){
                
                $data = [
                    'occupation' => $_POST['occupation'],
                    'location' => $_POST['location'],
                    'phone' => $_POST['phone']
                ];
                $table = 'infos';
                $this->model->updateUser($table,$data,$infoId);

                $data_users = [
                    'name' => $_POST['name']
                ];
                $table_users = 'users';
                $this->model->updateUser($table_users,$data_users,$usersId);

                $key = 'success';
                $value = 'Вы успешно изменили данные профиля';
                flashMessage::addFlash($key, $value);
                $this->view->redirect('/user/'.$user_id);
            }
            else{
                $key = 'ganger';
                $value = 'Вы допустили ошибку при заполнении формы, исправьте данные';
                flashMessage::addFlash($key, $value);
                $errors = $validation->validateEditForm();
            }    
        }
        $this->view->render('Edit user profile page', $vars, $errors);
    }


    public function mediaAction(){
        if($this->model->getOneData('users',$this->route['id']) == false){
            $key = 'info';
            $value = 'Такого пользователя нет!';
            flashMessage::addFlash($key, $value);
            $this->view->redirect('/');
        }

        if($_SESSION['admin'] != 1 && $_SESSION['id'] != $this->route['id']){
            $key = 'danger';
            $value = 'У вас нет прав доступа к действию!';
            flashMessage::addFlash($key, $value);
            $this->view->redirect('/');
        } 
        $errors =[];
        $vars = $this->model->getOneTableWhereUser_id('infos',$this->route['id']);

        if(!empty($_FILES)){
            $validate = new Validator($_POST);
            if($validate->validateImageAvatar() != null){
                $errors = $validate->validateImageAvatar();
            }
            else{
                $media = new MediaBuilder;
                $direct='/Applications/MAMP/htdocs/lesson-project-php-mvc/public/uploads/';
                $image_name=$_FILES['avatar']['name'];
                $image_name_tmp=$_FILES['avatar']['tmp_name'];
                $new_avatar=$media->makeNewAvatar($image_name);
                if($media->loadingFileAvatar($image_name_tmp,$direct,$image_name) == false){
                    $key = 'denger';
                    $value = 'Не удалось загрузить файл';
                    flashMessage::addFlash($key, $value);
                }
                else{
                    $dataAvatar = ['avatar' => $new_avatar];
                    $user = $this->model->getOneTableWhereUser_id('infos',$this->route['id']);
                    $media->delete_file('infos',$user['id']);
                    $media->updateAvatar('infos',$dataAvatar,$user['id']); 
                    $key = 'success';
                    $value = 'Вы успешно загрузили новый аватар';
                    flashMessage::addFlash($key, $value);
                    $this->view->redirect('/user/'.$this->route['id']); 
                }
            }

        }
        $this->view->render('Media user page', $vars, $errors);
    }


    public function statusShowAction(){

        $user_id = $this->route['id'];
        $table = 'infos';
        $users = $this->model->getOneTableWhereUser_id($table,$user_id);
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

        $id = $this->route['id'];
        $table = 'infos';
        $statuses = [
            'Онлайн' => 0,
            'Не беспокоить' => 1,
            'Отошел' => 2
        ];
        $status = $statuses[$_POST['status']];
        $data = [
            'status' => $status
        ];
        $this->model->updateUser($table,$data,$id);
        $key = 'success';
        $value = 'Вы успешно изменили статус';
        flashMessage::addFlash($key, $value);
        $this->view->redirect('/');
    }


    public function create_userAction(){
        $vars = [];
        $validation = new Validator($_POST);

        if($_SESSION['admin'] != 1 ){
            $key = 'danger';
            $value = 'У вас нет прав доступа к действию!';
            flashMessage::addFlash($key, $value);
            $this->view->redirect('/');
        } 

        if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password'])){
            $key = 'info';
            $value = 'Нужно обязательно заполнить 3 поля: "name", "email", "password"';
            flashMessage::addFlash($key, $value);    
        }
        else{
            if($validation->validateCreateUserForm() != null){
                $errors = $validation->validateCreateUserForm();
            }
            else{
                $email=$_POST['email'];
                $password = $_POST['password'];
                $tableUsers = 'users';
                $name = $_POST['name'];
                $user = $this->model->getUserOnTable($tableUsers, $email);

                if(!empty($user))
                {
                    $key = 'info';
                    $value = 'Не возможно добавить пользователя, этот логин занят';
                    flashMessage::addFlash($key, $value);    
                }
                else{
                    $passwordNewUser = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    $dataUsers = [ 
                            'name' => $name,
                            'email' => $email,
                            'password' => $passwordNewUser,
                            'admin' => 0 
                        ];
                    $this->model->createUser($tableUsers, $dataUsers);
                    $newUserId =  $this->model->newUserId();

                    $dataInfos = [ 
                        'status' => 0,
                        'location' => '',
                        'phone' => '',
                        'occupation' => '',
                        'user_id' => $newUserId,
                        'infosable_id' => $newUserId   
                    ];
                    $tableInfos = 'infos';
                    $this->model->createUser($tableInfos, $dataInfos);
                    $userInfo = $this->model->getOneOnUserId($tableInfos,$newUserId);
                    $lastInfosId = $userInfo['id'];
                    $data = ['info_id' => $lastInfosId];
                    $this->model->updateUser($tableUsers,$data,$newUserId);

                    $dataSocials = [ 
                        'vk' => '',
                        'telegram' => '',
                        'instagram' => '',
                        'user_id' => $newUserId, 
                    ];

                    $tableSocials = 'socials';
                    $this->model->createUser($tableSocials, $dataSocials);
                    $userSocial = $this->model->getOneOnUserId($tableSocials,$newUserId);
                    $lastSocialsId = $userSocial['id'];
                    
                    $data = ['social_id' => $lastSocialsId];
                    $this->model->updateUser($tableUsers,$data,$newUserId); 
                
               
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
                            $tableInfos = 'infos';
                            $this->model->updateUser($tableInfos,$dataInfos,$lastInfosId);   
                    }
                    
                    if(!empty($_POST['vk']) || !empty($_POST['telegram']) || !empty($_POST['instagram'])){
                        
                            $dataSocials = [ 
                                    'vk' => $_POST['vk'],
                                    'telegram' => $_POST['telegram'],
                                    'instagram' => $_POST['instagram'],
                                    'user_id' => $newUserId, 
                                ];
                            $tableSocials = 'socials';
                            $this->model->updateUser($tableSocials,$dataSocials,$lastSocialsId);  
                       
                    }
                    
                    if(!empty($_FILES['avatar']['name'])){
                    
                        $direct='/Applications/MAMP/htdocs/lesson-project-php-mvc/public/uploads/';
                        $image_name=$_FILES['avatar']['name'];
                        $image_name_tmp=$_FILES['avatar']['tmp_name'];
                        $new_avatar='uploads/'.$image_name;
                        $this->model->loadingFileAvatar($image_name_tmp,$direct,$image_name);
                        $media = new MediaBuilder;
                        if($media->set_file_image($image_name_tmp,$image_name,$direct) == false){
                            $key = 'denger';
                            $value = 'Не удалось загрузить файл';
                            flashMessage::addFlash($key, $value); 
                        }
                        $dataAvatar = ['avatar' => $new_avatar];
                        $media->updateAvatar($tableInfos,$dataAvatar,$lastInfosId); 
                    }
                    $key = 'success';
                    $value = 'Вы успешно добавили нового пользователя';
                    flashMessage::addFlash($key, $value); 
                    $this->view->redirect('/');   
                } 
            }    
        }
        $vars = null;
        $this->view->render('Create user page', $vars, $errors);
    }


    public function securityAction(){
        $errors = [];
        if($_SESSION['admin'] != 1 && $_SESSION['id'] != $this->route['id']){
            $key = 'danger';
            $value = 'У вас нет прав доступа к действию!';
            flashMessage::addFlash($key, $value);
            $this->view->redirect('/');
        } 

        if(!empty($_POST['password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])){
            $validate = new Validator($_POST);
            if($validate->validateSecurityForm() == null){

                    $auth = new Auth;
                    $password = $_POST['password'];
        //dd($_POST['password']);
        //dd($this->route['id']);
        //dd($auth->password_verification($this->route['id'],$password));
                    if($auth->password_verification($this->route['id'],$password) == true){
                        if($_POST['new_password'] == $_POST['confirm_password']){
                            $auth->setPassword($_POST['new_password'], $this->route['id']);
                            $key = 'success';
                            $value = 'Вы успешно изменили пароль';
                            flashMessage::addFlash($key, $value); 
                            $this->view->redirect('/');
                        }
                        else{
                            $key = 'info';
                            $value = 'Новый пароль и его подтверждение не совпадают';
                            flashMessage::addFlash($key, $value); 
                        }
                    }
                    else{
                        $key = 'danger';
                        $value = 'Не верно введен текущий пароль';
                        flashMessage::addFlash($key, $value); 
                    }
            }
            else{
                $errors = $validate->validateSecurityForm();
                //dd($errors);
            }
        }
        else{
            $key = 'info';
            $value = 'Необходимо заполнить все поля формы';
            flashMessage::addFlash($key, $value); 
        }
        
        $vars = null;
        $this->view->render('Security', $vars, $errors);
    }


    public function change_emailAction(){
        $errors = [];
        if($_SESSION['admin'] != 1 && $_SESSION['id'] != $this->route['id']){
            $key = 'danger';
            $value = 'У вас нет прав доступа к действию!';
            flashMessage::addFlash($key, $value);
            $this->view->redirect('/');
        } 

        if(!empty($_POST['email']) && !empty($_POST['new_email']) && !empty($_POST['password'])){

            $validate = new Validator($_POST);

            if($validate->validateChangeEmailForm() == null){

                $auth = new Auth;
                $password = $_POST['password'];
                $email = $_POST['email'];
                $new_email = $_POST['new_email'];
                $confirm_email = $_POST['confirm_email'];
        
                if($auth->email_verification($email) == true){
                    if($new_email == $confirm_email){
                        if($auth->password_verification($this->route['id'],$password) == true){
                            $data = ['email' => $new_email];
                            $this->model->updateUser('users',$data,$this->route['id']);
                            $key = 'success';
                            $value = 'Вы успешно изменили почту';
                            flashMessage::addFlash($key, $value); 
                            $this->view->redirect('/');
                        }
                        else{
                            $key = 'danger';
                            $value = 'Пароль введен неверно';
                            flashMessage::addFlash($key, $value); 
                        }

                    }
                    else{
                        $key = 'danger';
                        $value = 'Новая почта и ее подтверждение не совпадают';
                        flashMessage::addFlash($key, $value); 
                    }
                }
                else{
                    $key = 'danger';
                    $value = 'Не верно введена текущая почта';
                    flashMessage::addFlash($key, $value); 
                }       
            }
            else{
                $errors = $validate->validateChangeEmailForm();
            }
        }
        else{
            $key = 'info';
            $value = 'Необходимо заполнить все поля формы';
            flashMessage::addFlash($key, $value); 
        }
        
        $vars = null;
        $this->view->render('Change email', $vars, $errors);
    }

    public function searchAction(){
        dd($_POST['fcontactview']);
    }

}