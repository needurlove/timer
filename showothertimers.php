<?php
session_start();
?>
<html>
<head>
<title>Мои таймеры</title>
</head>
<body>
<div id="my-timers">
<?php
	require_once 'connection.php';
	print "<table>";
	$login = $_SESSION['login'];
	$url = "/add-timer.php?id=";
	$link = new mysqli($hostname, $username, $passw, $database) or die("Ошибка " . mysqli_error($link));
	$query= "SELECT id, description from timers WHERE login='$login'";
	$result=$link->query($query);
	while($row=mysqli_fetch_array($result)) {
		$currenturl = $url;
		$currenturl .=$row[0];
	print "
		<tr>
		<td><a href='$currenturl'>$row[1]</a></td>
		</tr>";
	}
	print "</table";
?>
</div>
</body>
</html>


