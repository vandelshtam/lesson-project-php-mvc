<?php
namespace App\Core;

class View{

    public $pach;
    public $layout = 'default';
    public $route;
    
    public function __construct($route)
    {
        $this->route = $route;
        $this->pach = $route['controller'].'/'.$route['action'];
    }

    public function render($title, $vars = [], $errors = []){
        extract($vars);
        extract($errors);
        $pach = '/Applications/MAMP/htdocs/lesson-project-php-mvc/resources/views/'.$this->pach.'.php';
        if(file_exists($pach)){
            ob_start();
            require $pach;
            $content = ob_get_clean();
            require '/Applications/MAMP/htdocs/lesson-project-php-mvc/resources/layouts/'.$this->layout.'.php';
        }
        else{
            $this->errorCode(404);
            dd($this->pach.' - not found');
        }
    }

    public function redirect($url){
        header ('location:'.$url);
        exit;
    }

    static function errorCode($code){
        http_response_code($code);
        $pach = '/Applications/MAMP/htdocs/lesson-project-php-mvc/resources/views/errors/'.$code.'.php'; 
        if(file_exists($pach)){
            require $pach;    
        }
        exit;
    }

    

}