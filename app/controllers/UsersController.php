<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;

class UsersController extends Controller {


    public function homeAction(){
        $this->view->render('home page');
    }

    public function userAction(){
        echo 'list profile user number 1';
       // var_dump($this->route);
    }
    public function indexAction(){
        require '/Applications/MAMP/htdocs/lesson-project-php-mvc/resources/views/home/home_page.php';
    }
}