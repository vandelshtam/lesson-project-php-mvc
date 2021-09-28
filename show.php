<?php
include 'function.php';
$db = include 'database/start.php';

$post = $db->getOne('posts', $_GET['id']);

?>

<h2><?php echo $post['title'];?></h2>