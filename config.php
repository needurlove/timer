<?php
$week=$_POST['weeks'];
$day=$_POST['days'];
$hour=$_POST['hours'];
$minute=$_POST['minutes'];
$second=$_POST['seconds'];
$desc=$_POST['description'];

$countdown_setting = array(
	"type" 			=> "time",
	"cookie" 		=> false, 
	"position"	    => "horizontal", 
	"date"			=> array(
		"year" 		=> 2020,
		"month" 	=> 9,
		"day"		=> 10,
		"hour"		=> 10,
		"minute"	=> 13,
		"second"	=> 0
	), 
	    "time" 		=> array(
			"week"		=> $week,
			"day"		=> $day,
			"hour"		=> $hour,
			"minute"	=> $minute,
			"second"	=> $second,
			"desc"		=> $desc
	), 
		"visible"	=> array(
			"week"		=> array("none","недель:"),
			"day"		=> array("block","дней:"),
			"hour"		=> array("block","часов:"),
			"minute"	=> array("block","минут:"),
			"second"	=> array("block","секунд:")
//			"desc"		=> array("block","Описание:")
	)
);
