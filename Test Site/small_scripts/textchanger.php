<?php 
	include("../models/tasks_model.php");
	include("../models/login_model.php");
	include("db.php");
	if(AuthUser()){
		$taskid = $_POST['id'];
		$safe_text = ProtectMySQLInjectAndXSS($_POST['text']);
		mysqli_query($connection, "UPDATE `tasks` SET `text`='$safe_text', `changedbyadmin`='Yes' WHERE `id` = '$taskid'");
		header('Location: http://' . htmlentities($_SERVER['HTTP_HOST']));
		exit();
	} else {
		echo 'Отказано в доступе';
	}
?>