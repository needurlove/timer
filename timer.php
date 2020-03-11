<?php
require "common.php";
session_start();

if(isset($_POST['button'])){
	echo "smth";
	showTimers();
}
?>

<html>
<head>
<title>Web-таймер</title>
</head>
<style>
#username {
	text-align:center;
	font-size: 17;
}
#add-timer {
	padding: 50 600px;
}
#other-timers {
	position: relative;
	margin-top: -450px;
}
</style>
<body>
<div id="username">
<?php
$login=$_SESSION['login'];
echo "Добро пожаловать $login";
?>
</div>
<div id="add-timer">
	<form method="POST" action="add-timer.php">
	Введите пожалуйста необходимое время для таймера:<br/><br/>
	Недели: <input type="text" name="weeks"/><br/><br/>
	Дни: <input type="text" name="days"/><br/><br/>
	Часы: <input type="text" name="hours"/><br/><br/>
	Минуты: <input type="text" name="minutes"/><br/><br/>
	Секунды: <input type="text" name="seconds"/><br/><br/>
	Описание события: <br/>
	<textarea name="description" rows="3" cols="40" maxlength="62"/></textarea><br/><br/>
	<button>Запустить таймер</button><br/><br/>
	<button type="button" name="button">Показать остальные мои таймеры</button><br/><br/>
	</form>
	</div>
</body>
</html>
