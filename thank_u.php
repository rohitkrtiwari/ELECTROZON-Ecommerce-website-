<?php
session_start();
require('connection.inc.php');
require('functions.inc.php');
$status='';
$user_id = get_user($conn)[0]; $loggedin = get_user($conn)[1];

if(isset($_GET['e'])){
  $e = get_safe_value($conn, $_GET['e']);
  if($e == SUCCESS or $e == FAILURE){ }
  else  header('location:'.SITE_PATH.'errors/not-found');
}
else
  header('location:'.SITE_PATH.'errors/not-found');

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
	<title>Electrozon - Thank You Page</title>
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
if($e == SUCCESS){ ?>
<div class="cart-empty-alert">
  <center><h1 style="font-size: 90px;"><b>Thank You. <i class="fa fa-smile-o"></i></b></h1></center>
  <center><h1 style="font-size: 40px;">Your order has been placed successfully.</h1></center>

  <center>
  	<a href="<?php echo SITE_PATH ?>" class="btn btn-dark">Shop More</a>
  	<a href="<?php echo SITE_PATH ?>my_order" class="btn btn-dark">View Your Orders</a>
  </center>
</div>
<?php } elseif($e == FAILURE) { ?>

<div class="cart-empty-alert">
  <center><h1 style="font-size: 90px;"><b>Order Failed<i class="fa fa-sad-o"></i></b></h1></center>
  <center><h1 style="font-size: 40px;">We are unable to Place your Order Right Now..!</h1></center>

  <center>
    <a href="<?php echo SITE_PATH ?>" class="btn btn-dark">Shop More</a>
    <a href="<?php echo SITE_PATH ?>my_order.php" class="btn btn-dark">View Your Orders</a>
  </center>
</div>

<?php } ?>

<!-- Footer Section -->

<?php
require('prerequisite/footer.php');
?>


</body>
</html>


