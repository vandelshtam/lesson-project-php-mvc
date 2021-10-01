<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;

class AuthController extends Controller {

    public function before(){
        $this->before();
    }

    public function page_registerAction(){
        $this->view->render('Register page');
    }

    public function page_loginAction(){
        //$this->view->redirect('/register');
        $this->view->render('Login page');
    }
    public function securityAction(){
        $this->view->render('Security user page');
    }
}