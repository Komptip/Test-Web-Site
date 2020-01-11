<?php
	# Генератор случайной строки
	function generateRandomString($length) {
	    $characters = '123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
	# Записываем в SESSION зашифрованную капчу и создаем изображение.
	session_start();
	$string_for_captcha = generateRandomString(10);
	$_SESSION['captcha'] = password_hash($string_for_captcha, PASSWORD_DEFAULT);
	header ("Content-type: image/png");
	$img = imagecreatetruecolor(120, 30);
	$text_color = imagecolorallocate($img, 0, 255, 0);
	imagestring($img, 5, 15, 5,  $string_for_captcha, $text_color);
	imagepng($img);
	imagedestroy($img);
?>