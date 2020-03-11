<?php
require "common.php";
session_start();

if($_POST){
	test_reg();
}
?>
<html>
<head>
	<meta charset="UTF-8">
	<title>Web-таймер</title>
</head>
<style>	
#login-form {
	display: block;
	position: fixed;
	background: white;
	top: 200px;
	left: 600px;
	border: 1px solid;
	text-align: center;
}
</style>
<body>
	<div id="login-form">
	<form method="POST">
	<?php
	if (empty($_SESSION['login']) || (empty($_SESSION['password']))) {
		echo "Введите пожалуйста логин и пароль";
	}
	?><br/><br/>
	Логин: <input type="text" name="login"/><br/><br/>
	Пароль: <input type="password" name="password"/><br/><br/>
	<button type="submit">Войти</button><br/><br/>
	<a href="reg.php">Зарегистрироваться</a>
	</form>
	</div>
</body>
</html>
