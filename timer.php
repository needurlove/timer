<?php
require "common.php";
session_start();

if(isset($_POST['start_button'])){
	saveTimer();
} else if(isset($_POST['show_button'])) {
	showother();
}
?>

<html>
<head>
<title>Web-таймер</title>
</head>
<style>
html{
	background:url('../img/tile_bg.jpg') #b0b0b0;
	position:relative;
}
body{
	background:url('../img/page_bg_center.jpg') no-repeat center center;
	min-height: 600px;
	font:14px/1.3 'Segoe UI',Arial, sans-serif;
}
#username {
	position: relative;
	text-align:center;
	top:0%;
	font-size: 17;
	color:blue;
}

.textarea{
	background: #ffdbff;
	color:black;
}

#add-timer-time {
	position:absolute;
	top:12%;
	left:41%;
}
#showother {
	position: absolute;
	top:0%;
	left:10%;
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
<div id="username">
<?php
$login=$_SESSION['login'];
echo "Добро пожаловать $login";
?>
</div>
<div id="add-timer-time">
	<form name="time" method="POST" action="">
	Введите пожалуйста необходимое время для таймера:<br/><br/>
	Недели: <input class="textarea" type="number" value="0" min="0" name="weeks"/><br/><br/>
	Дни: <input type="number" class="textarea" value="0" min="0" name="days"/><br/><br/>
	Часы: <input type="number" class="textarea" min="0" value="0" name="hours"/><br/><br/>
	Минуты: <input type="number" class="textarea" min="0" value="0" name="minutes"/><br/><br/>
	Секунды: <input type="number" class="textarea" min="0" value="0" name="seconds"/><br/><br/>
	Описание события: <br/>
	<textarea name="description" class="textarea" rows="3" cols="40" maxlength="62"/></textarea><br/><br/>
	<input type="submit" class="button" name="start_button" value="Запустить таймер"/><br/><br/>
</form>
</div>
<div id="showother">
<form name="show" method="POST">
	<p id="note"><input type="submit" class="button" name="show_button" value="Показать остальные мои таймеры"/><br/><br/></p>
</form>
</div>
</body>
</html>
