<?php
session_start();
require('connection.inc.php');
require('functions.inc.php');


// Setting the User
$user_id = get_user($conn)[0]; $loggedin = get_user($conn)[1];


// Function to Empty Cart
function emptyCart($conn, $username){
   $sql = "DELETE FROM cart WHERE username = '$username'";
   if(mysqli_query($conn,$sql)){
      return true;
   }else{
      return false;
   }
}

// Login User
$msg='';
if(isset($_POST['submit'])){
    $username=get_safe_value($conn,$_POST['username']);
    $password=md5(get_safe_value($conn,$_POST['password']));
    $sql="select * from customers where username = '$username' and password = '$password'";
    $res=mysqli_query($conn, $sql);
    $count=mysqli_num_rows($res); 
    if($username!='' && $password !=''){
      if($count>0){
          $_SESSION['login'] = true;
          $_SESSION['username'] = $username;
          $user_id = get_user($conn)[0]; $loggedin = get_user($conn)[1]; 
      }else{
          $user_id = get_user($conn)[0]; $loggedin = get_user($conn)[1]; 
          $msg='Please enter valid login details';
      }
    }else{
      $msg='Blank Fields detected';
    }
}


// Get user cart Products PID
$cart = getCartPID($conn,$user_id);
$pid=array();
foreach ($cart as $pidData) {
  array_push($pid, $pidData['pid']);
}

// Fetch Products data from PIDs
if(count($pid)>0){
  $products=get_product($conn,'','',$pid);
  $cart_empty=false;
}else{
  header('location:'.SITE_PATH.'cart');
}

// Ftech saved address details of user
$addresses = getAddress($conn,$user_id, 1);


// Creating Session variables for checkout
if(isset($_SESSION['addId'])){
}else{
  $_SESSION['addId']="";
  $_SESSION['payment_method']="";
}

// POST Request Handler
if(isset($_POST['type'])){
    $type=get_safe_value($conn,$_POST['type']);

    // Add Checkout Address Reuqest
    if($type=='address')
    {
      $_SESSION['addId'] = get_safe_value($conn,$_POST['data']);
      foreach ($addresses as $add) {
        if($add['id']==$_SESSION['addId']){
            $_SESSION['address'] = $add['address'];
            $_SESSION['city'] = $add['city'];
            $_SESSION['post_code'] = $add['post_code'];
            $_SESSION['phone_number'] = $add['phone_number'];
            $_SESSION['name'] = $add['name'];
        }
      }
    }

    // Add Checkout Payment Method Reuqest
    if($type=='payment_method')
    {
      $_SESSION['payment_method'] = get_safe_value($conn,$_POST['data']);
      foreach ($addresses as $add) {
        if($add['id']==$_SESSION['addId']){
            $_SESSION['address'] = $add['address'];
            $_SESSION['city'] = $add['city'];
            $_SESSION['post_code'] = $add['post_code'];
            $_SESSION['phone_number'] = $add['phone_number'];
            $_SESSION['name'] = $add['name'];
        }
      }
    }

    // Place Order 
    if($type=='place_order')
    {
      $addId = $_SESSION['addId'];
      $payment_method = $_SESSION['payment_method'];
      $total_price = $_SESSION['total_price'];
      $shipping_amount = $_SESSION['shipping_amount'];
      $_SESSION['username'] = $user_id;
      $crt_time = crt_time();

      $place_order_sql = "INSERT INTO `order`(`username`, `address_id`, `total_price`,`shipping_charge`, `payment_status`, `order_status`, `added_on`) VALUES ('$user_id', '$addId', '$total_price', '$shipping_amount','pending', 1, '$crt_time')";
      
      if(mysqli_query($conn, $place_order_sql)){
        $order_id= mysqli_insert_id($conn);
        foreach ($products as $ps) {
          $p_pid=$ps['id'];
          foreach($cart as $i){ if($i['pid'] == $ps['id']){ echo $p_qty=$i['qty']; } }
          $p_price=$ps['price'];
          $order_detail_sql="INSERT INTO `order_detail`(`order_id`, `product_id`, `qty`, `price`) VALUES ('$order_id', '$p_pid', '$p_qty', '$p_price')";
          mysqli_query($conn, $order_detail_sql);
        }

        $_SESSION['ORDER_ID'] = $order_id;

        emptyCart($conn, $user_id);

        unset($_SESSION['addId']);
        unset($_SESSION['payment_method']);
        unset($_SESSION['address']);
        unset($_SESSION['city']);
        unset($_SESSION['post_code']);
        unset($_SESSION['phone_number']);
        unset($_SESSION['name']);
        
        header('location:'.SITE_PATH.'PaytmKit/pgRedirect.php');
      } else { return false; }
}
}

