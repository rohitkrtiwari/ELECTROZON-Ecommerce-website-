<?php
session_start();
require('connection.inc.php');
require('functions.inc.php');

$msg='';
$static_msg = '';

// Function to verifiy is user can use password reset right now 
function user_can_reset($conn, $user_id){
  // Check for Requests Made Withing 24 Hours 
  $sql = "SELECT * FROM password_reset WHERE username = '$user_id' AND email_sent = 1 AND created_at >= now() - INTERVAL 24 HOUR";
  $count = mysqli_num_rows(mysqli_query($conn, $sql));
  if($count > 5)
    return false;
  else
  {
    if(user_changed_password($conn, $user_id))
    {
      return false;
    }
    else
      return true;
  }
}


// Fuction to check if user has recently changed his password 
function user_changed_password($conn, $user_id){
  // Check password changed within 24 hours 
  $sql = "SELECT * FROM password_reset WHERE username = '$user_id' AND email_sent = 1 and used = 1 AND created_at >= now() - INTERVAL 24 HOUR";
  $count = mysqli_num_rows(mysqli_query($conn, $sql));
  if($count > 0)
    return true;
  else
    return false;
}

$user_id = get_user($conn)[0]; $loggedin = get_user($conn)[1];
if(!$loggedin){
  header('location:'.SITE_PATH.'');
}


$userProfileData = userProfileData($conn, $user_id);

// Get the route of the addressa
$route='';
if(isset($_GET['route']) && $_GET['route']!='') { $route = get_safe_value($conn, $_GET['route']); }


// Handling request for account basic details change
if(isset($_POST['acc_submit']))
{
  $fname = get_safe_value($conn, $_POST['fname']);
  $lname = get_safe_value($conn, $_POST['lname']);
  $mobile = get_safe_value($conn, $_POST['mobile']);

  if($fname != '' && $lname != '' && $mobile != '')
  {
    $sql = "UPDATE  customers SET fname = '$fname', lname = '$lname', mobile = '$mobile' where username = '$user_id'";
    $res = mysqli_query($conn, $sql);
    if($res){
      $msg = "You Account Information have been updated succesfully";
    }    
  }
  else
  {
      $msg = "Blank Field Detected";
  }

}

