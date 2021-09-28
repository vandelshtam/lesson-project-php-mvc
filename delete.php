<?php
include 'function.php';
$db = include 'database/start.php';
$db->delete('posts', $_GET['id']);
header('Location:/php/lessons_php/module_1/index.php');