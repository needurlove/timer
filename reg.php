<?php
require "common.php";

if($_POST) {
	save_user();
}
?>

<html>
<head>
<title>Регистрация</title>
</head>
<body>
<h2>Регистрация</h2>
<form method="POST">
<p>
<label>Введите вашу электронную почту</label>
<input type="text" name="email">
</p>
<p>
<label>Введите ваш логин:</label>
<input type="text" name="login" size="15">
</p>
<p>
<label>Введите ваш пароль:</label>
<input type="password" name="password" size="15">
</p>
<p>
<button>Зарегистрироваться</button>
</p>
</form>
</body>
</html>
