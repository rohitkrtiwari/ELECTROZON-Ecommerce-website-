<?php
//echo '<b>Transaction In Process, Please do not reload</b>';
require('connection.inc.php');
if(isset($_POST['mihpayid']))
{
	$payment_mode=$_POST['mode'];
	$pay_id=$_POST['mihpayid'];
	$status=$_POST["status"];
	$firstname=$_POST["firstname"];
	$amount=$_POST["amount"];
	$txnid=$_POST["txnid"];
	$posted_hash=$_POST["hash"];
	$key=$_POST["key"];
	$productinfo=$_POST["productinfo"];
	$email=$_POST["email"];
	$MERCHANT_KEY = "gtKFFx"; 
	$SALT = "eCwWELxi";
	$udf5='';
	$keyString 	= $MERCHANT_KEY .'|'.$txnid.'|'.$amount.'|'.$productinfo.'|'.$firstname.'|'.$email.'|||||'.$udf5.'|||||';
	$keyArray 	= explode("|",$keyString);
	$reverseKeyArray = array_reverse($keyArray);
	$reverseKeyString =	implode("|",$reverseKeyArray);
	$saltString     = $SALT.'|'.$status.'|'.$reverseKeyString;
	$sentHashString = strtolower(hash('sha512', $saltString));


	if($sentHashString != $posted_hash){
		mysqli_query($conn,"update `order` set payment_status='$status', mihpayid='$pay_id' where txnid='$txnid'");	
		header('location:'.SITE_PATH.'thank_u.php?e='.FAILURE);

	}else{
		emptyCart($conn, $email);
		mysqli_query($conn,"update `order` set payment_status='$status', mihpayid='$pay_id' where txnid='$txnid'");	
		header('location:'.SITE_PATH.'thank_u.php?e='.SUCCESS);
	}

}
else{
	header('location:'.SITE_PATH.'errors/not-found');
}



// Function to Empty Cart
function emptyCart($conn, $username){
   $sql = "DELETE FROM cart WHERE username = '$username'";
   if(mysqli_query($conn,$sql)){
      return true;
   }else{
      return false;
   }
}


?>
