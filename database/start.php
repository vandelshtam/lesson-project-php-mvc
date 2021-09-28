<?php
$config = include '/Applications/MAMP/htdocs/lesson-project-php-mvc/database/config.php';
include '/Applications/MAMP/htdocs/lesson-project-php-mvc/database/QueryBuilder.php';
include '/Applications/MAMP/htdocs/lesson-project-php-mvc/database/Connection.php';

return new QueryBuilder(Connection::make($config['database']));