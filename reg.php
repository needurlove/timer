<?php
require "common.php";

if($_POST) {
	echo "<style>
	#reg {
	display:none;
}
	</style>";
	save_user();
}
?>

<html>
<head>
<title>Регистрация</title>
</head>
<style>
html,body {
margin:px;
padding:0px;
font-family:'Open Sans Condensed',Arial,serif;
background:url('../img/tile_bg.jpg') #b0b0b0;
}

.textarea{
	background: #ffdbff;
	color:black;
}

#reg {

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
</style>
<body>
<div id="reg">
<h2>Регистрация</h2>
<form method="POST">
<p>
<label>Введите вашу электронную почту:</label>
<input type="text" class="textarea" name="email">
</p>
<p>
<label>Введите ваш логин:</label>
<input type="text" class="textarea" name="login" size="15">
</p>
<p>
<label>Введите ваш пароль:</label>
<input type="password" class="textarea" name="password" size="15">
</p>
<p>
<button class="button">Зарегистрироваться</button>
</p>
</form>
</div>
</body>
</html>
