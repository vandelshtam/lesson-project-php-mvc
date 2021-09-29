<?php
echo 'homepage';
$db = include '/Applications/MAMP/htdocs/lesson-project-php-mvc/database/start.php';



$posts = $db->getAll('posts');

include '/Applications/MAMP/htdocs/lesson-project-php-mvc/index_view.php';