<?php
	include("../models/login_model.php");
	if($_POST['login'] == 'admin' && $_POST['password'] == '123'){
		LoginUser("admin", "123");
		header('Location: http://' . htmlentities($_SERVER['HTTP_HOST']));
		exit();
	} else {
		session_start();
		$_SESSION['login_error'] = 'Invalid data';
		require("../pages/login.php");
		exit();
	}
?>