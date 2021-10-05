<?php
namespace App\Controllers;
session_start();

use Database\MakePdo;
use App\Core\Controller;
use App\Core\Model;
use Models\Users;


class UsersController extends Controller {

    public function usersAction(){
        
        $users = $this->model->getUsersAll();
        $vars = $users;
        echo $_SESSION['admin'];
        $this->view->render('Users list page', $vars);
    }
    public function user_profileAction(){

        $user = $this->model->getUsersOne();
        $vars = $user;
        //dd($vars);
        $this->view->render('User profile page', $vars);
    }
    public function editAction(){
        $this->view->render('Edit user profile page');
    }
    public function mediaAction(){
        $this->view->render('Media user page');
    }
    public function statusAction(){
        $this->view->render('Status user page');
    }
    public function create_userAction(){
        $this->view->render('Create user page');
    }
}