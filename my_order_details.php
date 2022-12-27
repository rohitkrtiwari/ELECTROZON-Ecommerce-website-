<?php
session_start();
require('connection.inc.php');
require('functions.inc.php');

$user_id = get_user($conn)[0]; $loggedin = get_user($conn)[1];
if(isset($_GET['id'])!=''){
  $order_id = get_safe_value($conn, $_GET['id']);
  $ProductsArr = getOrderDetails($conn, $user_id, $order_id);
}else{
  header('location:'.SITE_PATH.'my_order');
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
  <link href="<?php echo SITE_PATH ?>assets/css/style.css" rel="stylesheet">
	<link href="<?php echo SITE_PATH ?>assets/css/preloader.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="<?php echo SITE_PATH ?>assets/js/custom.js"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>Order Details - Electrozon</title>
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


<?php if(count($ProductsArr)!=0){  ?>


<section class="grid-view my_order_resp">
  <div class="container" style="padding: 50px 0;">
    <div class="row">
      <div class="content">
        <h1>Order Details</h1>
        <div id="alert-msg" style="background-color: #3d1a54;"></div>
          <table class="table table-hover table_scroll_x" style="margin:25px 0;">
            <!-- <caption>List of Products</caption> -->
            <thead>
              <tr>
                <th scope="col">Image</th>
                <th scope="col" style="width: 650px;">Product Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
                <th scope="col">Total Price</th>
              </tr>
            </thead>
            <tbody>

              <?php
                $total_amount=0;
                foreach ($ProductsArr as $product) {
              ?>
                <tr style="vertical-align: baseline;">
                  <td>
                    <img style="max-width: 85px;" src="<?php echo PRODUCT_IMAGE_SITE_PATH.$product['image'];?> ">
                  </td>
                  <td><?php echo $product['name']; ?></td>
                  <td><?php echo $product['qty']; ?></td>
                  <td><?php echo $product['price']; ?></td>
                  <td><?php echo $total=($product['price']*$product['qty']); $total_amount+=$total; ?></td>
                </tr>
              <?php } ?>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="">Total Price</td>
                    <td class=""><?php echo $total_amount; ?></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="">18% GST</td>
                    <td class=""><?php $payed_amount = (0.18*$total_amount); echo (int) $payed_amount; ?></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="">Shipping Charges</td>
                    <td class=""><?php if(($total_amount + $payed_amount)<500) $shipping_amount = 49; else $shipping_amount = 0; echo $shipping_amount;?></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="p-dark">Amount Payed</td>
                    <td class="p-dark"><?php echo (int) ($total_amount + $payed_amount + $shipping_amount); ?></td>
                  </tr>
            </tbody>
          </table>
      </div>
    </div>
  </div>


  <div class="cart-buttons">
    <div class="pull-left">
      <a href="<?php echo SITE_PATH ?>my_order" class="btn btn-secondary">BACK</a>
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


</body>
</html>
