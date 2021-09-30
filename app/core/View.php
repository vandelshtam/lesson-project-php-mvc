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
        //dd($this->pach);
    }

    public function render($title, $vars = []){
        
        ob_start();
        require '/Applications/MAMP/htdocs/lesson-project-php-mvc/resources/views/'.$this->pach.'.php';
        $content = ob_get_clean();
        
        require '/Applications/MAMP/htdocs/lesson-project-php-mvc/resources/layouts/'.$this->layout.'.php';
    }

}