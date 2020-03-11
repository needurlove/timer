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
	print "<table>";
	$login = $_SESSION['login'];
	$db = new SQLite3("time.db");
	$statement=$db->prepare("SELECT rowid from timers WHERE login=:login");
	$statement->bindValue(":login", $login, SQLITE3_TEXT);
	$result=$statement->execute();
	while($row=$result->fetchArray()) {
		print "
		<tr>
		<td><a href='add-timer.php'>$row[0]</a></td>		
		</tr>";
	}
	print "</table";
?>
</div>
</body>
</html>


