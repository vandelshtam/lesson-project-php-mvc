<?php
include 'function.php';
$db = include 'database/start.php';
$db->create('posts',
            ['title' => $_POST['title']]);
header('Location:/php/lessons_php/module_1/index.php');