<?php

namespace App\Core;

use App\Controllers;

class Router
{

    protected $routes = [];
    protected $params = [];

    public function __construct()
    {
        $arr = require '/Applications/MAMP/htdocs/lesson-project-php-mvc/app/config/routes.php';
        //dd($arr);
        foreach($arr as $key => $val){
            $this->add($key, $val);
        }
    }

    public function add($route, $params){
        $route = '#^'.$route.'$#';
        $this -> routes[$route] = $params;
        //dd($this->routes[$route]);
    }

    public function match(){
        $url = $_SERVER['REQUEST_URI'];
        //dd($url);

        foreach($this->routes as $route => $params){
            //var_dump($route);
            
            if(preg_match($route, $url, $matches)){
                $this -> params = $params;
                return true;
                //dd($matches);
            }
            
        }
        return false;

    }

    public function run(){
       if($this->match()){
           $pach = 'App\Controllers\\'.ucfirst($this->params['controller']).'Controller';
           if(class_exists($pach)){
               $action = $this->params['action'];
               //dd($action);
               if(method_exists($pach, $action)){
                   $controller = new $pach;
                   //dd($controller);
                   $controller->$action();
               }
               else{
                dd($action.' - not found');
               }
           }
           else{
               dd($pach.' - not found');
           }
       }
       else{
           dd(404);
       };
        //echo 'start';
    }
}