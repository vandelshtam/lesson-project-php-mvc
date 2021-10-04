<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Core\Model;
use App\Models\Auth;
use App\Models\Validator;

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
                    header('Location:/login');
                }
                else{
                    echo 'у вас  не  получилось зарегистрироваться, попробуйте еще раз';
                }
            }
            else{
                $errors = $validation->validateForm();
            }    
        }
        $this->view->render('Register page',$vars, $errors);
    }

    public function page_loginAction(){
        if(isset($_POST['email']) &&  isset($_POST['password'])){
            if($this->model->loginUser() == true){
                header('Location:/');
            }
            else{
                echo 'попробуйте еще раз';
            }    
        }    
        $this->view->render('Login page');
    }

    public function securityAction(){
        $this->view->render('Security user page');
    }
}