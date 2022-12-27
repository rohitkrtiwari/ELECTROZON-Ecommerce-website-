<?php

function crt_time(){
	date_default_timezone_set("Asia/Calcutta");
	return date("Y-m-d h:i:s");
	die();
}

function sendMail($to_email, $subject, $msg_html){

	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$headers .= "From: bitlybily@gmail.com";

	// if (mail($to_email, $subject, $msg_html, $headers)) {
	//     return true;
	// } else {
	//     return false;
	// }
	echo $msg_html;
	return true;
}

function notify_admin($username, $remote_addr, $http_user_agent, $crt_time){

	$body = '<div style="width: 90%; margin: auto; border: 1px solid #e3e3e3; padding: 19px; margin-bottom: 20px; box-shadow: inset 0 1px 1px rgba(0,0,0,.05);">';
	$body .= '<p>Hello Founders,</p>';
	$body .= "<p>Admin Login Detected at ".$crt_time."</p>";
	$body .= "<p>Below is the details of login</p>";
	$body .= "<br>";
	$body .= "<br>";
	$body .= "<p>Username: ".$username."</p>";
	$body .= "<p>Remote Addr: ".$remote_addr."</p>";
	$body .= "<p>User Agent: ".$http_user_agent."</p>";
	$body .= "<p>Login Time: ".$crt_time."</p>";
	$body .= "<br>";
	$body .= "<p>Thank You for using ELECTROZON.com services</p>";
	$body .= '</div>';

	$dev_sent=false;

	if(sendMail("rohitkrtiwari2002@gmail.com", "Admin Login Detected", $body))
		$dev_sent = true;

	if($dev_sent)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function login_otp($username,$token){
	$body = '<div style="width: 90%; margin: auto; border: 1px solid #e3e3e3; padding: 19px; margin-bottom: 20px; box-shadow: inset 0 1px 1px rgba(0,0,0,.05);">';
	$body .= '<p>Hello Admin,</p>';
	$body .= "<p >To authenticate, please use the following One Time Password (OTP):</p>";
	$body .= "<p style='color: black; font-weight: bold; font-size: 19px;'>".$token."</p>";
	$body .= "<p >This OTP is valid for only 6 min.</p>";
	$body .= "<p >Thank You for using ELECTROZON.com services</p>";
	$body .= '</div>';

	if(sendMail($username, "Email OTP Verification - ELECTROZON.com", $body))
	{
		return true;
	}
	else
	{
		return false;
	}
}

function random_strings($length_of_string) { 
    return substr(bin2hex(random_bytes($length_of_string)),  
                                      0, $length_of_string); 
}

function get_safe_value($conn,$str){
	if($str!=''){
		$str = trim($str);
		return strip_tags(mysqli_real_escape_string($conn, $str));
	}
	die();
}


function getOrder($conn){
	$sql = "select `order`.*,order_status.name as order_status_str from `order`,order_status where order_status.id=`order`.order_status order by id asc";
	$res=mysqli_query($conn,$sql);
	$data=array();
	while ($row=mysqli_fetch_assoc($res)){
		$data[]=$row;
	}
	return $data;
}

function getOrderDetails($conn, $order_id){
	$sql = "SELECT DISTINCT(order_detail.id), order_detail.*,product.name,product.image from order_detail, product, `order` where order_detail.order_id=$order_id and order_detail.product_id=product.id";
	$res=mysqli_query($conn,$sql);
	$data=array();
	while ($row=mysqli_fetch_assoc($res)){
		$data[]=$row;
	}
	return $data;
}

function getAddress($conn, $id=''){
	$sql = "SELECT * FROM address where id = '$id'";
	$res=mysqli_query($conn,$sql);
	$data=array();
	while ($row=mysqli_fetch_assoc($res)){
		$data[]=$row;
	}
	return $data;
}

function add_login_db($conn, $username, $remote_addr, $http_user_agent, $crt_time){
	$sql = "INSERT INTO `admin_loggedin`(`username`, `login_time`, `remote_addr`, `http_user_agent`) VALUES ('$username', '$remote_addr', '$http_user_agent', '$crt_time')";
	$res=mysqli_query($conn,$sql);
	if($res)
		return true;
	else
		return false;
}
?>