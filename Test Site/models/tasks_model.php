<?php 
	function IsCaptchaValid(){
		session_start();
		if(password_verify($_POST['captcha'], $_SESSION['captcha'])){
			return true;
		} else {
			return false;
		}
	}
	function ProtectMySQLInjectAndXSS($string){
		$string = str_replace('<', '&lt;', $string);
		$string = str_replace('>', '&gt;', $string);
		$string = str_replace('&', '&amp;', $string);
		$string = str_replace('"', '&quot;', $string);
		$string = str_replace("'", '&#039;', $string);
		$string = str_replace(' ', '&nbsp;', $string);
		$string = str_replace('/', '&frasl;', $string);
		return $string;
	}
?>