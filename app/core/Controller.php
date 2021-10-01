<?php
namespace App\Core;


use App\Core\View;
use App\Controllers\AuthController;

abstract class Controller{

    public $route;
    public $view;

    public function __construct($route)
    {
        $this->route = $route;
        $this->view = new View($route);
        $this->view->layout = 'custom_auth';
    }

}