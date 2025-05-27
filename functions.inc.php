<?php
include('smtp/PHPMailerAutoload.php');

function get_user($conn){

	// If User is logged in
	if(isset($_SESSION['login'])==true)
	{
		$loggedin = $_SESSION['login'];
		$username = $_SESSION['username'];
		$_SESSION['user_id'] = $_SESSION['username'];


		// Save its's temporary cart into his registered account
		try
		{
		  	if(isset($_COOKIE['user_id']))
		  	{
				if(verify_temp_user($conn,$_COOKIE['user_id']))
				{
			    	$temp_user_id = $_COOKIE['user_id'];
		  			$cart = getCartPID($conn,$temp_user_id);
			  		if(count($cart)!=0)
			  		{
			  			// Insert Cart Data from Temp user to Authenticated user 
			  			$sql = "INSERT INTO cart (pid, username, qty, verfied) VALUES ";
			  			$i=0;

			  			foreach ($cart as $each_cart) 
			  			{
			  				$pid = $each_cart['pid'];
			  				$qty = $each_cart['qty'];
			  				if($i>0) { $sql .=" , "; }
			  				$sql .=" ('$pid', '$username', '$qty', 1) ";
			  				mysqli_query($conn, $sql);
			  				$i=$i+1;
			  			}

			  			// Delete Cart data from temp user table
			  			$sql = "DELETE FROM cart WHERE username = '$temp_user_id'";
			  			mysqli_query($conn, $sql);
			  		}
			    }
			}
		}

		catch (customException $e)
		{
			// Code...
		}
		  


	// If user is Not Logged in
	}
	else
	{
	  $loggedin = false;
	  if(isset($_COOKIE['user_id']) && verify_temp_user($conn,$_COOKIE['user_id'])){
	    $temp_user_id = $_COOKIE['user_id'];
	    try{ tmp_user_visit($conn, $temp_user_id); }
		catch (Exception $e){ // echo $e; 
		}
	  }else{
		$ip = $_SERVER['REMOTE_ADDR'];
		$temp_user_id=create_temp_user($conn, '', $ip);
	  }
	  $_SESSION['user_id'] = $temp_user_id;
	}
	
	return array($_SESSION['user_id'], $loggedin);
}

