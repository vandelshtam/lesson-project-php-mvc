<?php
namespace App\Controllers;
session_start();
use App\Core\View;
use App\Core\Model;
use App\Models\Auth;
use App\Core\Controller;
use App\Models\Validator;
use App\Models\flashMessage;
use App\Models\MediaBuilder;

class AuthController extends Controller {

    

    public function __construct($route) {
		parent::__construct($route);
		$this->view->layout = 'custom_auth';
	}

    public function before(){
        $this->before();
    }

    public function page_registerAction(){
        $vars = [];
        $errors = [];
        if(!empty($_POST['email']) && !empty($_POST['password']) &&  !empty($_POST['name'])){
            
            $validation = new Validator($_POST);
            
            if( $validation->validateForm() == null){
                 
                if($this->model->isLogin('users', 'email', $_POST['email']) == true)
                {
                    flashMessage::addFlash('info', 'Не удалось зарегистрироваться, этот логин занят');
                }
                else{
                    if($this->model->registerUser('users',$_POST['name'],$_POST['email'],$_POST['password']) == true){
                        $newUserId = $this->model->newLastuserId();    
                        $dataInfos = [ 
                            'status' => 0,
                            'location' => '',
                            'phone' => '',
                            'occupation' => '',
                            'user_id' => $newUserId,
                            'infosable_id' => $newUserId   
                        ];
                        $this->model->createNewUser('infos', $dataInfos);
                        $userInfo = $this->model->getTableUser('infos','user_id',$newUserId);
                        $c = 'c_'.$newUserId;
                        $data = ['info_id' => $userInfo['id'], 'c' => $c];
                        $this->model->updateUsersTable('users',$data,$newUserId);

                        $dataSocials = [ 
                            'vk' => '',
                            'telegram' => '',
                            'instagram' => '',
                            'user_id' => $newUserId, 
                        ];
                        $this->model->createNewUser('socials', $dataSocials);
                        $userSocials = $this->model->getTableUser('socials', 'user_id', $newUserId);
                        $data = ['social_id' => $userSocials['id']];
                        $this->model->updateUsersTable('users',$data,$newUserId);
                        
                        flashMessage::addFlash('success', 'Вы успешно зарегистрировались, пожалуйста авторизуйтесь');
                        //mail( 'cee71195d6-2d2352@inbox.mailtrap.io', 'Сообщение с сайта - Вы успешно зарегистрированы', 'otto@otto');
                        //header('Location:/login');die;
                        $this->view->redirect('/login');
                    }
                    if($this->model->registerUser() == false){
                        flashMessage::addFlash('info', 'Не удалось зарегистрироваться, пожалуйста попробуйте еще раз');
                    }
                }
            }
            else{
                flashMessage::addFlash('ganger', 'Вы допустили ошибку при вводе в форму, пожалуйста попробуйте еще раз');
                $errors = $validation->validateForm();
            }    
        }
        $this->view->render('Register page',$vars, $errors);
    }

    public function page_loginAction(){

        if(isset($_POST['email']) &&  isset($_POST['password'])){
            
            if($this->model->isLogin('users','email',$_POST['email']) == false){
                flashMessage::addFlash('info', 'Такого пользователя нет! пожалуйста попробуйте еще раз');
            }
            else{
                if($this->model->loginUser('users','email',$_POST['email'],$_POST['password']) == true){

                    $user = $this->model->isUser('users','email',$_POST['email']);
                    //dd($user);
                    if($_POST['rememberme']){
                        $time = 86400;
                    }
                    else{
                        $time = 10800;
                    }
                    $this->model->set_session_auth($user['id'],$user['email'],$user['name'],$user['admin'],$time);
                    flashMessage::addFlash('success', 'Вы успешно авторизовались!');
                    $this->view->redirect('/');
                }
                else{    
                    flashMessage::addFlash('danger', 'Не удалось  авторизоваться,  пароль указан не верно, пожалуйста попробуйте еще раз');
                }
            }
        }    
        $this->view->render('Login page');
    }

    

    public function logoutAction(){
        
        $this->model->logoutUser();
        flashMessage::addFlash('info', 'Вы вышли из системы');
        $this->view->redirect('/login');
    }

    public function confirm_passwordAction(){
        if($_SESSION['admin'] != 1 ){
            if(isset($_POST['confirm_password'])){
                if($this->model->password_verification('users','id',$this->route['id'],$_POST['confirm_password']) == true){
                    $this->view->redirect('/delete/'.$this->route['id']); 
                }
                else{
                    flashMessage::addFlash('danger', 'Пароль не верный!');
                }
            }
        }
        else{
            $this->view->redirect('/delete/'.$this->route['id']); 
        }
        $this->view->render('Confirm password');
    }

    public function deleteAction(){

        $user = $this->model->isUser('users', 'id', $this->route['id']);
        if(empty($user)){
            flashMessage::addFlash('info', 'Такого пользователя нет!');
            $this->view->redirect('/');
        }

        if($_SESSION['admin'] != 1 && $_SESSION['user_id'] != $this->route['id']){
            flashMessage::addFlash('danger', 'У вас нет прав доступа!');
            $this->view->redirect('/');
        } 
        
        $info = $this->model->isUser('infos', 'id', $user['info_id']);
        unlink($info['avatar']);

        $this->model->deleteTable('users', $this->route['id']);
        $this->model->deleteTable('infos', $user['info_id']);
        $this->model->deleteTable('socials', $user['social_id']);
        flashMessage::addFlash('success', 'Вы успешно удалили аккаунт!');
        $this->view->redirect('/');
    }

    public function setAdminAction(){
        if($_SESSION['admin'] != 1 ){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/');
        } 
        $data = ['admin' => 1];
        $this->model->updateUsersTable('users',$data,$this->route['id']);
        flashMessage::addFlash('success', 'Вы успешно  изменили роль пользователя!');
        $this->view->redirect('/');
    }

    public function setUserAction(){
        if($_SESSION['admin'] != 1 ){
            flashMessage::addFlash('danger', 'У вас нет прав доступа к действию!');
            $this->view->redirect('/');
        } 
        $data = ['admin' => 0];
        $this->model->updateUsersTable('users',$data,$this->route['id']);
        flashMessage::addFlash('success', 'Вы успешно  изменили роль пользователя!');
        $this->view->redirect('/');
    }
}