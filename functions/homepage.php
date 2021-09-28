<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
echo 'homepage';
$db = include '/Applications/MAMP/htdocs/lesson-project-php-mvc/database/start.php';



$posts = $db->getAll('posts');

include '/Applications/MAMP/htdocs/lesson-project-php-mvc/index_view.php';