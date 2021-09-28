<?php
include 'function.php';
$db = include 'database/start.php';

$db->update('posts', $_POST, $_GET['id']);
header('Location:/php/lessons_php/module_1/index.php');