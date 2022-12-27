<?php
session_start();
require('connection.inc.php');
require('functions.inc.php');

$msg='';
$static_msg='';

// Setting the User
$user_id = get_user($conn)[0]; $loggedin = get_user($conn)[1];

if(!$loggedin){
  header('location:'.SITE_PATH.'login');
}

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


// Handling request for Password change
if(isset($_POST['password_change']))
{
  $curr_password = md5(get_safe_value($conn, $_POST['curr_password']));
  $new_password = md5(get_safe_value($conn, $_POST['new_password']));

  if($curr_password != '' && $new_password != '')
  {
   $sql = "SELECT password from customers where password = '$curr_password' and username = '$user_id'";
   $count = mysqli_num_rows(mysqli_query($conn, $sql));    
   if($count > 0){
    $sql = "UPDATE customers SET password = '$new_password' where username = '$user_id'";
    if(mysqli_query($conn, $sql))
    {
      $msg = "Password updated Successfuly";
      $Static_msg = "Password updated Successfuly";
    }
    else
    {
      $static_msg = "Can't Update your password right Now. Please try later";
    }
   }
   else
   {
    $static_msg = "Password Verification Failed";
   }
  }
  else
  {
      $static_msg = "Blank Field Detected";
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
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="assets/js/custom.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <style type="text/css">
    .add_status{
      position: absolute;
      top: 5%;
      left: 0;
      padding: 5px 10px;
      color: #fff;
      font-size: 15px;
    }
    .add_status_verified{
      background: #008000;
    }
    .add_status_pending{
      background: #FF0000;
    }
  </style>

  <title>My Profile - Electrozon</title>
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
        <p> <a class="fs-14 text-decoration-none fw-bold" href="<?php echo SITE_PATH ?>">home > </a> <a class="fs-14 text-decoration-none text-danger fw-bold" href="#"> My Account </a></p>
        <h2 class="text-dark">Change Account Settings</h2>
        <?php if($msg!='') echo "<script>alertMsg('".$msg."')</script>"; ?>
        <?php if($static_msg!='') echo "<span style='color:red'>**".$static_msg."</span>"; ?>
        <nav class="mt-4">
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Personal Information</a>
            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Change Password</a>
          </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
          
          <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="row mx-3 my-2">
              <!-- Change Account Information -->
              <?php  $user = userProfileData($conn, $user_id);?>
              <form method="POST" class="register_form_resp col-10 p-sml p-light ">
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
                  <button type="submit" name="acc_submit" class="btn btn-dark" style="line-height: 1.1;">Submit</button>
                </div>
              </form>
            </div>
          </div>

          <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <!-- Add New Address Form -->
            <form method="POST" class="my-3">
              <input type="text" name="csrf_token" id="csrf_token" value="<?php echo csrf_token('password_change'); ?>" hidden>
              <div class="row mb-3">
                <div class="col-sm-5">
                  <input type="password" name="curr_password" id="curr_password" class="form-control" placeholder="current password" required>
                  <span id="currpasscheck" ></span>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-sm-5">
                  <input type="password" name="new_password" id="new_password" class="form-control" placeholder="new password" required>
                  <span id="newpasscheck" ></span>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-sm-5">
                  <input type="password" name="confirm_new_password" id="confirm_new_password" class="form-control" placeholder="confirm new password" required>
                  <span id="confirmnewpasscheck" ></span>
                </div>
              </div>

              <button name="password_change" id="password_change" type="submit" class="btn btn-dark" style="line-height: 1.1;">Continue</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Footer Section -->

<?php
require('prerequisite/footer.php');
?>


<script type="text/javascript">
 $(document).ready(function(){

   $('#currpasscheck').hide();
   $('#newpasscheck').hide();
   $('#confirmnewpasscheck').hide();

   var curr_err = true;
   var new_err = true;
   var confirm_err = true;

   $('#curr_password').keyup(function(){
    curr_check();
   });

   $('#new_password').keyup(function(){
    new_check();
   });

   $('#confirm_new_password').keyup(function(){
    confirm_check();
   });


 function curr_check(){
   var user_val = $('#curr_password').val();
   if(user_val.length == ''){
     $('#currpasscheck').show();
     $('#currpasscheck').html("**Please Fill the Current Password");
     $('#currpasscheck').focus();
     $('#currpasscheck').css("color","red");
     curr_err = false;
     return false;
   }else{
     curr_err = true;
     $('#currpasscheck').hide();
   }
 }



 function new_check(){
   var passwrdstr = $('#new_password').val();
     if(passwrdstr.length == ''){
     $('#newpasscheck').show();
     $('#newpasscheck').html("**Please Fill the New Password");
     $('#newpasscheck').focus();
     $('#newpasscheck').css("color","red");
     new_err = false;
     return false;
   }else{
     new_err = true;
     $('#newpasscheck').hide();
   } 

 }

 function confirm_check(){

   var conpass = $('#confirm_new_password').val();
     var passwrdstr = $('#new_password').val();
     if(passwrdstr != conpass){
       $('#confirmnewpasscheck').show();
       $('#confirmnewpasscheck').html("** Password are not Matching");
       $('#confirmnewpasscheck').focus();
       $('#confirmnewpasscheck').css("color","red");
       confirm_err = false;
       return false;
     }else{
       $('#confirmnewpasscheck').hide();
       confirm_err = true;
     } 

 }

 $('#password_change').click(function(){
  curr_err = true;
  new_err = true;
  confirm_err = true;


  curr_check();
  new_check();
  confirm_check();


  if((curr_err == true) && (new_err == true) && (confirm_err == true)){
   return true;
  }else{
   return false;
  }


 });

 });
</script>


</body>
</html>