?>

<!DOCTYPE html>
<html>
<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo SITE_PATH ?>assets/css/style.css" rel="stylesheet">
  <link href="<?php echo SITE_PATH ?>assets/css/preloader.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">  
  <script src="assets/js/custom.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.accordion {
  background-color: #eee;
  color: #444;
  cursor: pointer;
  padding: 18px;
  width: 100%;
  border: none;
  text-align: left;
  outline: none;
  font-size: 15px;
  transition: 0.4s;
}

.active, .accordion:hover {
  background-color: #ccc;
}

.accordion:after {
  content: '\002B';
  color: #777;
  font-weight: bold;
  float: right;
  margin-left: 5px;
}

.active:after {
  content: "\2212";
}

.panel {
  padding: 0 18px;
  background-color: white;
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.2s ease-out;
}
</style>

	<title>ELECTROZON - Checkout</title>

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

<div class="container-fluid p-5 my-3">
  
  <div class="row">
    <div class="content">
      <h2>CHECKOUT</h2>
      <div id="alert-msg" style="background-color: #3d1a54;"></div>
      
    </div>
  </div>

  <div class="row">
    
    <div class="col">
      <div class="accordion" id="accordionExample">

        <div id="accordion">

        <?php if(!$loggedin){ if($msg!=''){ ?> 
          <script>alertMsg('<?php echo $msg; ?>')</script> 
        <?php } ?>

        <!-- Login User before Chekout  -->

            <div class="card">
              <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                  <button class="btn" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  STEP 1: CUSTOMER INFORMATION
                  </button>
                </h2>
              </div>

              <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                  <div class="row chekout_resp" style="margin-top: 20px;">
                    
                    <div class="col">
                      <h4>New Customer</h4>
                      <p class="p-sml p-light">Checkout Options:</p>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="register" id="register" checked>
                        <label class="form-check-label p-light" for="flexRadioDefault2">
                          Register Account
                        </label>
                      </div>
                      <p class="p-sml p-light">By creating an account you will be able to shop faster, be up to date on an order's status, and keep track of the orders you have previously made.</p>
                      <button type="submit" id ="checkout-register" class="btn btn-dark" style="line-height: 1.1;">Continue</button>
                    </div>

                    <div class="col mt-3">
                      <div id="alert-msg" style="background-color: #3d1a54;"></div>
                      <h4>Returning Customer</h4>
                      <p class="p-sml p-light">I am A returning Customer</p>
                      <form method="POST" action="checkout">
                        <div class="mb-3">
                          <label class="form-label">Email address</label>
                          <input type="email" name='username' required class="form-control">
                          <div class="form-text">We'll never share your email with anyone else.</div>
                        </div>
                        <div class="mb-1">
                          <label class="form-label">Password</label>
                          <input type="password" name="password" class="form-control">
                        </div>
                        <a href="<?php echo SITE_PATH?>forgot_password" class="text-decoration-none p-sml text-primary">Forgotten Password</a><br>
                        <button type="submit" name="submit" id="login-checkout"class="btn btn-dark mt-3" style="line-height: 1.1;">Submit</button>
                      </form>
                    </div>

                  </div>
                </div>
              </div>
            </div>

            <p class="acc_disabled">  STEP 2 BILLING DETAILS</p>

            <p class="acc_disabled">  STEP 3: PAYMENT METHODS</p>

            <p class="acc_disabled">  STEP 4: CONFIRM ORDER</p>

        <?php } else if($_SESSION['addId']==''){ ?>

        <!-- Further chekout process After loginned successfully -->

            <p class="acc_disabled">  STEP 1: CUSTOMER INFORMATION</p>

            <!-- Billing Details -->
            <div class="card">
              <div class="card-header" id="headingTwo">
                <h2 class="mb-0">
                  <button class="btn" type="button"data-toggle="collapse"data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    STEP 2: BILLING DETAILS
                    <div id="alert-msg" style="background-color: #3d1a54;"></div>
                  </button>
                </h2>
              </div>

              <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                <div class="card-body">
                  <div class="row">
                    <div class="col">

                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="billing-address-selecter" id="register" value="2" checked>
                        <label class="form-check-label p-light" for="flexRadioDefault2">
                          Select Address
                        </label>
                      </div>

                      <div class="row mx-3 my-2 toHide" id="add-2">
                            <?php if (count($addresses) == 0){ ?>
                              <option selected>No saved address found</option>
                            <?php } else { foreach ($addresses as $address) { ?>

                              <div class="card col-sm-4 me-md-3 my-3" style="width: 18rem;">
                                <div class="card-body">
                                  <h5 class="card-title">
                                    <?php echo "<b>".$address['name']."</b><br>";
                                       echo "<p class='p-sml p-light'>".$address['address']."<br>";
                                       echo $address['post_code']."<br>";
                                       echo $address['phone_number']."<br></p>";?>
                                  </h5>
                                  <a href="#" onclick="AddressData(<?php echo $address['id']; ?>)" class="btn btn-dark">Deliver To this Address</a>
                                </div>
                              </div>


                            <?php } } ?>  

                        
                      </div>

                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="billing-address-selecter" id="register" value="1" >
                        <label class="form-check-label p-light" for="flexRadioDefault2">
                          Add New Address
                        </label>
                      </div>
                      
                      

                      <div class=" toHide"  id="add-1" style="display:none">
                        
                        <p class="p-sml p-light my-2 mx-2">Adding a New Address takes some time for varification for first time. This address will be saved and can be used for future purchases</p>
                        <button type="submit" id ="address-manager" class="btn btn-dark mx-2" style="line-height: 1.1;">Continue</button>
                      </div>



                    </div>
                  </div>
                </div>
              </div>
            </div>

            <p class="acc_disabled">  STEP 3: PAYMENT METHODS</p>

            <p class="acc_disabled">  STEP 4: CONFIRM ORDER</p>

        <?php } else if($_SESSION['payment_method']==''){ ?>


            <p class="acc_disabled">  STEP 1: CUSTOMER INFORMATION</p>

            <!-- Billing Details -->
            <div class="card">
              <div class="card-header" id="headingTwo">
                <h2 class="mb-0">
                  <button class="btn collapsed" type="button"data-toggle="collapse"data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    STEP 2: BILLING DETAILS
                    <div id="alert-msg" style="background-color: #3d1a54;"></div>
                  </button>
                </h2>
              </div>

              <div id="collapseTwo" class="collapse " aria-labelledby="headingTwo" data-parent="#accordion">
                <div class="card-body">
                  <div class="row">
                    <div class="col">

                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="billing-address-selecter" id="register" value="2" checked>
                        <label class="form-check-label p-light" for="flexRadioDefault2">
                          Select Address
                        </label>
                      </div>

                      <div class="row mx-3 my-2 toHide" id="add-2">
                            <?php if (count($addresses) == 0){ ?>
                              <option selected>No saved address found</option>
                            <?php } else { foreach ($addresses as $address) { ?>

                              <div class="card col-sm-4 me-md-3 my-3" style="width: 18rem;">
                                <div class="card-body">
                                  <h5 class="card-title">
                                    <?php echo "<b>".$address['name']."</b><br>";
                                       echo "<p class='p-sml p-light'>".$address['address']."<br>";
                                       echo $address['post_code']."<br>";
                                       echo $address['phone_number']."<br></p>";?>
                                  </h5>
                                  <a href="#" onclick="AddressData(<?php echo $address['id']; ?>)" class="btn btn-dark">Deliver To this Address</a>
                                </div>
                              </div>


                            <?php } } ?>  

                        
                      </div>

                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="billing-address-selecter" id="register" value="1" >
                        <label class="form-check-label p-light" for="flexRadioDefault2">
                          Add New Address
                        </label>
                      </div>
                      
                      

                      <div class=" toHide"  id="add-1" style="display:none">
                        
                        <p class="p-sml p-light my-2 mx-2">Adding a New Address takes some time for varification for first time. This address will be saved and can be used for future purchases</p>
                        <button type="submit" id ="address-manager" class="btn btn-dark mx-2" style="line-height: 1.1;">Continue</button>
                      </div>



                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Payment Confirmation  -->
            <div class="card">
              <div class="card-header" id="headingThree">
                <h2 class="mb-0">
                  <button class="btn " id="payment_method_btn" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                    STEP 3: PAYMENT METHOD
                  </button>
                </h2>
              </div>
              <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordion">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <p class="p-sml p-light">Please select the preferred payment method to use on this order.</p>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" id="netbanking" value="netbanking" checked>
                        <label class="form-check-label p-light" for="flexRadioDefault2">
                          Debit Card, Credit Card, NetBanking, UPI and Wallet
                        </label>
                      </div>

                      <div class="pull-right">
                        <div class="form-check">
                          I have read and agree to the 
                          <b><a href="#" class="product-link">Shipping, Cancellation, Returns & Refund Policy</a></b>
                          <input  type="checkbox" name="TandD" value="TandD" id="TandD">
                          <button  class="btn btn-dark" onclick="PaymentMethod()" style="line-height: 1.1;">Continue</button>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>

            <p class="acc_disabled">  STEP 4: CONFIRM ORDER</p>

        <?php } else { ?>

            <p class="acc_disabled">  STEP 1: CUSTOMER INFORMATION</p>

            <!-- Billing Details -->
            <div class="card">
              <div class="card-header" id="headingTwo">
                <h2 class="mb-0">
                  <button class="btn collapsed" type="button"data-toggle="collapse"data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    STEP 2: BILLING DETAILS
                    <div id="alert-msg" style="background-color: #3d1a54;"></div>
                  </button>
                </h2>
              </div>

              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                <div class="card-body">
                  <div class="row">
                    <div class="col">

                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="billing-address-selecter" id="register" value="2" checked>
                        <label class="form-check-label p-light" for="flexRadioDefault2">
                          Select Address
                        </label>
                      </div>

                      <div class="row mx-3 my-2 toHide" id="add-2">
                            <?php if (count($addresses) == 0){ ?>
                              <option selected>No saved address found</option>
                            <?php } else { foreach ($addresses as $address) { ?>

                              <div class="card col-sm-4 me-md-3 my-3" style="width: 18rem;">
                                <div class="card-body">
                                  <h5 class="card-title">
                                    <?php echo "<b>".$address['name']."</b><br>";
                                       echo "<p class='p-sml p-light'>".$address['address']."<br>";
                                       echo $address['post_code']."<br>";
                                       echo $address['phone_number']."<br></p>";?>
                                  </h5>
                                  <a href="#" onclick="AddressData(<?php echo $address['id']; ?>)" class="btn btn-dark">Deliver To this Address</a>
                                </div>
                              </div>


                            <?php } } ?>  

                        
                      </div>

                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="billing-address-selecter" id="register" value="1" >
                        <label class="form-check-label p-light" for="flexRadioDefault2">
                          Add New Address
                        </label>
                      </div>
                      
                      

                      <div class=" toHide"  id="add-1" style="display:none">
                        
                        <p class="p-sml p-light my-2 mx-2">Adding a New Address takes some time for varification for first time. This address will be saved and can be used for future purchases</p>
                        <button type="submit" id ="address-manager" class="btn btn-dark mx-2" style="line-height: 1.1;">Continue</button>
                      </div>



                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Payment Confirmation  -->
            <div class="card">
              <div class="card-header" id="headingThree">
                <h2 class="mb-0">
                  <button class="btn collapsed" id="payment_method_btn" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    STEP 3: PAYMENT METHOD
                  </button>
                </h2>
              </div>
              <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <p class="p-sml p-light">Please select the preferred payment method to use on this order.</p>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" id="netbanking" value="netbanking" checked>
                        <label class="form-check-label p-light" for="flexRadioDefault2">
                          Debit Card, Credit Card, NetBanking, UPI and Wallet
                        </label>
                      </div>

                      <div class="pull-right">
                        <div class="form-check">
                          I have read and agree to the 
                          <b><a href="#" class="product-link">Shipping, Cancellation, Returns & Refund Policy</a></b>
                          <input  type="checkbox" name="TandD" value="TandD" id="TandD">
                          <button  class="btn btn-dark" onclick="PaymentMethod()" style="line-height: 1.1;">Continue</button>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Order Confirmation  -->
            <div class="card">
              <div class="card-header" id="headingFour">
                <h2 class="mb-0">
                  <button class="btn" id="confirm_order_btn" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                    STEP 4: CONFIRM ORDER
                  </button>
                </h2>
              </div>

              <div id="collapseFour" class="collapse show" aria-labelledby="headingFour" data-parent="#accordion">
                <div class="card-body">
                  <div class="row">
                    <h3><b>Review your order</b></h3>
                    <p class="p-sml p-light">By clicking on the 'Place Your Order and Pay' button, you agree to electrozon.com's privacy notice and condition of use.</p>                      
                  </div>

                  <div class="row m-1 p-1 py-3 chekout_resp">
                    <div class="col-auto mx-3 my-3 p-3 border  rounded">
                      <h5 class="card-title"><b>Shipping Address:</b><br></h5>
                        <?php echo "<b>".$_SESSION['name']."</b><br>";
                           echo "<p class='p-sml p-light'>".$_SESSION['address']."<br>";
                           echo $_SESSION['post_code']."<br>";
                           echo "Phone: ".$_SESSION['phone_number']."<br></p>";?>
                    </div>
                     <div class="col-auto mx-3 my-3 p-3 border rounded">
                      <h5 class="card-title"><b>Payment Method:</b><br></h5>
                        <?php if($_SESSION['payment_method']=='netbanking'){ echo "Debit Card, Credit Card, NetBanking, UPI and Wallet"; }else{ echo "PayTM"; } ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <table class="table table-bordered table_scroll_x" style="margin:25px 0;">
                        <thead>
                          <tr>
                            <th class="p-light p-sml col-sm-7" scope="col">Product Name</th>
                            <th class="p-light p-sml" scope="col">Quantity</th>
                            <th class="p-light p-sml" scope="col">Tax</th>
                            <th class="p-light p-sml" scope="col">Unit Price</th>
                            <th class="p-light p-sml" scope="col">Total</th>
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


                              <td><?php echo $product['name']; ?></td>
                              <td class="p-light p-sml"><?php foreach($cart as $i){ if($i['pid'] == $product['id']){ echo $crt_qty=$i['qty']; } } ?>
                              </td>
                              <td class="p-light p-sml">IGST(18%)</td>
                              <td class="p-light p-sml">
                                <i class="fa fa-inr"></i> <?php echo $product['price']; ?>
                              </td>
                              <td class="p-light p-sml">
                                <i class="fa fa-inr"></i> 
                                <?php 
                                  echo ($product['price']*$crt_qty); 
                                  $checkout_amount+=($product['price']*$crt_qty);
                                  $tax_amount+= ($product['price']*$crt_qty)*(18/100);
                                ?>
                              </td>
                            </tr>
                          <?php } ?>

                        </tbody>
                      </table>

                      <div class="col-md-5 align-right">
                        <table class="table table-borderless caption-top">
                          <caption>Order Summary</caption>
                          <tbody>
                            <tr>
                              <td class="text-right p-light"><strong>Sub-Total:</strong></td>
                              <td class="text-right p-light"><i class="fa fa-inr"></i>  <?php echo $checkout_amount.'.00';  ?></td>
                            </tr>
                            <tr>
                              <td class="text-right p-light"><strong>IGST (18%):</strong></td>
                              <td class="text-right p-light"><i class="fa fa-inr"></i> <?php echo (int) $tax_amount.'.00';  ?></td>
                            </tr>
                            <tr>
                              <td class="text-right p-light"><strong>Shipping Changes:</strong></td>
                              <td class="text-right p-light"><i class="fa fa-inr"></i> <?php $shipping_amount=0; if(($checkout_amount+$tax_amount)<500)$shipping_amount=49; $_SESSION['shipping_amount']=$shipping_amount; echo $shipping_amount;?></td>
                            </tr>
                            <tr>
                              <td class="text-right p-light"><strong>Total:</strong></td>
                              <td class="text-right p-dark"><i class="fa fa-inr"></i> <?php $_SESSION['total_price']=($checkout_amount+$tax_amount+$shipping_amount); echo (int)$_SESSION['total_price'].'.00'; ?></td>
                            </tr>
                            <tr class="text-danger fs-4 fw-bold">
                                <td class="text-right">Order Total:</td>
                                <td class="text-right"><i class="fa fa-inr"></i><?php echo (int)$_SESSION['total_price'].'.00'; ?></td>
                            </tr>
                            <tr>
                              <form method="post">
                                <td colspan="2"><center><button class="btn btn-dark" type="submit" name="type" value="place_order" style="line-height: 1.1;width: 100%;background: #215c90;">Place Your Order</button></center></td></form>
                            </tr>      
                          </tbody>
                        </table>
                      </div>

                      <!-- <div class="pull-right">
                        <div class="form-check">
                          <button class="btn btn-dark" id="place_order_btn" style="line-height: 1.1;">Place Order</button>
                        </div>
                      </div> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>

        <?php } ?>

      </div>
    </div>

    </div>
  </div>
</div>


<!-- Checkout Confirmation Modal -->


<!-- Footer Section -->

<?php
require('prerequisite/footer.php');
?>


<script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  });
}
</script>
</body>
</html>


