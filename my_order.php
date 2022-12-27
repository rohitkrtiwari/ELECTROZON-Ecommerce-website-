<?php
session_start();
require('connection.inc.php');
require('functions.inc.php');

$user_id = get_user($conn)[0]; $loggedin = get_user($conn)[1];

if(!$loggedin){
  header('location:'.SITE_PATH.'404');
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
	<title>Electrozon - My Order</title>
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


<?php if(count($ordersArr)!=0){  ?>


<section class="grid-view my_order_resp">
  <div class="container-fluid p-4">
    <div class="row">
      <div class="content">
        <h1>Manage Orders</h1>
        <div id="alert-msg" style="background-color: #3d1a54;"></div>


        <div class="table-responsive " >
          <table class="table table-hover caption-top table_scroll_x" style="margin:25px 0;">
            <caption>Click on the blue button to view orders</caption>
            <thead>
              <tr>
                <th scope="col"  >Order ID</th>
                <th scope="col"  style="width: 300px;">Address</th>
                <th scope="col" >Order Date</th>
                <th scope="col" >Payment Type</th>
                <th scope="col" >Payment Status</th>
                <th scope="col" >Order Status</th>
                <th scope="col"  role="button" title="To track packages while on the go, send UPS an SMS to get the status of your shipment. Simply text your tracking keyword followed by your tracking number to your country SMS number and we'll reply with your shipment status details.">Tracking ID</th>
              </tr>
            </thead>
            <tbody>

              <?php
                foreach ($ordersArr as $order) {
                  $address=getAddress($conn, $user_id,1, $order['address_id']);
              ?>
                <tr style="vertical-align: baseline;">
               	<td><center><button class="btn btn-dark" onclick="viewOrderDetail(<?php echo $order['id']; ?>)" style="line-height: 1.1;width: 100%;background: #215c90;"><?php echo $order['id']; ?></button></center></td>
                  <td role="button"><?php print_r($address[0]['address']."<br>".$address[0]['post_code']); ?></td>
                  <td role="button"><?php echo $order['added_on']; ?></td>
                  <td role="button"><?php echo $order['PAYMENTMODE']; ?></td>
                  <td role="button"><?php echo $order['payment_status']; ?></td>
                  <td role="button"><?php echo $order['order_status_str']; ?></td>
                  <td role="button" title="To track packages while on the go, send UPS an SMS to get the status of your shipment. Simply text your tracking keyword followed by your tracking number to your country SMS number and we'll reply with your shipment status details.">
                    <?php 
                      if($order['tracking_id']=='' or $order['tracking_id']=='None'){
                        echo "We'll Soon provide you an tracking ID ";
                      } else {
                        echo $order['tracking_id'];
                      }
                    ?>    
                  </td>
                </tr>
              <?php  } ?>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>


  <div class="cart-buttons">
    <div class="pull-left">
      <a href="<?php echo SITE_PATH ?>" class="btn btn-secondary">Continue Shopping</a>
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