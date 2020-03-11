<?php
session_start();


function test_reg() {
	require_once 'connection.php';
	$login = $_POST['login'];
	$password = $_POST['password'];
	if(empty($login) || (empty($password))) {
		exit("Вы неправильно ввели логин и пароль");
	}

	$link = new mysqli($hostname, $username, $passw, $database) or die("Ошибка " . mysqli_error($link));

	$testregsql = "SELECT * from users where login='$login'";
	$testreg = $link->query($testregsql);
	if($testreg) {
		$myrow = mysqli_fetch_array($testreg);
		if(empty($myrow['password'])) {
			exit("Введенные вами логин или пароль неверны.");
		} else {
			if($myrow['password']==$password) {
				$_SESSION['login'] = $myrow['login'];
				$_SESSION['id'] = $myrow['id'];
				header('Location: /timer.php');
			} else {
				echo "Введенные вами логин или пароль неверны.";
			}
		}
	}
}

function save_user() {
	require_once 'connection.php';

	$login=$_POST['login'];
	$password=$_POST['password'];
	$email=$_POST['email'];
	if(empty($login) or empty($password) or empty($email)) {
		echo "Заполните все поля для регистрации";
	} else {

		$link = new mysqli($hostname, $username, $passw, $database) or die("Ошибка " . mysqli_error($link));

		$userchecksql = "SELECT id from users where login='$login'";

		$usercheck = $link->query($userchecksql);
		if($usercheck->num_rows != 0) {
			exit("Извините, введенный вами логин уже зарегистрирован. Пожалуйста введите другой логин <a href='reg.php'>Назад</a>");
		}

		$saveusersql = "INSERT INTO users(login, password, email) values('$login', '$password', '$email')";
		$saveuser = $link->query($saveusersql);
		if($saveuser) {
			echo "Регистрация прошла успешно! Теперь вы можете зайти на сайт <a href='index.php'>Главная страница</a>";
		} else {
			echo "Во время регистрация произошла ошибка";
		}
	}
}

function showTimers() {
	require_once 'connection.php';
	echo "smth";
	print "<table>";
	$login = $_SESSION['login'];
	$link = new mysqli($hostname, $username, $passw, $database) or die("Ошибка " . mysqli_error($link));
	$showtimerssql = "SELECT id from timers where login='$login'";
	$showtimer = $link->query($showtimerssql);
	while($row=mysqli_fetch_array($showtimer)) {
		print "
		<tr>
		<td><a href='add-timer.php'>$row[0]</a></td>
		</tr>";
	}
	print "</table>";
	/* $db = new SQLite3("time.db");
	$statement=$db->prepare("SELECT rowid from timers WHERE login=:login");
	$statement->bindValue(":login", $login, SQLITE3_TEXT);
	$result=$statement->execute();
	while($row=$result->fetchArray()) {
		print "
		<tr>
		<td><a href='add-timer.php'>$row[0]</a></td>
		</tr>";
	}
	print "</table"; */
}

?>
