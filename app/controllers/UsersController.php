<?php
namespace App\Controllers;


use Database\MakePdo;
use App\Core\Controller;


class UsersController extends Controller {

    public function usersAction(){
           
        $db = MakePdo::query();
        $users = $db->getAll('users');
        $vars = $users;
        
        //dd($vars);
        
        $this->view->render('Users list page', $vars);
    }
    public function user_profileAction(){
        $this->view->render('User profile page');
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