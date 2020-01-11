<?php 
	function LoginUser($login, $password) {
		$auth_data = $login . $password;
		setcookie('auth', password_hash($auth_data, PASSWORD_DEFAULT), time() + 3600, "/");
	}
	function AuthUser(){
		if(password_verify('admin123', $_COOKIE['auth'])){
			return true;
		} else {
			return false;
		}
	}
?>