<?php 
	# Подключение к базе данных
	$connection = mysqli_connect('localhost', 'my_user', 'my_password', 'database');
	# Запрос ко всему столбцу, для того, что бы понять, сколько страниц рисовать.
	if(isset($_POST['filter_by_username']))
	{
		$username_for_filter = $_POST['filter_by_username'];
		$all_pages_count = mysqli_query($connection, "SELECT * FROM `tasks` WHERE `username` = '$username_for_filter'");
	}
	if(isset($_POST['filter_by_email']))
	{
		$email_for_filter = $_POST['filter_by_email'];
		$all_pages_count = mysqli_query($connection, "SELECT * FROM `tasks` WHERE `email` = '$email_for_filter'");
	}
	if(isset($_POST['status_filter']))
	{
		$all_pages_count = mysqli_query($connection, "SELECT * FROM `tasks` WHERE `status` = 'Confimed'");
	} 
	if(!isset($_POST['status_filter']) && !isset($_POST['filter_by_email']) && !isset($_POST['filter_by_username'])) {
		$all_pages_count = mysqli_query($connection, "SELECT * FROM `tasks`");
	}
	
	# Достаем номер страницы из метода POST
	$page_now = $_POST['page_number'];
	# Если он не присвоен (Пользователь впервые на странице и ещё не менял страницы пагинации), то, тогда устанавливаем 1.
	if(!isset($page_now)){
		$page_now = 1;
	}
	# Если страница один - берем первые 3 задачи, если станица другая - все равно 3, но уже пропускаем перед этим нужное количество заданий.
	if(isset($_POST['filter_by_username']))
	{
		if($page_now == 1)
		{	
			$db_result = mysqli_query($connection, "SELECT * FROM `tasks` WHERE `username` = '$username_for_filter' ORDER BY `id` DESC LIMIT 3");
		} else {
			$db_result = mysqli_query($connection, "SELECT * FROM `tasks` WHERE `username` = '$username_for_filter' ORDER BY `id` DESC LIMIT " . ($page_now - 1) * 3 . ",3 ");
		}
	}
	if(isset($_POST['filter_by_email']))
	{
		if($page_now == 1)
		{	
			$db_result = mysqli_query($connection, "SELECT * FROM `tasks` WHERE `email` = '$email_for_filter' ORDER BY `id` DESC LIMIT 3");
		} else {
			$db_result = mysqli_query($connection, "SELECT * FROM `tasks` WHERE `email` = '$email_for_filter' ORDER BY `id` DESC LIMIT " . ($page_now - 1) * 3 . ",3 ");
		}
	}
	if(isset($_POST['status_filter']))
	{
		if($page_now == 1)
		{	
			$db_result = mysqli_query($connection, "SELECT * FROM `tasks` WHERE `status` = 'Confimed' ORDER BY `id` DESC LIMIT 3");
		} else {
			$db_result = mysqli_query($connection, "SELECT * FROM `tasks` WHERE `status` = 'Confimed' ORDER BY `id` DESC LIMIT " . ($page_now - 1) * 3 . ",3 ");
		}
	} 
	if(!isset($_POST['status_filter']) && !isset($_POST['filter_by_email']) && !isset($_POST['filter_by_username'])){
		if($page_now == 1)
		{	
			$db_result = mysqli_query($connection, "SELECT * FROM `tasks` ORDER BY `id` DESC LIMIT 3");
		} else {
			$db_result = mysqli_query($connection, "SELECT * FROM `tasks` ORDER BY `id` DESC LIMIT " . ($page_now - 1) * 3 . ",3");
		}
	}
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
			<a href="/create_task"><button id="Button_new_task"><p style="font-size: 20px;">Новое задание</p></button></a>

			<!-- Цикл создания заданий -->
			<div class="task">
				<p style="font-size: 25px;text-align: center;">Фильтр</p>
				<form action="/pages/start_page.php" method="POST">
					<hr>
					<p style="font-size: 18px;margin-left: 15px;">По имени пользователя</p>
					<input type="text" name="filter_by_username" style="width: 150px;height: 20px;font-size: 18px;margin-left: 15px;">
					<br>
					<input type="submit" name="go" value="Применить" style="width: 150px;margin-left: 15px;margin-top: 10px;">
				</form>
				<hr>
				<form action="/pages/start_page.php" method="POST">
					<p style="font-size: 18px;margin-left: 15px;">По email</p>
					<input type="text" name="filter_by_email" style="width: 150px;height: 20px;font-size: 18px;margin-left: 15px;">
					<br>
					<input type="submit" name="go" value="Применить" style="width: 150px;margin-left: 15px;margin-top: 10px;">
				</form>
				<hr>
				<form action="/pages/start_page.php" method="POST">
					<p style="font-size: 18px;margin-left: 15px;">По статусу</p>
					<select style="margin-left: 15px;" name="status_filter">
						<option value="No">Не указано</option>
						<option value="Confimed">Выполнен</option>
					</select>
					<br>
					<input type="submit" name="go" value="Применить" style="width: 150px;margin-left: 15px;margin-top: 10px;">
				</form>
			</div>

			<?php foreach(range(1, mysqli_num_rows($db_result)) as $currect_task): ?>
				<?php $mysql_array = mysqli_fetch_assoc($db_result); ?>
					<?php if($mysql_array['text'] != ''):?>
						<div class="task">
							<p class="email">Username: <?php echo $mysql_array['username']; ?></p>
							<hr>
							<p class="status">Email: <?php echo $mysql_array['email']; ?></p>
							<hr>
							<div class="task_text_width_fix">
								<p class="task_text">Задача: <?php echo htmlspecialchars_decode($mysql_array['text']); ?></p>
							</div>
							<?php if($mysql_array['changedbyadmin'] == 'Yes'): ?>
								<div style="width: 300px;height: 50px;border: 0; border-radius: 5px;background-color: #F37D7B;margin-left: 15px;">
									<p style="font-size: 20px;text-align: center;">Отредактировано администратором</p>
								</div>
							<?php endif; ?>
							<?php if($mysql_array['status'] == 'Confimed'): ?>
								<div style="width: 300px;height: 50px;border: 0; border-radius: 5px;background-color: #AAF7B4;margin-left: 15px;">
									<p style="font-size: 20px;text-align: center;">Выполнено</p>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
			<?php endforeach; ?>
		</content>
		<div class="pagination" >
			<form action="/pages/start_page.php" method="POST">

				<!-- Цикл пагинации -->

				<?php foreach(range(1, ceil(mysqli_num_rows($all_pages_count) / 3)) as $currect_page): ?>
					
					<?php if($currect_page == $page_now): ?>
					
						<input type="submit" class="pagination_button" value="<?php echo $currect_page; ?>" name="page_number" style="background-color: #B1FF9C;">
					
					<?php endif; ?>
					
					<?php if($currect_page != $page_now && $currect_page != 0): ?>

						<input type="submit" class="pagination_button" value="<?php echo $currect_page; ?>" name="page_number">
					
					<?php endif; ?>
				<?php endforeach; ?>	
			</form>
		</div>
	</body>
</html>