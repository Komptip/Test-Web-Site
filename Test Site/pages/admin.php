<?php 
	# Подключение к базе данных
	$connection = mysqli_connect('127.0.0.1', 'root', '', 'testdb');
	# Запрос ко всему столбцу, для того, что бы понять, сколько страниц рисовать.
	$all_pages_count = mysqli_query($connection, "SELECT * FROM `tasks`");
	# Достаем номер страницы из метода POST
	$page_now = $_POST['page_number'];
	# Если он не присвоен (Пользователь впервые на странице и ещё не менял страницы пагинации), то, тогда устанавливаем 1.
	if(!isset($page_now)){
		$page_now = 1;
	}
	# Если страница один - берем первые 3 задачи, если станица другая - все равно 3, но уже пропускаем перед этим нужное количество заданий.
	if($page_now == 1)
	{	
		$db_result = mysqli_query($connection, "SELECT * FROM `tasks` ORDER BY `id` DESC LIMIT 3");
	} else {
		$db_result = mysqli_query($connection, "SELECT * FROM `tasks` ORDER BY `id` DESC LIMIT " . ($page_now - 1) * 3 . ",3");
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
			<a href="/login"><button id="Login_button">Out</button></a>
		</header>
		<content>

			<!-- Цикл создания заданий -->
			
			<?php foreach(range(1, mysqli_num_rows($db_result)) as $currect_task): ?>
				<?php if($mysql_array['text'] != ''):?>
					<?php $mysql_array = mysqli_fetch_assoc($db_result); ?>
					<div class="task">
						<p class="email">Username: <?php echo $mysql_array['username']; ?></p>
						<hr>
						<p class="status">Email: <?php echo $mysql_array['email']; ?></p>
						<hr>
						<div class="task_text_width_fix">
							<p class="task_text">Задача: <?php echo htmlspecialchars_decode($mysql_array['text']); ?></p>
						</div>
						<form action="/small_scripts/taskconfimer.php" method="POST">
							<input type="hidden" name="id" value="<?php echo $mysql_array['id']; ?>">
							<input type="submit" value="Сделать выполненым" style="width: 300px;height: 50px;border: 0; border-radius: 5px;background-color: #F37D7B;margin-left: 15px;cursor: pointer;margin-bottom: 15px;">
						</form>
						<form action="/small_scripts/taskremover.php" method="POST">
							<input type="hidden" name="id" value="<?php echo $mysql_array['id']; ?>">
							<input type="submit" value="Удалить" style="width: 300px;height: 50px;border: 0; border-radius: 5px;background-color: #F37D7B;margin-left: 15px;cursor: pointer;">
						</form>
						<form action="/small_scripts/textchanger.php" method="POST">
							<input type="hidden" name="id" value="<?php echo $mysql_array['id']; ?>">
							<textarea style="width: 300px;height: 100px;resize: none;outline: none;margin-left: 15px;margin-top: 15px;" name="text"><?php echo htmlspecialchars_decode($mysql_array['text']); ?></textarea>
							<br>
							<input type="submit" value="Изменить текст" style="width: 300px;height: 50px;border: 0; border-radius: 5px;background-color: #F37D7B;margin-left: 15px;cursor: pointer;">
						</form>
						<hr>
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
				<? endif; ?>
			<?php endforeach; ?>
		</content>
		<div class="pagination" >
			<form action="/pages/admin.php" method="POST">

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