// Handle password change request
if(isset($_POST['change_password']))
{
  $csrf_token = get_safe_value($conn, $_POST['csrf_token']);
  if($_SESSION['csrf_token']['change_password']  == $csrf_token)
  {
    if(user_can_reset($conn, $user_id))
    {

      $token = bin2hex(random_bytes(50));
        if(SendPasswordResetMail($user_id, $token))
        {
          $sql="INSERT INTO password_reset(username, reset_token, used, email_sent) VALUES('$user_id','$token', 0, 1)";

        if(mysqli_query($conn, $sql)){
          $msg = "Password Reset Mail Sent to ".$user_id;
        }

        else
          $msg = "Can't Connect the the server... Please try later";
      }
      else
        $msg = "Can't Connect the the server... Please try later";
    }
    else
    { 
      if(user_changed_password($conn, $user_id))
      {
        $static_msg = "You've recently changed your password. Please try after 24 Hours";
      }
      else
      {
        $static_msg = 'mailed';
      }
    }
  }
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
	<script src="<?php echo SITE_PATH; ?>assets/js/custom.js"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>Electrozon - My Account</title>
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


<section class="category_full_view d-flex prdct-image">
<!-- Left Side My Account Menu -->
    <div class="grid-view w-25 w-100_resp prdct_full_view">
      <div class="list-group mt-4">
         
         <a type="button" href="<?php echo SITE_PATH ?>my_account" class="list-group-item list-group-item-action <?php if($route == '') echo 'active';?>">My Account</a>
         
         <a type="button" href="<?php echo SITE_PATH ?>my_account/edit_account" class="list-group-item list-group-item-action <?php if($route == 'edit_account') echo 'active';?>">Edit Account</a>
         
         <a type="button" href="<?php echo SITE_PATH ?>my_account/edit_password" class="list-group-item list-group-item-action <?php if($route == 'edit_password') echo 'active';?>">Password</a>
         
         <a type="button" href="<?php echo SITE_PATH ?>address_manager" class="list-group-item list-group-item-action">Address Book</a>
         
         <a type="button" href="<?php echo SITE_PATH ?>my_order" class="list-group-item list-group-item-action">Order History</a>
         
         <a type="button" href="<?php echo SITE_PATH ?>logout" class="list-group-item list-group-item-action">Logout</a>
      
      </div>
    </div>


    <?php if($route == 'edit_account'){ $user = userProfileData($conn, $user_id);?>

      <!-- Account basic details uodate page -->
      <section class="grid-view ms-0 px-2 w-75" id="product_resp_view">
        <div class="container-xxl">
          <div id="alert-msg" style="background-color: #3d1a54;"></div>

          <?php if($msg!='') echo "<script>alertMsg('".$msg."')</script>"; ?>

          <div class="col m-4 mt-2 register_resp">
          <span class="fs-2 mb-3">My Account Information</span>
            <div id="alert-msg" style="background-color: #3d1a54;"></div>
            <form method="POST" class="register_form_resp col-10 p-sml p-light ">
              <span class="fs-4 mb-3">Your Personal Details</span>
              <div class="mb-3 row border-top pt-3">
                <label class="col-sm-2 text-end resp_lable_left col-form-label">First name</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" value="<?php echo $user[0]['fname']; ?>" name="fname" >
                </div>
              </div>
              <div class="mb-3 row ">
                <label class="col-sm-2 text-end resp_lable_left col-form-label">Last name</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" value="<?php echo $user[0]['lname']; ?>" name="lname" >
                </div>
              </div>
              <div class="mb-3 row ">
                <label class="col-sm-2 text-end resp_lable_left col-form-label">Mobile Number</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" value="<?php echo $user[0]['mobile']; ?>" name="mobile" >
                </div>
              </div>

              <div class="col-12 ">            
                <a type="submit" name="acc_submit" class="btn btn-secondary" href="<?php echo SITE_PATH; ?>my_account" style="line-height: 1.1;">Back</a>
                <button type="submit" name="acc_submit" class="btn btn-dark pull-right" style="line-height: 1.1;">Submit</button>
              </div>
            </form>
          </div>

        </div>
      </section>

    <?php }elseif ($route == 'edit_password') 
      {  ?>

      <!-- Password Reset Page -->
      <section class="grid-view ms-0 px-2 w-75" id="product_resp_view">
        <div class="container-xxl">
          <div id="alert-msg" style="background-color: #3d1a54;"></div>

          <?php if($msg!='') echo "<script>alertMsg('".$msg."')</script>"; ?>

          <div class="col m-4 mt-2 register_resp">
          <span class="fs-2 mb-3">Password Change </span>
            <div id="alert-msg" style="background-color: #3d1a54;"></div>
              
            <?php 
          if(user_can_reset($conn, $user_id)){ ?>

              <p class="fs-5 mt-1">1. Request Password Change Link</p>
              <p class="p-sml p-light">By clicking on the reset password button, you'll get an email containing a link to link to reset this account's password.</p>

              <form method="POST">
                <input type="text" hidden name="csrf_token" value="<?php echo csrf_token('change_password') ?>">
                <button class="btn view_all_btn mt-3" name="change_password" type="submit">RESET PASSWORD</button>
              </form>

              <?php } elseif(user_changed_password($conn, $user_id)) { ?>

                <p class="fs-5 mt-1">2. Check email for reset link</P>
                <p class="p-sml p-light">An email has been sent to the administrative email address on file. Check the inbox of the administrative's email account, and click the reset link provided</p>
                <p class="p-sml p-light">The link will expire after 30 mins</p>
                
              <?php } else { ?>

                <center>
                  <span class="fs-2 mb-3">Forgot Password </span>
                      <div id="alert-msg" style="background-color: #3d1a54;"></div>           
                    <p class="text-danger">**<?php echo $static_msg; ?></p>
                </center>
                
              <?php } ?>


          </div>

        </div>
      </section>

    <?php } else { ?>

      <!-- My Account HOME Page -->
      <section class="grid-view ms-0 px-2 w-75" id="product_resp_view">
        <div class="container-fluid px-4">
          <div class="row">
            <div class="col-auto">
              <a class="d-block text-decoration-none text-dark fs-3" href="">My Account</a>
                <a class="d-block text-decoration-none text-dark" href="<?php echo SITE_PATH ?>my_account/edit_account">Edit your account information</a>
                
                <a class="d-block text-decoration-none text-dark" href="<?php echo SITE_PATH ?>my_account/edit_password">Change your password</a>
                <a class="d-block text-decoration-none text-dark" href="<?php echo SITE_PATH ?>address_manager">Modify your address book entries</a>

              <a href="<?php echo SITE_PATH ?>my_order.php" class="mt-3 d-block text-decoration-none text-dark fs-3">My Orders</a>
                <a class="d-block text-decoration-none text-dark" href="<?php echo SITE_PATH ?>my_order">View your order history</a>
            </div>
            <div class="col-auto">
              
            </div>
          </div>
        </div>
      </section>

    <?php } ?>

</section>
<!-- Footer Section -->

<?php
require('prerequisite/footer.php');
?>

</body>
</html>