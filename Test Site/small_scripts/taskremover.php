<?php 
	include("../models/login_model.php");
	include("db.php");
	if(AuthUser()){
		$taskid = $_POST['id'];
		mysqli_query($connection, "DELETE FROM `tasks` WHERE `id` = '$taskid'");
		header('Location: http://' . htmlentities($_SERVER['HTTP_HOST']));
		exit();
	} else {
		echo 'Отказано в доступе';
	}
?>