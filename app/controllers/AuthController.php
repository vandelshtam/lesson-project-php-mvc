<?php
namespace App\Controllers;
session_start();
use App\Core\View;
use App\Core\Model;
use App\Models\Auth;
use App\Core\Controller;
use App\Models\Validator;
use App\Models\flashMessage;

class AuthController extends Controller {

    

    public function __construct($route) {
		parent::__construct($route);
		$this->view->layout = 'custom_auth';
	}

    public function before(){
        $this->before();
    }

    public function page_registerAction(){

$errors = [];
        if(!empty($_POST['email']) && !empty($_POST['password']) &&  !empty($_POST['name'])){
            
            $validation = new Validator($_POST);
            
            if( $validation->validateForm() == null){
                 
                $email=$_POST['email'];
                $password = $_POST['password'];
                $table = 'users';
                $value = $_POST['email'];
                $param = 'email';
                $name = $_POST['name'];
                $user = $this->model->isUser($table, $param, $value);
                if(!empty($user))
                {
                    $key = 'info';
                    $value = 'Не удалось зарегистрироваться, этот логин занят';
                    flashMessage::addFlash($key, $value);
                }
                else{
                    if($this->model->registerUser($table,$name,$email) == true){
                        $newUserId = $this->model->newLastuserId();
                        //dd($newUserId);
                        
                        $dataInfos = [ 
                            'status' => 0,
                            'location' => '',
                            'phone' => '',
                            'occupation' => '',
                            'user_id' => $newUserId,
                            'infosable_id' => $newUserId   
                        ];
                        $tableInfos = 'infos';
                        $tableUsers = 'users';
                        $tableSocials = 'socials';
                        $this->model->createNewUser($tableInfos, $dataInfos);
                        $userInfo = $this->model->getTableUser($tableInfos,$newUserId);
                        $lastInfosId = $userInfo['id'];
                        $data = ['info_id' => $lastInfosId];
                        $this->model->updateUsersTable($tableUsers,$data,$newUserId);

                        $dataSocials = [ 
                            'vk' => '',
                            'telegram' => '',
                            'instagram' => '',
                            'user_id' => $newUserId, 
                        ];
                        $this->model->createNewUser($tableSocials, $dataSocials);
                        $userSocials = $this->model->getTableUser($tableSocials,$newUserId);
                        $lastSocialsId = $userSocials['id'];
                        $data = ['social_id' => $lastSocialsId];
                        $this->model->updateUsersTable($tableUsers,$data,$newUserId);


                        $key = 'success';
                        $value = 'Вы успешно зарегистрировались, пожалуйста авторизуйтесь';
                        flashMessage::addFlash($key, $value);
                        //mail( 'cee71195d6-2d2352@inbox.mailtrap.io', 'Сообщение с сайта - Вы успешно зарегистрированы', 'otto@otto');
                        //header('Location:/login');die;
                        $this->view->redirect('/login');
                    }
                    if($this->model->registerUser() == false){
                        $key = 'info';
                        $value = 'Не удалось зарегистрироваться, пожалуйста попробуйте еще раз';
                        $flashMessage = flashMessage::addFlash($key, $value);
                    }
                }
            }
            else{
                $key = 'ganger';
                $value = 'Вы допустили ошибку при вводе в форму, пожалуйста попробуйте еще раз';
                $flashMessage = flashMessage::addFlash($key, $value);
                $errors = $validation->validateForm();
            }    
        }
        $vars = [];
        //$errors = [];
        //$key = 'info';
        //$value = 'Пожалуйста зарегистрируйтесь';
        //flashMessage::addFlash($key, $value);
        $this->view->render('Register page',$vars, $errors);
    }

    public function page_loginAction(){

        if(isset($_POST['email']) &&  isset($_POST['password'])){
            if($this->model->loginUser() == true){

                $user = $this->model->loginUser();
                $user_id = $user['id'];
                $email = $user['email'];
                $name = $user['name'];
                $admin = $user['admin'];
                $this->model->set_session_auth($user_id,$email,$name,$admin);
                $key = 'success';
                $value = 'Вы успешно авторизовались!';
                flashMessage::addFlash($key, $value);
                $this->view->redirect('/');
            }
            if($this->model->loginUser() == false){    
                $key = 'danger';
                $value = 'Не удалось  авторизоваться,  пароль указан не верно, пожалуйста попробуйте еще раз';
                flashMessage::addFlash($key, $value);
            }
            /*
            if($this->model->loginUser() == null){    
                $key = 'info';
                $value = 'Такого пользователя нет! пожалуйста попробуйте еще раз';
                flashMessage::addFlash($key, $value);
                
            } */       
        }    
        $this->view->render('Login page');
    }

    public function securityAction(){
        $this->view->render('Security user page');
    }

    public function logoutAction(){
        
        $this->model->logoutUser();
        $key = 'info';
        $value = 'Вы вышли из системы';
        flashMessage::addFlash($key, $value);
        $this->view->redirect('/login');
    }
}