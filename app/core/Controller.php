<?php

namespace App\Core;

use App\Core\View;
use App\Controllers\AuthController;

abstract class Controller{

    public $route;
    public $view;
    public $acl;

    public function __construct($route)
    {
        $this->route = $route;
        
        if(!$this->checkAcl()){
            View::errorCode(403);
        }
        $this->view = new View($route);
        $this->view->layout = 'default';
        $this->model = $this->loadModel($route['controller']);

    }

    public function loadModel($name){
        $pach = 'App\Models\\'.ucfirst($name);
        if(class_exists($pach)){
            return new $pach();
        }
    }

    public function checkAcl(){
        $this->acl = require '/Applications/MAMP/htdocs/lesson-project-php-mvc/app/acl/'.$this->route['controller'].'.php';
        if($this->isAcl('all')){
            return true;
        }
        if(isset($_SESSION['auth']) == true && $this->isAcl('authoris')){
            return true;
        }
        if(empty($_SESSION['auth']) && $this->isAcl('guest')){
            return true;
        }
        if(isset($_SESSION['admin']) == 1 && $this->isAcl('admin')){
            return true;
        }
        
        return false;
    }


    public function isAcl($key){
        return in_array($this->route['action'], $this->acl[$key]);
    }
}