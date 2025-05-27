<?php
include('smtp/PHPMailerAutoload.php');

function user_is_blocked($conn){
	$remote_addr = $_SERVER['REMOTE_ADDR'];
	$sql = "SELECT ip from blocked_ip where ip = '$remote_addr'";
	$count = mysqli_num_rows(mysqli_query($conn, $sql));
	if($count>0)
		return true;
	else
		return false;
}

function block_user($conn){
	$remote_addr = $_SERVER['REMOTE_ADDR'];
	$sql = "INSERT INTO blocked_ip (ip) VALUES ('$remote_addr')";
	mysqli_query($conn, $sql);
}


function password_reset($conn, $tmp_username){
	$sql = "SELECT * from admin_users where username = '$tmp_username'";
	$count = mysqli_num_rows(mysqli_query($conn, $sql));
	if($count>0){
		$password = bin2hex(random_bytes(8));
		set_new_password($tmp_username,$password);
		$password = md5($password);
		$sql = "UPDATE admin_users set password = '$password' where username = '$tmp_username'";
		mysqli_query($conn, $sql);
	}
	else
		return false;
}


function crt_time(){
	date_default_timezone_set("Asia/Calcutta");
	return date("Y-m-d h:i:s");
	die();
}


function sendMail($to,$subject, $body){
	$mail = new PHPMailer(); 
	// $mail->SMTPDebug  = 3;
	$mail->IsSMTP(); 
	$mail->SMTPAuth = true; 
	$mail->SMTPSecure = 'tls'; 
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 587; 
	$mail->IsHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->Username = "mail@gmail.com";
	$mail->Password = "";
	$mail->SetFrom("mail@gmail.com");
	$mail->Subject = $subject;
	$mail->Body =$body;
	$mail->AddAddress($to);
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if(!$mail->Send()){
		// echo $mail->ErrorInfo;
		return false;
	}else{
		return true;
	}
}


function set_new_password($username,$password){
	$body = '<div style="width: 90%; margin: auto; border: 1px solid #e3e3e3; padding: 19px; margin-bottom: 20px; box-shadow: inset 0 1px 1px rgba(0,0,0,.05);">';
	$body .= '<p>Hello Admin,</p>';
	$body .= "<p >Due to too many unsuuccessful Login Attempts on your user name Your password have been reseted. From Now, </p>";
	$body .= "<p >To authenticate, please use the following Password:</p>";
	$body .= "<p style='color: black; font-weight: bold; font-size: 19px;'>".$password."</p>";
	$body .= "<p >Thank You for using ELECTROZON.com services</p>";
	$body .= '</div>';

	if(sendMail($username, "Admin Password", $body))
	{
		return true;
	}
	else
	{
		return false;
	}
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

	if(sendMail($username, "Email OTP Verification - ELECTROZON.in", $body))
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
	$sql = "select `order`.*,order_status.name as order_status_str from `order`,order_status where order_status.id=`order`.order_status and `order`.payment_status = 'success'  order by id asc";
	$res=mysqli_query($conn,$sql);
	$data=array();
	while ($row=mysqli_fetch_assoc($res)){
		$data[]=$row;
	}
	return $data;
}

function getOrderDetails($conn, $order_id){
	$sql = "SELECT DISTINCT(order_detail.id), order_detail.*,product.name,product.image from order_detail, product, `order` where order_detail.order_id=$order_id and order_detail.product_id=product.id and `order`.payment_status = 'success'";
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


function add_login_db($conn, $username, $remote_addr, $http_user_agent){
	$sql = "INSERT INTO `admin_loggedin`(`username`, `remote_addr`, `http_user_agent`) VALUES ('$username', '$remote_addr', '$http_user_agent')";
	$res=mysqli_query($conn,$sql);
	if($res)
		return true;
	else
		return false;
}

// Generate CSRF Token
function csrf_token($form_name){
	$token = bin2hex(random_bytes(50));
	if(!empty($_SESSION['csrf_token'])){
		$_SESSION['csrf_token'][$form_name] = $token;
	}else{
		$_SESSION['csrf_token'] = array();
		$_SESSION['csrf_token'][$form_name] = $token;		
	}
	return $token;
}


?>
