<?php
session_start();
require('connection.inc.php');
require('functions.inc.php');


// Setting the User
$user_id = get_user($conn)[0]; $loggedin = get_user($conn)[1];

https://github.com/rohitkrtiwari/
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
    $sql="SELECT * from customers where username = '$username' and password = '$password'";
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


    // Place Order 
    if($type=='place_order')
    {
      $addId = $_SESSION['addId'];
      $total_price = $_SESSION['total_price'];
      $shipping_amount = $_SESSION['shipping_amount'];
      $crt_time = crt_time();

      $userArr = userProfileData($conn, $_SESSION['user_id']);
      $name = $userArr[0]['fname'];
      $number = $userArr[0]['mobile'];

      $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);

      $place_order_sql = "INSERT INTO `order`(`username`, `address_id`, `total_price`,`shipping_charge`, `payment_status`, `order_status`, `added_on`, `txnid`) VALUES ('$user_id', '$addId', '$total_price', '$shipping_amount', 'pending', 2, '$crt_time', '$txnid')";
      
      if(mysqli_query($conn, $place_order_sql)){
        $order_id= mysqli_insert_id($conn);
        foreach ($products as $ps) {
          $p_pid=$ps['id'];
          foreach($cart as $i){ if($i['pid'] == $ps['id']){ echo $p_qty=$i['qty']; } }
          $p_price=$ps['price'];
          $order_detail_sql="INSERT INTO `order_detail`(`order_id`, `product_id`, `qty`, `price`) VALUES ('$order_id', '$p_pid', '$p_qty', '$p_price')";
          mysqli_query($conn, $order_detail_sql);
        }

        make_payment($txnid, $total_price, $_SESSION['name'], $user_id, $_SESSION['phone_number']);

      } else { return false; }
}
}



