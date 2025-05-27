<?php
session_start();
require('connection.inc.php');
require('functions.inc.php');

$user_id = get_user($conn)[0]; $loggedin = get_user($conn)[1];
$cart = getCartPID($conn,$user_id);
$pid=array();
foreach ($cart as $pidData) {
  array_push($pid, $pidData['pid']);
}
if(count($pid)>0){
  $products=get_product($conn,'','',$pid);
  $cart_empty=false;
}else{
  $cart_empty=true;
}
?>

<!DOCTYPE html>
<html>
<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo SITE_PATH ?>assets/css/theme.css" rel="stylesheet">
  <link href="<?php echo SITE_PATH ?>assets/css/style.css" rel="stylesheet">
  <link href="<?php echo SITE_PATH ?>assets/css/preloader.css" rel="stylesheet">
  <link href="<?php echo SITE_PATH ?>assets/css/header.css" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="HandheldFriendly" content="true">
	<title>Electrozon - Cart</title>

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

<!-- Main Body Section -->

<p class="mt-2" > <a class="fs-14 ms-5 text-decoration-none fw-bold" href="<?php echo SITE_PATH ?>">Home > </a> <a class="fs-14 text-decoration-none text-danger fw-bold" href="#"> Cart </a></p>

<?php if(!$cart_empty){ ?>

<!-- Full View Cart -->
<section id="cart_full_view">

  <div class="container" style="padding: 50px 0;">
    <div class="row">
      <div class="content">
        <h1>Shopping Cart</h1>
        <div id="alert-msg" style="background-color: #3d1a54;"></div>
        <form action="#" method="POST">
          <table class="table table-bordered" style="margin:25px 0;">
            <caption>List of users</caption>
            <thead>
              <tr>
                <th scope="col">Image</th>
                <th scope="col" style="width: 650px;">Product Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Unit Price</th>
                <th scope="col">Total</th>
              </tr>
            </thead>
            <tbody>

              <?php 
                $i=0;
                $checkout_amount=0;
                $tax_amount=0;
                foreach ($products as $product) {
              ?>
                <tr style="vertical-align: baseline;">

                  <td>
                    <a href="<?php echo SITE_PATH; ?>product/<?php echo $product['id']; ?>"><img style="max-width: 85px;" src="<?php echo PRODUCT_IMAGE_SITE_PATH.$product['image'];?> "></a>
                  </td>

                  <td><a class="link" href="<?php echo SITE_PATH; ?>product/<?php echo $product['id']; ?>"><?php echo $product['name']; ?></a></td>
                  
                  <td>
                    <?php foreach($cart as $i){ if($i['pid'] == $product['id']){ $crt_qty=$i['qty']; } } ?>
                    <select id="val1<?php echo $product['id']; ?>"  onchange="update_val(<?php echo $product['id'] ?>,<?php echo $product['qty'] ?>, 'val1')" class="form-select form-select-sm mb-3" aria-label=".form-select-lg example">
                        <option selected><?php echo $crt_qty; ?></option>
                      <?php for($n=1; $n<=$product['qty']; $n++ ){ ?>
                        <option value="<?php echo $n; ?>"><?php echo $n; ?></option>
                      <?php } ?>
                    </select>
                  </td>

                  <td>
                    <i class="fa fa-inr"></i> <?php echo $product['price']; ?>
                  </td>
                  <td>
                    <i class="fa fa-inr"></i> 
                    <?php 
                      echo ($product['price']*$crt_qty); 
                      $checkout_amount+=($product['price']*$crt_qty);;
                    ?>
                  </td>
                  <td> 
                    <a onclick="removeCart(<?php echo $product['id'] ?>)" class="cart-remove-btn"><i class="fa fa-trash"></i></a> 
                  </td>
                </tr>
              <?php } ?>

            </tbody>
          </table>
        </form>
      </div>
    </div>
  </div>

<?php $shipping_amount = shipping_charge($checkout_amount); ?>

  <div class="row"  style="margin-right: auto;">
    <div class="col-sm-4 align-right">
      <table class="table table-bordered">
        <tbody>
          <tr>
            <td class="text-right"><strong>Sub-Total:</strong></td>
            <td class="text-right"><i class="fa fa-inr"></i>  <?php echo $checkout_amount;  ?></td>
          </tr>
          <?php if($shipping_amount!=''){ ?>
          <tr>
            <td class="text-right"><strong>Shipping Charges:</strong></td>
            <td class="text-right"><i class="fa fa-inr"></i> <?php  echo $shipping_amount;?></td>
          </tr>
          <?php } ?>
          <tr>
            <td class="text-right"><strong>Total:</strong></td>
            <td class="text-right"><i class="fa fa-inr"></i> <?php $checkout_amount+=$shipping_amount; echo (int) $checkout_amount;?></td>
          </tr>    
        </tbody>
      </table>
    </div>
  </div>


  <div class="cart-buttons">
    <div class="pull-left">
      <a href="<?php echo SITE_PATH ?>" class="btn btn-secondary">Continue Shopping</a>
    </div>
    <div class="pull-right">
      <a href="<?php echo SITE_PATH ?>checkout" class="btn btn-dark">Checkout</a>
    </div>
  </div>
</section>

<!-- Responsive Cart Section -->
<section class="container p-0 " id="cart_resp">

  <div class="row mt-3 ps-2">
    <h1>Shopping Cart</h1>
  </div>

  <?php $i = $checkout_amount = $tax_amount = 0; foreach ($products as $product) { ?>
    <!-- Product Tile -->
    <div class="prdct-card ps-2 pe-2 border" style="background: #fff; margin-bottom: 15px;">
      <!-- Image and Product Title  -->
      <div class="row mt-3 py-2">
        <div class="col-8 overflow-hidden" style="height: 50px;"> <?php echo $product['name']; ?> </div>
        <div class="col-3"> <img style="max-width: 85px;" src="<?php echo PRODUCT_IMAGE_SITE_PATH.$product['image'];?> "> </div>
      </div>
      <!-- Price and QTY Control -->
      <div class="row py-2">
        <?php foreach($cart as $i){ if($i['pid'] == $product['id']){ $crt_qty=$i['qty']; } } ?>

        <div class="col-8">
          <?php 
            echo "<span class='p-dark'><i class='fa fa-inr'></i>".($product['price'])."</span>";
            $checkout_amount+=($product['price']*$crt_qty);
          ?>
        </div>
        
        <div class="col-4"> 
          <select id="val2<?php echo $product['id']; ?>"  onchange="update_val(<?php echo $product['id'] ?>,<?php echo $product['qty'] ?>, 'val2')" class="form-select form-select-sm mb-3" aria-label=".form-select-lg example">
              <option selected>QTY: <?php echo $crt_qty; ?></option>
            <?php for($n=1; $n<=$product['qty']; $n++ ){ ?>
              <option value="<?php echo $n; ?>"><?php echo $n; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <!-- Remove btn -->
      <div class="row py-2 d-flex ">
        <div class="col-auto pe-3"><a onclick="removeCart(<?php echo $product['id'] ?>)" class="cart-remove-btn"><i class="fa fa-trash"></i> REMOVE</a></div> 
      </div>
    </div>
  <?php } ?>


  <div class="row mt-3 border" style="background: #fff;">
    <div class="col-sm-6 align-left">
      <table class="table table-hover">
        <tbody>
          <tr>
            <td class="text-right p-light" colspan="2"><strong>PRICE DETAILS</strong></td>
          </tr>
          <tr>
            <td class="text-right"><strong>Sub-Total:</strong></td>
            <td class="text-right"><i class="fa fa-inr"></i>  <?php echo $checkout_amount;  ?></td>
          </tr>
          <?php if($shipping_amount!=''){ ?>
          <tr>
            <td class="text-right"><strong>Shipping Charges:</strong></td>
            <td class="text-right"><i class="fa fa-inr"></i> <?php echo $shipping_amount;?></td>
          </tr>
        <?php } ?>
          <tr>
            <td class="text-right"><strong>Total:</strong></td>
            <td class="text-right"><i class="fa fa-inr"></i><?php $checkout_amount+=$shipping_amount; echo (int) $checkout_amount;?></td>
          </tr> 
        </tbody>
      </table>
    </div>
  </div>

  <center class="p-sml p-light my-3"><i class="fa fa-shield" aria-hidden="true"></i> Safe and secure payments. Easy returns. 100% Auhentic products.</center>

  <div class="row mt-3 ps-4 py-2 border" style="background: #fff;">
    <div class="col-7 p-dark fs-2"><i class="fa fa-inr"></i> <?php echo (int) ($checkout_amount+$tax_amount);?> </div>
    <div class="col-5"><a href="<?php echo SITE_PATH ?>checkout" class="btn btn-warning">Checkout</a></div>
  </div>

</section>


<?php }else{ ?>

<div class="cart-empty-alert">
  <p>
    </p><center><img src="assets/images/shopping_empty.png" style="width: 250px;" alt="Shopping Cart Empty"></center>
  <p></p>
  <p style="font-size: 19px; text-align: center; text-transform: initial;">Your Shopping Cart is Empty</p>
  <p style="font-size: 16px; text-align: center;">Add items to it now.</p>
  <center><a href="<?php echo SITE_PATH ?>" class="btn btn-dark">Shop Now</a></center>
</div>

<?php }?>


<!-- Footer Section -->

<?php
require('prerequisite/footer.php');
?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="assets/js/custom.js"></script>


</body>
</html>

