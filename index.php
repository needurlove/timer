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
html,body {
	margin:px;
	padding:0px;
	font-family:'Open Sans Condensed',Arial,serif;
	background:url('../img/tile_bg.jpg') #b0b0b0;
}
.button {
background-color: #669;
border:none;
color:white;
padding: 10px;
text-align: center;
text-decoration: none;
display: inline-block;
font-size: 14px;
margin: 4px 2px;
cursor: pointer;
}

.textarea{
	background: #ffdbff;
	color:black;
}

#login-form {
	margin:0px auto;
	display: block;
	position: fixed;
	background: white;
	top: 25%;
	left: 42%;
	border: 2px solid;
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
	Логин: <input type="text" class="textarea" name="login"/><br/><br/>
	Пароль: <input type="password" class="textarea" name="password"/><br/><br/>
	<button type="submit" class="button">Войти</button><br/><br/>
	<a href="reg.php">Зарегистрироваться</a>
	</form>
	</div>
</body>
</html>
