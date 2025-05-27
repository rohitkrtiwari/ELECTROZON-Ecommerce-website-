<?php
require 'functions.inc.php';
require 'connection.inc.php';

session_start();
$user_id = get_user($conn)[0]; $loggedin = get_user($conn)[1];
if(isset($_GET['token'])){
	$token = get_safe_value($conn, $_GET['token']);
	$username = get_safe_value($conn, $_GET['username']);
	$sql = "UPDATE `customers` SET  `status`=1  WHERE token = '$token' and username = '$username' and status = 0";
	if(mysqli_query($conn, $sql)){
		header('location:'.SITE_PATH.'login');
	}else{
		echo "Verification token expired";
	}
}


?>
