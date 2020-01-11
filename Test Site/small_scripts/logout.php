<?php 
	setcookie('auth', ' ', time() + 3600, "/");
	header('Location: http://' . htmlentities($_SERVER['HTTP_HOST']));
	exit();
?>