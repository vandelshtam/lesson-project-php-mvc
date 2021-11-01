<?php

namespace App\Core;

use App\Controllers;
use App\Core\View;

class Router
{

    protected $routes = [];
    protected $params = [];

    public function __construct()
    {
        $arr = require '/Applications/MAMP/htdocs/lesson-project-php-mvc/app/config/routes.php';
        foreach($arr as $key => $val){
            $this->add($key, $val);
        }
        
    }

    public function add($route, $params){
        $route = preg_replace('/{([a-z]+):([^\}]+)}/', '(?P<\1>\2)', $route);
        $route = '#^'.$route.'$#';
        $this ->routes[$route] = $params;
       
    }

    public function matche(){
        $url = $_SERVER['REQUEST_URI'];
        foreach($this->routes as $route => $params){    
            if(preg_match($route, $url, $matches)){
                $this -> params = $params;
                return true;
            }    
        }
        return false;
    }

    public function match() {
            $url = $_SERVER['REQUEST_URI'];
            foreach ($this->routes as $route => $params) {
             
                if (preg_match($route, $url, $matches)) {
                    foreach ($matches as $key => $match) {
                        if (is_string($key)) {
                            if (is_numeric($match)) {
                                $match = (int) $match;
                            }
                            $params[$key] = $match;
                        }
                    }
                    $this->params = $params;
                    
                    return true;
                }
            }
            return false;
        }
    public function run(){
       if($this->match()){
           $pach = 'App\Controllers\\'.ucfirst($this->params['controller']).'Controller';
           
           if(class_exists($pach)){
               $action = $this->params['action'].'Action';
               
               if(method_exists($pach, $action)){
                   $controller = new $pach($this->params);
                   
                   $controller->$action();
               }
               else{
                View::errorCode(404);
                dd($action.' - not found');
               }
           }
           else{
               View::errorCode(404);
               dd($pach.' - not found');
           }
       }
       else{
           View::errorCode(404);
           dd(404);
       }
    }

    

    public function runes(){
        if ($this->match()) {
            $path = 'App\Controllers\\'.ucfirst($this->params['controller']).'Controller';
            
            if (class_exists($path)) {
                $action = $this->params['action'].'Action';
                
                if (method_exists($path, $action)) {
                    $controller = new $path($this->params);
                    $controller->$action();
                } else {
                    View::errorCode(404);
                }
            } else {
                View::errorCode(404);
            }
        } else {
            View::errorCode(404);
        }
    }


}