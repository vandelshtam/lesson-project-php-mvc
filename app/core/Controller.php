<?php

namespace App\Core;

session_start();
use App\Core\View;
use App\Controllers\AuthController;

abstract class Controller{

    public $route;
    public $view;
    public $acl;

    public function __construct($route)
    {
        $this->route = $route;
        $_SESSION['admin'] = 1;
        if(!$this->checkAcl()){
            View::errorCode(403);
        }
        $this->view = new View($route);
        $this->view->layout = 'custom_auth';
        $this->model = $this->loadModel($route['controller']);

    }

    public function loadModel($name){
        $pach = 'App\Models\\'.ucfirst($name);
        if(class_exists($pach)){
            return new $pach();
        }
        //dd($pach);
    }

    public function checkAcl(){
        $this->acl = require '/Applications/MAMP/htdocs/lesson-project-php-mvc/app/acl/'.$this->route['controller'].'.php';
        //dd($_SESSION);
        if($this->isAcl('all')){
            return true;
        }
        if(isset($_SESSION['id']) && $this->isAcl('authoris')){
            return true;
        }
        if(isset($_SESSION['authoris']) && $this->isAcl('guest')){
            return true;
        }
        if(isset($_SESSION['admin']) && $this->isAcl('admin')){
            return true;
        }
        
        return false;
    }


    public function isAcl($key){
        return in_array($this->route['action'], $this->acl[$key]);
    }
}