<?php
require 'common.php';
session_start();

if(isset($_POST['stop'])) {
	$Timerid = $_GET['id'];
	$time_stopped = date("U");
	stoptimer($Timerid, $time_stopped);
	sendEmail($Timerid);
}

if(isset($_POST['renew'])) {
	$Timerid = $_GET['id'];
	renewtimer($Timerid);
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Web-таймер</title>

	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.12.1/jquery.min.js"></script>
	<style>
		@import url(//fonts.googleapis.com/css?family=Open+Sans+Condensed:300&subset=latin,cyrillic);
		html,body {
			margin:px;
			padding:0px;
			font-family:'Open Sans Condensed',Arial,serif;
			background:url('../img/tile_bg.jpg') #b0b0b0;
		}
		#countdown {
		margin:50px auto;
		width:auto;
		padding:20px 20px 20px 10px;
		position:relative;
		border:#f90 2px solid;
		background:#eee;
		}

		#linkback {
			text-align: center;
			font-size: 20px;
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
		#countdown div {
			margin:0px 0px 0px 10px;
			float:left;
		}
		#desc {
			position:relative;
			width:392px;
			height:auto;
		}
		#week {
			width: 88px;
		}
		#day {
			width: 88px;
		}
		#hour {
			width: 88px;
		}
		#minute {
			width: 88px;
		}
		#second {
			width: 88px;
		}
		#countdown div span {
			display:block;
			height:53px;
			background:#000;
			border-bottom:#f00 1px solid;
			color:#eee;
			font-size: 24pt;
			padding-top: 4px;
			padding-left: 16px;
			letter-spacing: 31px;
			/* Последние 4 параметра отвечают за размер текста и его выравнивание на циферблате */
		}
		#countdown #week,#countdown #day,#countdown #hour,#countdown #minute,#countdown #second {
			display:none;
		}
		.clearfix {
			clear:both;
			float:none !important;
		}
	</style>
</head>
<body>
	<p id="linkback"><a href="timer.php">Вернуться назад</a></p>
	<div id="countdown">
	<?php
		include_once 'config.php';
		$idTimer = $_GET['id'];
		$timerInfo = getTimerInfo($idTimer);
		$script = '';
		$script .= '<script type="text/javascript">var flagstop='.$timerInfo['state'].';</script>';
		$countdown_txt = '';
		$block_count = 0;
		/* Генерация html кода таймера */
		$desc_txt = '<div id="desc">' . $timerInfo['description'] . ' через: ' . '</div>';
		echo $desc_txt;
		foreach($countdown_setting['visible'] AS $i => $v) {
			$countdown_txt .= '<div id="'.$i.'" style="display:'.$v[0].';">'.$v[1].' <span>00</span></div>';
			$script .= '<script type="text/javascript">var countdown_'.$i.' = "'.$v[0].'";</script>';
			if($v[0]=='block') $block++;
		}
		if($countdown_setting['position'] == 'vertical') $block = 1;
		$script .= '<script type="text/javascript">var block_count = '.$block.';</script>';

		/* обработка, когда указано время отсчета */
		if($countdown_setting['type'] == 'time') {
			$time_value = $timerInfo['end'] - $timerInfo['start'] - (date("U") - $timerInfo['start']);
			$time_new = $time+$time_value;
			$script .= '<script type="text/javascript">var timeleft='.$time_value.';</script>';
		}
		echo $countdown_txt . $script;
	?>
		<div class="clearfix"></div>
	</div>
	<script>
		function countdown_go() {
			stopflag = flagstop;
			timeleft_func = timeleft;
			if(countdown_week=='block') {
				timevalue = Math.floor(timeleft_func/(7*24*60*60));
				timeleft_func -= timevalue*7*24*60*60;
				if(timevalue<10) timevalue = '0'+timevalue;
				$("#week span").html(timevalue);
			}
			if(countdown_day=='block') {
				timevalue = Math.floor(timeleft_func/(24*60*60));
				timeleft_func -= timevalue*24*60*60;
				if(timevalue<10) timevalue = '0'+timevalue;
				$("#day span").html(timevalue);
			}
			if(countdown_hour=='block') {
				timevalue = Math.floor(timeleft_func/(60*60));
				timeleft_func -= timevalue*60*60;
				if(timevalue<10) timevalue = '0'+timevalue;
				$("#hour span").html(timevalue);
			}
			if(countdown_minute=='block') {
				timevalue = Math.floor(timeleft_func/(60));
				timeleft_func -= timevalue*60;
				if(timevalue<10) timevalue = '0'+timevalue;
				$("#minute span").html(timevalue);
			}
			if(countdown_second=='block') {
				timevalue = Math.floor(timeleft_func/1);
				timeleft_func -= timevalue*1;
				if(timevalue<10) timevalue = '0'+timevalue;
				$("#second span").html(timevalue);
			}
			if(timeleft == 0) {
				return;
			}
			if(stopflag == 1) {
				timeleft-=1;
			}
			return false;
		}
		$(document).ready(function() {
			timerId = setInterval(countdown_go,1000);
			$("#countdown").css('width',(block_count*98)+'px');
			return false;
		});
	</script>
	<div id="buttons">
	<form name="butt" method="POST" action="">
	<center>
	<?php
		echo date('l jS \of F Y H:i:s', $timerInfo['end']);
	?>
	</br>
	<input name="stop" class="button" type="submit" value="Остановить" <?php if($timerInfo['state'] == 0) { ?> disabled <?php } ?>/><br/><br/>
	<input name="renew" class="button" type="submit" value="Возобновить" <?php if($timerInfo['state'] == 1) { ?> disabled <?php } ?>/><br/><br/>
	</center>
	</form>
	</div>
</body>
</html>
