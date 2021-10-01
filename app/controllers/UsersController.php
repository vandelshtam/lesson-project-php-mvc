<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;

class UsersController extends Controller {


    public function usersAction(){
        $vars = ['name' => 'Otto',
                  'occupation' => 'menager'];
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