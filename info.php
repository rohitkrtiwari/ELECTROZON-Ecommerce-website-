<?php
session_start();
require('connection.inc.php');
require('functions.inc.php');

$user_id = get_user($conn)[0]; $loggedin = get_user($conn)[1];


if(isset($_GET['msg'])!=''){
  $token = get_safe_value($conn, $_GET['msg']);
  if($token == EMAIL_VERIFICATION)
    $msg = 'email_verification';
}else{
  header('location: '.SITE_PATH);
}


?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="HandheldFriendly" content="true">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo SITE_PATH ?>assets/css/theme.css" rel="stylesheet">
  <link href="<?php echo SITE_PATH ?>assets/css/style.css" rel="stylesheet">
  <link href="<?php echo SITE_PATH ?>assets/css/preloader.css" rel="stylesheet">
  <link href="<?php echo SITE_PATH ?>assets/css/header.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="assets/js/custom.js"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>Information Electrozon</title>
</head>
<body>


<!-- wpf loader Two -->
<div id="wpf-loader-two">          
  <div class="wpf-loader-two-inner">
    <span>Loading</span>
  </div>
</div> 

<!-- Header -->

<?php
if($loggedin==true){
  require('prerequisite/login_navbar.php');
}else {
  require('prerequisite/def_navbar.php');
}
require('prerequisite/main-menu.php');
?>

<?php
if($msg == "email_verification"){ ?>
<div class="cart-empty-alert px-4">
  <center class="fs-6"><i class="fa fa-check-circle text-success " aria-hidden="true"></i> Congratulation! You have successfully registered</center>
  <center class="fs-3 mb-3 fw-bold mt-3">CHECK YOUR INBOX</center>
  <center >The activation e-mail has been sent to the email address with which you registered. Please check your email and click on the link provided.</center>
  <center><a class="btn btn-dark mt-3" href="<?php echo SITE_PATH ?>login" style="line-height: 1.1;">Login</a>
  </center>
</div>
<?php }?> 

<!-- Footer Section -->

<?php
require('prerequisite/footer.php');
?>


</body>
</html>
