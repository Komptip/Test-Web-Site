<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Вход</title>
	<link rel="stylesheet" type="text/css" href="/css/start_page.css">
</head>
	<body>
		<div class="task">
			<form action="/controller/login_controller.php" method="POST">
				<p style="font-size: 25px;text-align: center;">Логин</p>
				<hr>
				<p style="margin-left: 15px;font-size: 20px;">Логин</p>
				<input type="text" name="login" style="margin-left: 15px;width: 300px;height: 20px;font-size: 18px;">
				<hr>
				<p style="margin-left: 15px;font-size: 20px;">Пароль</p>
				<input type="password" name="password" style="margin-left: 15px;width: 300px;height: 20px;font-size: 18px;">
				<hr>
				<input type="submit" name="" value="Login" style="width: 150px;height: 50px;margin-left: 15px;border: 0; background-color: #67C73E;border-radius: 15px;font-size: 15px;cursor: pointer;outline: none;">
			</form>
		</div>
		<?php if(isset($_SESSION['login_error'])): ?>
			<div class="task">
				<p style="font-size: 20px;text-align: center;color:red;"><?php echo $_SESSION['login_error'];?></p>
			</div>
		<?php endif;?>
		<?php unset($_SESSION['login_error']);?>
	</body>
</html>