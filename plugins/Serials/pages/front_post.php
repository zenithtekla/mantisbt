<?php
	require_once('../model/dbi_con.php');
	session_start();

	$t_user_table = 'mantis_user_table';
	require_once('core/date_time.php');
	$_SESSION['time']     			= getDateTime();
	$_SESSION['username'] 			= $mysqli->real_escape_string($_POST['username']);
	$_SESSION['password'] 			= $mysqli->real_escape_string($_POST['password']);
	$_SESSION['assembly'] 			= $mysqli->real_escape_string($_POST['assembly']);
	$_SESSION['revision'] 			= $mysqli->real_escape_string($_POST['revision']);
	$_SESSION['format'] 			= $mysqli->real_escape_string($_POST['format']);
	$_SESSION['format_example'] 	= $mysqli->real_escape_string($_POST['format_example']);
	$_SESSION['sale_order'] 		= $mysqli->real_escape_string($_POST['sale_order']);
	$_SESSION['customer'] 			= $mysqli->real_escape_string($_POST['customer']);
	$_SESSION['ss_key'] 			= 0;

	echo 'username : ' . $_POST['username']. '<br/>';
	echo 'password : ' . $_POST['password']. '<br/>';
	echo 'format : ' . $_POST['format']. '<br/>';
	echo 'format_example : ' . $_POST['format_example']. '<br/>';

	$t_username 			= $_SESSION['username'];
	$t_password 			= $_SESSION['password'];
		$t_password_copy 	= $t_password;
	$t_format 				= $_SESSION['format'];
	$t_format_example 		= $_SESSION['format_example'];
	require_once('core/access_control.php');
?>
