<?php 
	include("../models/tasks_model.php");
	include("../small_scripts/db.php");
	# Валидна ли капча
	if(IsCaptchaValid()){
		#Если да - чистим вводимые данные от спец. Символов и закидываем в БД
		$safe_email = ProtectMySQLInjectAndXSS($_POST['email']);
		$safe_username = ProtectMySQLInjectAndXSS($_POST['username']);
		$safe_text = ProtectMySQLInjectAndXSS($_POST['text']);
		mysqli_query($connection, "INSERT INTO `tasks` (`email`, `username`, `text`) VALUES ('$safe_email', '$safe_username', '$safe_text')");
		require("../pages/start_page.php");
		exit();
	} else {
		# Если нет - провожаем пользователя обратно с ошибкой.
		session_start();
		$_SESSION['error'] = 'Invalid captcha';
		file_put_contents("test.txt", $_SESSION['error']);
		require("../pages/create_task.php");
		exit();
	}
?>