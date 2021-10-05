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

    public function before(){
        $this->before();
    }

    public function page_registerAction(){
        $vars = [];
        $errors = [];
        if(isset($_POST['email']) && isset($_POST['password']) &&  isset($_POST['name'])){
            $validation = new Validator($_POST);
            
            if( $validation->validateForm() == null){
                if($this->model->registerUser() == true){
                    $flash = new flashMessage();
                    $key = 'success';
                    $value = 'Вы успешно зарегистрировались, пожалуйста авторизуйтесь';
                    $flashMessage = $flash->addFlash($key, $value);
                    header('Location:/login');die;
                }
                if($this->model->registerUser() == false){
                    $flash = new flashMessage();
                    $key = 'info';
                    $value = 'Не удалось зарегистрироваться, пожалуйста попробуйте еще раз';
                    $flashMessage = $flash->addFlash($key, $value);
                }
                if($this->model->registerUser() == $flashMessage){
                    $flashMessage;
                }
            }
            else{
                $flash = new flashMessage();
                $key = 'ganger';
                $value = 'Вы допустили ошибку при вводе в форму, пожалуйста попробуйте еще раз';
                $flashMessage = $flash->addFlash($key, $value);
                $errors = $validation->validateForm();
            }    
        }
        $this->view->render('Register page',$vars, $errors);
    }

    public function page_loginAction(){
        if(isset($_POST['email']) &&  isset($_POST['password'])){
            if($this->model->loginUser() == true){
                $user = $this->model->loginUser();
                //dd($user);
                $user_id = $user['id'];
                $email = $user['email'];
                $name = $user['name'];
                $admin = $user['admin'];
                $this->model->set_session_auth($user_id,$email,$name,$admin);
                //dd($_SESSION['admin']);
                $flash = new flashMessage();
                $key = 'success';
                $value = 'Вы успешно авторизовались!';
                $flashMessage = $flash->addFlash($key, $value);
                header('Location:/');die;
            }
            if($this->model->loginUser() == false){
                $flash = new flashMessage();
                $key = 'danger';
                $value = 'Не удалось  авторизоваться, пожалуйста попробуйте еще раз';
                $flashMessage = $flash->addFlash($key, $value);
            }
            if($this->model->loginUser() == $flashMessage){
                
                $flashMessage;
            }        
        }    
        $this->view->render('Login page');
    }

    public function securityAction(){
        $this->view->render('Security user page');
    }

    public function logoutAction(){
        
        $this->model->logoutUser();
        //session_destroy();
        $flash = new flashMessage();
        $key = 'info';
        $value = 'Вы вышли из системы';
        $flashMessage = $flash->addFlash($key, $value);
        header('Location:/register');die;   
    }
}