function make_payment($txnid, $total_price, $name, $username, $phone){
  $MERCHANT_KEY = "key"; 
  $SALT = "key";
  $hash_string = '';
  //$PAYU_BASE_URL = "https://secure.payu.in";
  $PAYU_BASE_URL = "https://test.payu.in";
  $action = '';
  $posted = array();
  if(!empty($_POST)) {
    foreach($_POST as $key => $value) {    
      $posted[$key] = $value; 
    }
  }
  $formError = 0;
  $posted['txnid']=$txnid;
  $posted['amount']=$total_price;
  $posted['firstname']=$name;
  $posted['email']=$username;
  $posted['phone']=$phone;
  $posted['productinfo']="productinfo";
  $posted['key']=$MERCHANT_KEY ;
  $hash = '';
  $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
  if(empty($posted['hash']) && sizeof($posted) > 0) {
    if(
            empty($posted['key'])
            || empty($posted['txnid'])
            || empty($posted['amount'])
            || empty($posted['firstname'])
            || empty($posted['email'])
            || empty($posted['phone'])
            || empty($posted['productinfo'])
           
    ) {
      $formError = 1;
    } else {    
    $hashVarsSeq = explode('|', $hashSequence);
    foreach($hashVarsSeq as $hash_var) {
        $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
        $hash_string .= '|';
      }
      $hash_string .= $SALT;
      $hash = strtolower(hash('sha512', $hash_string));
      $action = $PAYU_BASE_URL . '/_payment';
    }
  } elseif(!empty($posted['hash'])) {
    $hash = $posted['hash'];
    $action = $PAYU_BASE_URL . '/_payment';
  }

  try{
    unset($_SESSION['addId']);
    unset($_SESSION['payment_method']);
    unset($_SESSION['address']);
    unset($_SESSION['city']);
    unset($_SESSION['post_code']);
    unset($_SESSION['phone_number']);
    unset($_SESSION['name']);
  }
  catch (Exception $e){
    // echo $e
  }

  $formHtml ='<form method="post" name="payuForm" id="payuForm" action="'.$action.'"><input type="hidden" name="key" value="'.$MERCHANT_KEY.'" /><input type="hidden" name="hash" value="'.$hash.'"/><input type="hidden" name="txnid" value="'.$posted['txnid'].'" /><input name="amount" type="hidden" value="'.$posted['amount'].'" /><input type="hidden" name="firstname" id="firstname" value="'.$posted['firstname'].'" /><input type="hidden" name="email" id="email" value="'.$posted['email'].'" /><input type="hidden" name="phone" value="'.$posted['phone'].'" /><textarea name="productinfo" style="display:none;">'.$posted['productinfo'].'</textarea><input type="hidden" name="surl" value="https://electrozon.in/payment_complete.php" /><input type="hidden" name="furl" value="https://electrozon.in/payment_fail.php"/><input type="submit" style="display:none;"/></form>';

  echo $formHtml;
  
  echo '<script>document.getElementById("payuForm").submit();</script>';
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
                          <input type="email" name='username' id="email" required class="form-control">
                          <div class="form-text">We'll never share your email with anyone else.</div>
                            <span id="emailcheck" ></span>
                        </div>
                        <div class="mb-1">
                          <label class="form-label">Password</label>
                          <input type="password" name="password" id="password" class="form-control">
                           <span id="passcheck" ></span>
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

            <p class="acc_disabled">  STEP 3: CONFIRM ORDER</p>

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

            <p class="acc_disabled">  STEP 3: CONFIRM ORDER</p>


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

            <!-- Order Confirmation  -->
            <div class="card">
              <div class="card-header" id="headingThree">
                <h2 class="mb-0">
                  <button class="btn" id="confirm_order_btn" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                    STEP 3: CONFIRM ORDER
                  </button>
                </h2>
              </div>

              <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordion">
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
                        <?php echo "Debit Card, Credit Card, NetBanking, UPI and Wallet"; ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <table class="table table-bordered table_scroll_x" style="margin:25px 0;">
                        <thead>
                          <tr>
                            <th class="p-light p-sml col-sm-7" scope="col">Product Name</th>
                            <th class="p-light p-sml" scope="col">Quantity</th>
                            <th class="p-light p-sml" scope="col">Unit Price</th>
                            <th class="p-light p-sml" scope="col">Total</th>
                          </tr>
                        </thead>
                        <tbody>

                          <?php 
                            $i=0;
                            $checkout_amount=0;
                            foreach ($products as $product) {
                          ?>
                            <tr style="vertical-align: baseline;">


                              <td><?php echo $product['name']; ?></td>
                              <td class="p-light p-sml"><?php foreach($cart as $i){ if($i['pid'] == $product['id']){ echo $crt_qty=$i['qty']; } } ?>
                              </td>
                              <td class="p-light p-sml">
                                <i class="fa fa-inr"></i> <?php echo $product['price']; ?>
                              </td>
                              <td class="p-light p-sml">
                                <i class="fa fa-inr"></i> 
                                <?php 
                                  echo ($product['price']*$crt_qty); 
                                  $checkout_amount+=($product['price']*$crt_qty);
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

<?php $shipping_amount = shipping_charge($checkout_amount); $_SESSION['shipping_amount']=$shipping_amount;?>
                            
                            <?php if($shipping_amount!=''){ ?>
                            <tr>
                              <td class="text-right p-light"><strong>Shipping Charges:</strong></td>
                              <td class="text-right p-light"><i class="fa fa-inr"></i> <?php echo $shipping_amount;?></td>
                            </tr>
                            <?php } ?>

                            <tr>
                              <td class="text-right p-light"><strong>Total:</strong></td>
                              <td class="text-right p-dark"><i class="fa fa-inr"></i> <?php $_SESSION['total_price']=($checkout_amount+$shipping_amount); echo (int)$_SESSION['total_price'].'.00'; ?></td>
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
<script type="text/javascript">
 $(document).ready(function(){

   $('#emailcheck').hide();
   $('#passcheck').hide();

   var email_err = true;
   var pass_err = true;

   $('#email').keyup(function(){
    email_check();
   });

   $('#password').keyup(function(){
    password_check();
   });


 function email_check(){
   var user_val = $('#email').val();
   if(user_val.length == ''){
     $('#emailcheck').show();
     $('#emailcheck').html("**Please Fill the Email Address");
     $('#emailcheck').focus();
     $('#emailcheck').css("color","red");
     email_err = false;
     return false;
   }else{
     email_err = true;
     $('#emailcheck').hide();
   }
 }



 function password_check(){
   var passwrdstr = $('#password').val();
     if(passwrdstr.length == ''){
     $('#passcheck').show();
     $('#passcheck').html("**Please Fill the password");
     $('#passcheck').focus();
     $('#passcheck').css("color","red");
     pass_err = false;
     return false;
   }else{
     pass_err = true;
     $('#passcheck').hide();
   } 

 }

 $('#login-checkout').click(function(){
  email_err = true;
  pass_err = true;


  email_check();
  password_check();


  if((email_err == true) && (pass_err == true)){
   return true;
  }else{
   return false;
  }


 });

 });
</script>
</body>
</html>



