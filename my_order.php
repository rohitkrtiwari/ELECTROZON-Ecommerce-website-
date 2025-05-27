<?php
session_start();
require('connection.inc.php');
require('functions.inc.php');

$user_id = get_user($conn)[0]; $loggedin = get_user($conn)[1];

if(!$loggedin){
  header('location:'.SITE_PATH.'login');
}

$ordersArr = getOrder($conn, $user_id);
// print_r($ordersArr);
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
	<title>Electrozon - Your Order</title>
</head>
<body class="">


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


<?php if(count($ordersArr)!=0){  ?>


<div id="alert-msg" style="background-color: #3d1a54;"></div>
<section class="bg-white">
  <div class="container-fluid mt-2">
    <div class="row my-3">

      <div class="col-auto mt-2">
        <nav id="sidebarMenu" class=" d-md-block bg-light sidebar collapse">
        <h3 class="mx-3 fw-bold">My Account</h3>
        <h5 class="mx-3 mt-3">Manage Account</h5>
          <div class="position-sticky pt-3">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link" href="<?php echo SITE_PATH ?>my_account">
                  <span data-feather="shopping-cart"></span>
                  Manage Profile
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo SITE_PATH ?>my_order">
                  <span data-feather="file"></span>
                  Orders History
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo SITE_PATH ?>address_manager">
                  <span data-feather="users"></span>
                  Shipping Addresses
                </a>
              </li>
            </ul>

          </div>
        </nav>
      </div>

      <div class="col pt-1">
      <p > <a class="fs-14 text-decoration-none fw-bold" href="<?php echo SITE_PATH ?>">Home > </a> <a class="fs-14 text-decoration-none fw-bold" href="<?php echo SITE_PATH ?>my_account">My Account > </a> <a class="fs-14 text-decoration-none text-danger fw-bold" href="#"> Order History </a></p>
        <h1>Your Orders</h1>

        <div class="container mt-4">
          <b><?php echo count($ordersArr); ?> Orders Placed </b>
          <?php foreach ($ordersArr as $order) { $address=getAddress($conn, $user_id,1, $order['address_id']); ?>
              <div class="row my-3 border rounded-top">

                <!-- Top bar Every Order -->
                <div class="top p-3" style="border: #e0e9e0; background: #f5f5f5;">
                  <div class="row">
                    <div class="col-auto"> 
                      <p class="fs-14 py-0 my-0">Order Placed </p> 
                      <?php 
                      $timestamp = strtotime($order['added_on']);
                      $date = date('d', $timestamp);
                      $MonthName = date('M', $timestamp);
                      $Year = date('Y', $timestamp);
                      ?>
                      <p class="fs-14 py-0 my-0"><?php echo $MonthName." ".$date.", ".$Year; ?></p> 
                    </div>

                    <div class="col-auto"> 
                      <p class="fs-14 py-0 my-0">Total </p> 
                      <p class="fs-14 py-0 my-0"><i class="fa fa-inr"></i> <?php echo (int) $order['total_price']; ?></p> 
                    </div>

                    
                    <div class="col-auto ms-auto me-0 float-end"> 
                      <p class="fs-14 py-0 my-0">Order ID : <?php echo $order['id'] ?> </p> 
                      <a class="fs-14 py-0 my-0 text-decoration-none fw-bold" href="#">Order Details </a> 
                    </div>
                  </div>
                </div>              

                <div class="row px-4">
                  <p class="m-0 p-0 mt-1"><span class="text-danger">Tracknig ID: </span><?php echo $order['tracking_id'] ?></p>
                  <div class="row my-3">
                    <p class="fw-bold col fs-4"><?php echo $order['order_status_str']; ?></p>                    
                    <p class="fw-bold col fs-6 pull-right"><?php if($order['payment_status'] == 'pending') echo "Payment ".$order['payment_status'];?></p>
                  </div>  

                  <?php $ProductsArr = getOrderDetails($conn, $user_id, $order['id']); ?>
                  <?php foreach ($ProductsArr as $product) { ?>
                  <div class="row mb-2">
                      <div class="col-auto">
                        <a href="<?php echo SITE_PATH ?>product/<?php echo $product['product_id']; ?>"><img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$product['image'];?>" class="resp_img_full" ></a>
                      </div>
                      <div class="col-auto">
                        <a class="fs-14 py-0 my-0 text-decoration-none fw-bold " href="<?php echo SITE_PATH ?>product/<?php echo $product['product_id']; ?>"><?php echo $product['name'];?></a>
                        <p class="fs-14 py-0 my-0"><i class="fa fa-inr"></i> <?php echo $product['price'];?>   Qty: <?php echo $product['qty'];?>  <button class="ms-3 btn btn-success btn-sm" style=" font-size:12px;" onclick="addCart('<?php echo $user_id; ?>',<?php echo $product['product_id'] ?>,1,'<?php echo SITE_PATH ?>cart')"">Buy It Again</button></p>
                        
                      </div>
                      <div class="col-auto">
                        <!-- <button class="btn btn-secondary">Track Your package</button> -->
                      </div>

                  </div>
                  <?php } ?>

                </div>

              </div>              
          <?php } ?>
        </div>
        <div class="cart-buttons">
          <div class="">
            <a href="<?php echo SITE_PATH ?>" class="btn btn-secondary">Continue Shopping</a>
          </div>
        </div>
      </div>

    </div>
  </div>


</section>


<?php }else{ ?>

<div class="cart-empty-alert">
  <center><h1 style="font-size: 90px;"><b>No Orders Yet <i class="fa fa-smile-o"></i></b></h1></center>
  <center><h1 style="font-size: 40px;">You have not ordered anything from this website.</h1></center>
  <!-- <center><h1 style="font-size: 90px;"><b>Thank You. <i class="fa fa-smile-o"></i></b></h1></center> -->

  <center>
  	<a href="<?php echo SITE_PATH ?>" class="btn btn-dark">Shop Now</a>
  </center>
</div>

<?php }?>


<!-- Footer Section -->

<?php
require('prerequisite/footer.php');
?>


<script type="text/javascript">
$(document).ready(function(){
    // Toggle Addresses
$("[name=order_status_selector]").click(function(){
    $('.toHide').hide();
    $("#add-"+$(this).val()).show();
  });
});
</script>

</body>
</html>