function sendMail($to_email, $subject, $body){

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
	$mail->AddAddress($to_email);
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

function SendVerificationMail($username, $token){
	$body = '<div style="width: 90%; margin: auto; border: 1px solid #e3e3e3; padding: 19px; margin-bottom: 20px; box-shadow: inset 0 1px 1px rgba(0,0,0,.05);">';
	$body .= '<p style="color: #2a2d4e; font-size: 19px;">Hii '.substr($username, 0, strpos($username, "@")).',</p>';
	$body .= '<p style="color: #2a2d4e; font-size: 19px;">Welcome to <span style="color: brown;">ELECTROZON!</span></p>';
	$body .= "<p style='color: #2a2d4e; font-size: 19px;'>Please verify your email so we know that it's really you!</p>";
	$body .='<center style="margin-top: 30px; margin-bottom: 20px;"><a href="'.SITE_PATH.'activate.php?token='.$token.'&username='.$username.'" style="text-decoration:none; color: white; border-radius: 4px; padding: 12px 40px; background-color: #4e4e91; font-size: 18px;">Verify Your Email</a></center>';
	$body .= '</div>';

	if(sendMail($username, "ELECTROZON Account Activation Mail", $body))
	{
		return true;
	}
	else
	{
		return false;
	}
}

function SendPasswordResetMail($username, $token){
	$body = '<div style="width: 90%; margin: auto; border: 1px solid #e3e3e3; padding: 19px; margin-bottom: 20px; box-shadow: inset 0 1px 1px rgba(0,0,0,.05);">';
	$body .= '<p style="color: black; font-size: 25px;">Hello '.substr($username, 0, strpos($username, "@")).'!,</p>';
	$body .= '<p style="color: #2a2d4e; font-size: 19px;">You are receiving this email because we received a password reset request for your account.</p>';
	$body .='<center style="margin-top: 30px; margin-bottom: 20px;"><a href="'.SITE_PATH.'create_new_password.php?e='.$token.'&username='.$username.'" style="text-decoration:none; color: white; border-radius: 4px; padding: 12px 40px; background-color: #4e4e91; font-size: 18px;">RESET PASSWORD</a></center>';
	$body .= "<p style='color: #2a2d4e; font-size: 19px;'>This link will expire after 30 mins.</p>";
	$body .= "<p style='color: #2a2d4e; font-size: 19px;'>If you did not request a password reset, no further action is required.</p>";
	$body .= "<p style='color: #2a2d4e; font-size: 19px;'>Regards,</p>";
	$body .= "<p style='color: #2a2d4e; font-size: 19px;'>Team ELECTROZON .</p>";
	$body .= '</div>';

	if(sendMail($username, "ELECTROZON Password Change Email", $body))
	{
		return true;
	}
	else
	{
		return false;
	}
}


function get_safe_value($conn,$str){
	if($str!=''){
		$str = trim($str);
		return strip_tags(mysqli_real_escape_string($conn, $str));
	}
	die();
}

function getCartPID($conn, $username){
	$sql = "SELECT pid, qty from cart where username = '$username'";
	$res = mysqli_query($conn,$sql);
	$data=array();
	while ($row=mysqli_fetch_assoc($res)){
		$data[]=$row;
	}
	return $data;
}

function crt_time(){
	date_default_timezone_set("Asia/Calcutta");
	return date("Y-m-d h:i:s");
	die();
}


function get_product($conn,$limit='',$cat_id='',$pid='',$search_str='', $best_seller='', $pid_arr=''){
	$sql="SELECT * from product where status = 1";
	if($pid!='')
	{
		$sql.=' and id IN ('.implode(",",$pid).')';
	}

	if($cat_id!='')
	{
		$sql.=" and category_id=$cat_id";
	}

	if($best_seller!='')
	{
		$sql.=" and best_seller=1";
	}

	if($search_str!='')
	{

		if($pid_arr=='')
			$sql.=" and (product.short_name like '%$search_str%' or product.name like '%$search_str%' or product.description like '%$search_str% and status = 1'";
		else
			$sql.=" and (product.short_name like '%$search_str%' or product.id IN (".implode(",",$pid_arr).") or product.name like '%$search_str%' or product.description like '%$search_str% and status = 1'";


		$cat_sql="select id from categories where category like '%$search_str%'";
		$res=mysqli_query($conn, $cat_sql);
		
		if(mysqli_num_rows($res)!=0)
		{
			$catId=array();
			while($row=mysqli_fetch_assoc($res))
			{
		    	array_push($catId, $row['id']);
			}		
			$sql.="or category_id IN (".implode(',',$catId).")";	
		}
		$sql.=")";

		
	}
	$sql.=" order by id asc";
	
	if($limit!='')
	{
		$sql.=" limit $limit";
	}
	$res=mysqli_query($conn,$sql);
	if($res){
		$data=array();
		while ($row=mysqli_fetch_assoc($res)){
			$data[]=$row;
		}
		return $data;
	}else{
		return false;
	}
}


function verify_temp_user($conn,$user_id){
	$sql="SELECT username from temp_user where username = '$user_id'";
	$res=mysqli_query($conn, $sql);
	$row=mysqli_num_rows($res);
	if($row>0){
		return true;
	}else{
		return false;
	}
}

function create_temp_user($conn,$uniqid='', $ip){
	if($uniqid==''){
		$uniqid = uniqid('user_');
		setcookie("user_id",$uniqid,time()+31560000,"/");
	}
	$crt_time = crt_time();
	$sql="INSERT INTO temp_user(username, created_on, last_visit, ip) values('$uniqid', '$crt_time','$crt_time','$ip')";
	mysqli_query($conn, $sql);
	return $uniqid;
}

function getAddress($conn, $user_id, $status='', $id=''){
	$sql = "SELECT * FROM address WHERE `username` = '$user_id'";
	if($id!=''){
		$sql.=" and id=$id";
	}
	if($status!=''){
		$sql.=" and verified=$status";
	}
	$res=mysqli_query($conn,$sql);
	$data=array();
	while ($row=mysqli_fetch_assoc($res)){
		$data[]=$row;
	}
	return $data;
}

function getOrder($conn, $username){
	$sql = "select `order`.*,order_status.name as order_status_str from `order`,order_status where `order`.username='$username' and order_status.id=`order`.order_status and `order`.payment_status = 'success' order by id desc";
	$res=mysqli_query($conn,$sql);
	$data=array();
	while ($row=mysqli_fetch_assoc($res)){
		$data[]=$row;
	}
	return $data;
}

function getOrderDetails($conn, $username, $order_id){
	$sql = "SELECT DISTINCT(order_detail.id), order_detail.*,product.name,product.image from order_detail, product, `order` where order_detail.order_id=$order_id and `order`.username='$username' and order_detail.product_id=product.id and `order`.payment_status = 'success'";
	// echo $sql;
	$res=mysqli_query($conn,$sql);
	$data=array();
	while ($row=mysqli_fetch_assoc($res)){
		$data[]=$row;
	}
	return $data;
}


function userProfileData($conn, $username){
	$sql = "SELECT * FROM customers where username = '$username'";
	$res=mysqli_query($conn,$sql);
	$data=array();
	while ($row=mysqli_fetch_assoc($res)){
		$data[]=$row;
	}
	return $data;
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


// Make Online Payment Thorough Instamojo Payment Gateway
function getPaymentID($name, $email, $number, $amount){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://www.instamojo.com/api/1.1/payment-requests/');
  curl_setopt($ch, CURLOPT_HEADER, FALSE);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
  curl_setopt($ch, CURLOPT_HTTPHEADER,
              array("X-Api-Key:your_key",
                    "X-Auth-Token:your_token"));
  $payload = Array(
      'purpose' => 'ELECTRZON Purchase ',
      'amount' => $amount,
      'phone' => $number,
      'buyer_name' => $name,
      'redirect_url' => 'http://localhost/electrozon/activate.php',
      'send_email' => true,
      'send_sms' => true,
      'email' => $email,
      'allow_repeated_payments' => false
  );
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
  $response = curl_exec($ch);
  curl_close($ch); 
  $response = json_decode($response);
  return array($response->payment_request->longurl, $response->payment_request->id);
}

function tmp_user_visit($conn, $temp_user_id){
	$sql="UPDATE  temp_user set last_visit = default where username = '$temp_user_id'";
	mysqli_query($conn, $sql); 
}

// This function return the shiiping ammout
function shipping_charge($price){
	
	$shipping_charge = 0;

	if($price < SHIPPING_CHARGE_LIMIT_1)
    	$shipping_charge = SHIPPING_CHARGE_1;
    elseif(($price > SHIPPING_CHARGE_LIMIT_1) && ($price < SHIPPING_CHARGE_LIMIT_2))
    	$shipping_charge = SHIPPING_CHARGE_2;
    elseif($price > SHIPPING_CHARGE_LIMIT_2)
    	$shipping_charge = SHIPPING_CHARGE_3;


    return $shipping_charge;

}



?>
