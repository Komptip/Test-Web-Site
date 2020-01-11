<?php 
	$connection = mysqli_connect('localhost', 'my_user', 'my_password', 'database');
	if($connection == false){
		echo ('Ошибка подключения: ' + mysqli_connect_error());
		exit();
	}
?>