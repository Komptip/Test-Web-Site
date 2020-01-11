<?php 
	include("models/login_model.php");
	#Проверяет URL, по которому перешёл юзер и думает, что с ним делать.
	if($_SERVER['REQUEST_URI'] == "/"){
		if(AuthUser()){
			require("pages/admin.php");
		} else {
			require("pages/start_page.php");
		}
		exit();
	} 
	if(strtolower($_SERVER['REQUEST_URI']) == "/create_task"){
		require("pages/create_task.php");
		exit();
	} 
	if(strtolower($_SERVER['REQUEST_URI']) == "/login"){
		if(AuthUser()){
			require("small_scripts/logout.php");
		} else {
			require("pages/login.php");
		}
		exit();
	} 
	else {
		require("pages/404.php");
		exit();
	}
?>