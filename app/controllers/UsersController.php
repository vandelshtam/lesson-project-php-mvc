<?php
namespace App\Controllers;
session_start();

use Models\Users;
use App\Core\Model;
use Database\MakePdo;
use App\Core\Controller;
use App\Models\Validator;
use App\Models\flashMessage;


class UsersController extends Controller {

    public function usersAction(){
        
        $vars = $this->model->getUsersAll();
        //mail( 'mvlju977@gmail.com', 'Сообщение с сайта - Вы успешно зарегистрированы', 'otto@otto');
        //mail('mvlju977@gmail.com', 'the subject', 'the message');

        $this->view->render('Users list page', $vars);
    }


    public function user_profileAction(){
        
		$user_id = $this->route['id'];
        $vars = $this->model->getUsersOne($user_id);
        $this->view->render('User profile page', $vars);
    }


    public function editAction(){
        if($this->route['id'] == false){
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

        if(isset($_POST['name']) || isset($_POST['occupation']) || isset($_POST['phone']) || isset($_POST['location'])){

            $validation = new Validator($_POST);

            if( $validation->validateEditForm() == null){
                
                $data = [
                    'occupation' => $_POST['occupation'],
                    'location' => $_POST['location'],
                    'phone' => $_POST['phone']
                ];
                $table = 'infos';
                $this->model->updateUser($table,$data,$user_id);

                $data_users = [
                    'name' => $_POST['name']
                ];
                $table_users = 'users';
                $this->model->updateUser($table_users,$data_users,$user_id);

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
        /*
        else{
            $key = 'info';
            $value = 'Вы не заполнили форму редактирования, нажмите "редактировать" еще раз чтобы выйти из формы без изменений';
            flashMessage::addFlash($key, $value);
            if(empty($_POST['name']) && empty($_POST['occupation']) && empty($_POST['phone']) && empty($_POST['location']) && isset($_POST['submit'])){
                $key = 'info';
                $value = 'Вы не внесли изменений';
                flashMessage::addFlash($key, $value);
                $this->view->redirect('/');
            }
            
        }*/
        
        }
        $this->view->render('Edit user profile page', $vars, $errors);
    }


    public function mediaAction(){
        $this->view->render('Media user page');
    }


    public function statusShowAction(){

        $user_id = $this->route['id'];
        $table = 'infos';
        
        $users = $this->model->getOneData($table,$user_id);
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

        $user_id = $this->route['id'];
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
        $this->model->updateUser($table,$data,$user_id);
        $key = 'success';
        $value = 'Вы успешно изменили статус';
        flashMessage::addFlash($key, $value);
        $this->view->redirect('/');
    }


    public function create_userAction(){
        
        if($_SESSION['admin'] != 1 ){
            $key = 'danger';
            $value = 'У вас нет прав доступа к действию!';
            flashMessage::addFlash($key, $value);
            $this->view->redirect('/');
        } 


        if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password'])){

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
                        'name' => $_POST['name'],
                        'email' => $_POST['email'],
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
                
                $data = ['infos_id' => $lastInfosId];
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
                
                $data = ['socials_id' => $lastSocialsId];
                $this->model->updateUser($tableUsers,$data,$newUserId);    

                
                if(!empty($_POST['location']) || !empty($_POST['occupation']) || !empty($_POST['phone']) || isset($_POST['status'])){
                    $list_statuses_set=[ 'онлайн' => 0,  'не беспокоить' => 1,  'отошел' => 2];
                    $status_key = $list_statuses_set[$_POST['status']];
                    //dd($status_key);
                    $dataInfos = [ 
                            'status' => $status_key,
                            'location' => $_POST['location'],
                            'phone' => $_POST['phone'],
                            'occupation' => $_POST['occupation'],
                            'user_id' => $newUserId,
                            'infosable_id' => $newUserId   
                        ];
                    $tableInfos = 'infos';
                    //dd($lastInfosId);
                    $this->model->updateUser($table,$dataInfos,$lastInfosId);
                    
                }
                
                if(!empty($_POST['vk']) || !empty($_POST['telegram']) || !empty($_POST['instagram'])){

                    $dataSocials = [ 
                            'vk' => $_POST['vk'],
                            'telegram' => $_POST['telegram'],
                            'instagram' => $_POST['instagram'],
                            'user_id' => $newUserId, 
                        ];
                    $tableSocials = 'socials';
                    $data = ['socials_id' => $lastSocialsId];
                    $this->model->updateUser($tableSocials,$dataSocials,$newUserId);        
                }
                /*
                if(isset($_POST['avatar'])){
                
                    $direct='/Applications/MAMP/htdocs/module_2_training_project/public/uploads/';
                    $image_name=$_FILES['avatar']['name'];
                    $image_name_tmp=$_FILES['avatar']['tmp_name'];
                    $new_avatar='/lesson-project-php-mvc/public/uploads/'.$image_name;
                    $this->model->loadingFileAvatar($image_name_tmp,$direct,$image_name);
                    $data = ['avatar' => $new_avatar];
                    $table = 'infos';
                    $this->model->updateAvatar($table,$data,$lastInfosId);   
                }
                */
                $key = 'success';
                $value = 'Вы успешно добавили нового пользователя';
                flashMessage::addFlash($key, $value); 
                $this->view->redirect('/');   
            }
        }
        else{
            $key = 'info';
            $value = 'Нужно обязательно заполнить 3 поля: "name", "email", "password"';
            flashMessage::addFlash($key, $value);    
        }
        $this->view->render('Create user page');
    }


    public function create_user_setAction(){
        
        if($_SESSION['admin'] != 1 ){
            $key = 'danger';
            $value = 'У вас нет прав доступа к действию!';
            flashMessage::addFlash($key, $value);
            $this->view->redirect('/');
        } 

        $email=$_POST['email'];
        $password = $_POST['password'];
        $tableUser = 'users';
        $name = $_POST['name'];

        $user = $this->db->getUserOnTable($table, $email);

        if(!empty($user))
        {
            $key = 'info';
            $value = 'Не возможно добавить пользователя, этот логин занят';
            flashMessage::addFlash($key, $value);    
        }


        $list_statuses_set=[ 'онлайн' => 0,  'не беспокоить' => 1,  'отошел' => 2];
        $status_key = $list_statuses_set[$_POST['status']];
        $passwordNewUser = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $dataUser = [ 
                
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => $_POST['passwordNewuser'],  
            ];

        $this->model->createUser($tableUser, $dataUser);
        $newUserId =  $this->model->newUserId(); 

        $dataInfos = [ 
                'status' => $status_key,
                'location' => $_POST['city'],
                'phone' => $_POST['phone'],
                'occupation' => $_POST['occupation'],
                'user_id' => $newUserId,
                'infosable_id' => $newUserId   
            ];
        $dataSocials = [ 
                
                'vk' => $_POST['vk'],
                'telegram' => $_POST['telegram'],
                'instagram' => $_POST['instagram'],
                'user_id' => $newUserId,
                'infosable_id' => $newUserId   
            ];
            
        $this->qb->update($data, $userId,'users');

            $direct='/Applications/MAMP/htdocs/php/lessons_php/module_2/module_2_training_project/app/views/img/demo/avatars/';
        
            $image_name=$_FILES['avatar']['name'];
            $image_name_tmp=$_FILES['avatar']['tmp_name'];
            $new_avatar='/php/lessons_php/module_2/module_2_training_project/app/views/img/demo/avatars/'.$image_name;
            $data = ['avatar' => $new_avatar];

        $this->view->render('Create user page');
    }

}