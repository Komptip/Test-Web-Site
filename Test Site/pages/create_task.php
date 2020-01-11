<?php 
	session_start(); 
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Стартовая страница</title>
		<link rel="stylesheet" type="text/css" href="/css/start_page.css">
	</head>
	<body>
		<header>
			<a href="/" id="Main_page_button"><img src="/content/elephant.png" width="60"></a>
			<a href="/login"><button id="Login_button">Login</button></a>
		</header>
		<content>
			<?php if(isset($_SESSION['error'])): ?>
				<div class="task">
					<p style="font-size: 30px;text-align: center;"><?php echo $_SESSION['error']; ?></p>
				</div>
			<? endif; ?>
			<div class="task">
				<form action="/controller/create_task_controller.php" method="POST">
					<p style="text-align: center;font-size: 30px;">Новое задание</p>
					<p style="margin-left: 10px;font-size: 20px;">Email</p>
					<input type="email" name="email" required minlength="5" style="width: 200px;height: 20px;font-size: 15px;margin-left: 10px;" placeholder="Email@mail.com">
					<hr>
					<p style="margin-left: 10px;font-size: 20px;">Имя пользователя</p>
					<input name="username" required minlength="5" style="width: 200px;height: 20px;font-size: 15px;margin-left: 10px;" placeholder="God">
					<hr>
					<p style="margin-left: 10px;font-size: 20px;">Задача</p>
					<textarea name="text" required style="resize: none;width: 700px;height: 100px;font-size:15px;margin-left: 10px;" minlength="10" maxlength="5000"></textarea>
					<hr>
					<img src="/small_scripts/captcha.php" style="margin-left: 10px;"><br>
					<input name="captcha" required minlength="5" style="width: 200px;height: 20px;font-size: 15px;margin-left: 10px;margin-top: 5px;" placeholder="captcha">
					<hr>
					<input type="submit" value="Создать" style="width: 150px;height: 50px;margin-left: 10px;margin-top: 10px;background-color: #67C73E;border: 0;border-radius: 10px;cursor: pointer;">
				</form>
			</div>
		</content>
	</body>
</html>
<?php 
	unset($_SESSION['error']);
?>