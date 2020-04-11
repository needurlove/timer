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
			echo "Во время регистрация произошла ошибка. Попробуйте еще раз <a href='reg.php'>Зарегистрироваться</a>";
		}
	}
}

function showTimers() {
	require_once 'connection.php';
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
}

function saveTimer() {
	date_default_timezone_set('UTC+3');
	$start = date("U");
	$login=$_SESSION['login'];
	$weeks=$_POST['weeks'];
	$days=$_POST['days'];
	$hours=$_POST['hours'];
	$minutes=$_POST['minutes'];
	$seconds=$_POST['seconds'];
	$description=$_POST['description'];
	$endtime = time() + ($weeks*7*60*60*24+$days*60*60*24+$hours*60*60+$minutes*60+$seconds);
	require_once 'connection.php';
	$link = new mysqli($hostname, $username, $passw, $database) or die("Ошибка " . mysqli_error($link));
	$newtimersql = "INSERT INTO timers(login, description, endtime, start, state) values ('$login', '$description', '$endtime', '$start', 1)";
	$newtimer = $link->query($newtimersql);
	$getidtimersql = "SELECT id from timers where login='$login' and description='$description' and endtime='$endtime' and start='$start'";
	$getidtimer = $link->query($getidtimersql);
	$row = mysqli_fetch_array($getidtimer);
	$idtimer = $row[0];
	header("Location: /add-timer.php?id='$idtimer'");
}

function getTimerInfo($idTimer) {
	require 'connection.php';
	$idtimer = trim($idTimer, "'");
	$link = new mysqli($hostname, $username, $passw, $database) or die("Ошибка " . mysqli_error($link));
	$getinfosql = "SELECT * from timers where id='$idtimer'";
	$getinfo = $link->query($getinfosql);
	$info = mysqli_fetch_array($getinfo);
	$timerinfo = array(
		"id"			=> $info[0],
		"login"			=> $info[1],
		"description"	=> $info[2],
		"end" 			=> $info[3],
		"start"			=> $info[4],
		"state"			=> $info[5]
	);
	return $timerinfo;
}

function sendEmail($idTimer) {
	$idtimer = trim($idTimer, "'");
	require 'connection.php';
	$login = $_SESSION['login'];
	$link = new mysqli($hostname, $username, $passw, $database) or die("Ошибка " . mysqli_error($link));
	$getemailsql = "SELECT email from users where login='$login'";
	$getemail = $link->query($getemailsql);
	$email = mysqli_fetch_array($getemail);
	$desctimersql = "SELECT description from timers where id='$idtimer'";
	$desctimer = $link->query($desctimersql);
	$desc = mysqli_fetch_array($desctimer);
	$subject = "Таймер закончился";
	$message = " <p>Таймер с описанием:'$desc[0]' закончился</p></br>";

	require 'php_mailer/PHPMailer.php';
	require 'php_mailer/SMTP.php';
	require 'php_mailer/Exception.php';

	$mail= new PHPMailer\PHPMailer\PHPMailer();
	try {
		$mail->CharSet = "UTF-8";

		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPAuth = true;
		$mail->Username = 'my_timer_mail@gmail.com';
		$mail->Password = 'my_timer_mail_pass';
		$mail->SMTPSecure = 'ssl';
		$mail->Port = 465;

		$mail->setFrom('my_timer_mail@gmail.com');
		$mail->addAddress("$email[0]");
		$mail->isHTML(true);

		$mail->Subject = "$subject";
		$mail->Body = "$message";
		if(!$mail->send()) {
			echo "Error";
		} else {
			echo 'Success';
		}
	} catch (Exception $e) {
		echo "Письмо не отправилось по причине: {$mail->ErrorInfo}";
	}
}

function stoptimer($Timerid,$timestopped) {
	$timerid = trim($Timerid, "'");
	$infotimer = getTimerInfo($timerid);
	$time_stopped = $timestopped;
	require 'connection.php';
	$login = $_SESSION['login'];
	$link = new mysqli($hostname, $username, $passw, $database) or die("Ошибка " . mysqli_error($link));
	$cngstatesql = "UPDATE timers SET state='0', start='$time_stopped' WHERE id='$timerid'";
	$cngstate = $link->query($cngstatesql);
}

function renewtimer($Timerid) {
	$timerid = trim($Timerid, "'");
	$infotimer = getTimerInfo($timerid);
	$endtime = $infotimer['end'] + date("U") - $infotimer['start'];
	require 'connection.php';
	$login = $_SESSION['login'];
	$link = new mysqli($hostname, $username, $passw, $database) or die("Ошибка " . mysqli_error($link));
	$cngstatesql = "UPDATE timers SET endtime='$endtime', state=1 WHERE id='$timerid'";
	$cngstate = $link->query($cngstatesql);
}

function showother(){
	require 'connection.php';
	print "<table>";
	$login = $_SESSION['login'];
	$url = "/add-timer.php?id=";
	$link = new mysqli($hostname, $username, $passw, $database) or die("Ошибка " . mysqli_error($link));
	$getlinksql= "SELECT id, description from timers WHERE login='$login'";
	$getlink = $link->query($getlinksql);
	while($row=mysqli_fetch_array($getlink)) {
		$currenturl = $url;
		$currenturl .=$row[0];
	print "
		<tr>
		<td><a href='$currenturl'>$row[1]</a></td>
		</tr>";
	}
	print "</table";
}

?>
