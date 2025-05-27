<?php
session_start();
require('connection.inc.php');
require('functions.inc.php');

$errors = array();
$msg='';
$user_id = get_user($conn)[0]; $loggedin = get_user($conn)[1];

if(!$loggedin)
{
    // REGISTER USER
    if(isset($_POST['submit']))
    {
        if($_POST['fname']!='' && $_POST['lname']!='' && $_POST['email']!='' && $_POST['mobile']!='' && $_POST['password']!='')
        {

            // receive all input values from the form
            $fname = get_safe_value($conn,$_POST['fname']);
            $lname = get_safe_value($conn,$_POST['lname']);
            $email = get_safe_value($conn,$_POST['email']);
            $mobile = get_safe_value($conn,$_POST['mobile']);
            $password = md5(get_safe_value($conn,$_POST['password']));
            $created_on = crt_time();

            // form validation: ensure that the form is correctly filled ...
            // by adding (array_push()) corresponding error unto $errors array
            if(empty($fname)) { array_push($errors, "Please Enter your first name"); }
            if(empty($lname)) { array_push($errors, "Please Enter your last name"); }
            if(empty($email)) { array_push($errors, "Please Enter your Email"); }
            if(empty($mobile)) { array_push($errors, "Please Enter your Mobile"); }
            if(empty($password)) { array_push($errors, "Please Enter your New Password"); }

            // first check the database to make sure 
            // a user does not already exist with the same username and/or email
            if(count($errors)==0)
            {
                $user_check_query = "CALL tbl_ValidateExistingUser('$email')";
                $result = mysqli_query(conn(), $user_check_query);
                $row = mysqli_num_rows($result);
                if($row != 0){
                    $msg = "This email is already registered";
                    array_push($errors, "The Email is Aleardy Registered.");
                }
            }

            // Preced Register if No Errors
            if(count($errors)==0)
            {
                $token = bin2hex(random_bytes(50));
                if(SendVerificationMail($email, $token))
                { 
                  $sql="insert into customers(fname,lname,username,mobile,password,created_on,status, token) values('$fname','$lname','$email','$mobile','$password','$created_on','0', '$token')";
                  $res = mysqli_query(conn(), $sql);
                  if($res)
                  {
                    header('location:'.SITE_PATH.'info.php?msg='.EMAIL_VERIFICATION);
                  }

                }
                else
                {
                    echo '<script>alert("Can not make the registration request now, Try again...")</script>';
                }
            }
        }
        else
        {
            array_push($errors, "Blank Field Detected");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo SITE_PATH ?>assets/css/theme.css" rel="stylesheet">
  <link href="<?php echo SITE_PATH ?>assets/css/style.css" rel="stylesheet">
  <link href="<?php echo SITE_PATH ?>assets/css/preloader.css" rel="stylesheet">
  <link href="<?php echo SITE_PATH ?>assets/css/header.css" rel="stylesheet">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="HandheldFriendly" content="true">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="<?php echo SITE_PATH; ?>assets/js/custom.js"></script>

    <title>Electrozon Registration</title>
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



<section class="grid-view" id="product_resp_view">
  <div class="container-xxl">
    <div id="alert-msg" style="background-color: #3d1a54;"></div>

    <?php
      if(!empty($errors)){
          foreach ($errors as $error) {
              echo "<script>alertMsg('".$error."')</script>";
          }
      }
    ?>
    <?php if($msg!='') echo "<script>alertMsg('".$msg."')</script>"; ?>

    <div class="col m-4 register_resp">
    <span class="fs-1 mb-3">Register Account</span>
      <div id="alert-msg" style="background-color: #3d1a54;"></div>
      <p class="p-sml p-light">If you already have an account with us, please login at the <a class="text-dark text-decoration-none" href="<?php echo SITE_PATH ?>login.php">login page.</a></p>
      <form method="POST" class="register_form_resp col-10 p-sml p-light ">
        <span class="fs-4 mb-3">Your Personal Details</span>
        <div class="mb-3 row border-top pt-3">
          <label class="col-sm-2 text-end resp_lable_left col-form-label">First name</label>
          <div class="col-sm-10">
            <input type="text"  class="form-control" name="fname" id="fname">
            <span id="fnamecheck" ></span>
          </div>
        </div>
        <div class="mb-3 row ">
          <label class="col-sm-2 text-end resp_lable_left col-form-label">Last name</label>
          <div class="col-sm-10">
            <input type="text"  class="form-control" name="lname" id="lname">
            <span id="lnamecheck" ></span>
          </div>
        </div>
        <div class="mb-3 row ">
          <label class="col-sm-2 text-end resp_lable_left col-form-label">Email</label>
          <div class="col-sm-10">
            <input type="email"  class="form-control" name="email" id="email">
            <span id="emailcheck" ></span>
          </div>
        </div>
        <div class="mb-3 row ">
          <label class="col-sm-2 text-end resp_lable_left col-form-label">Mobile Number</label>
          <div class="col-sm-10">
            <input type="text"  class="form-control" name="mobile" id="mobile">
            <span id="mobilecheck" ></span>
          </div>
        </div>

        <span class="fs-4 mb-3">Your Password</span>
        <div class="mb-3 row border-top pt-3">
          <label class="col-sm-2 text-end resp_lable_left col-form-label">Create Password</label>
          <div class="col-sm-10">
            <input type="password"  class="form-control" id="password" autocomplete="new-password"  name="password">
            <span id="passcheck" ></span>
          </div>
        </div>
        <div class="mb-3 row ">
          <label class="col-sm-2 text-end resp_lable_left col-form-label">Confirm Pasword</label>
          <div class="col-sm-10">
            <input type="password"  class="form-control" id="cnf_password" name="cnf_password">
            <span id="conpasscheck" ></span>
          <input type="submit" name="submit" id="register_btn" class="float-end btn btn-dark mt-3" style="line-height: 1.1;">
          </div>
        </div>
      </form>
    </div>

  </div>
</section>


<!-- Footer Section -->

<?php
require('prerequisite/footer.php');
?>




<script type="text/javascript">
 $(document).ready(function(){

   $('#fnamecheck').hide();
   $('#lnamecheck').hide();
   $('#mobilecheck').hide();
   $('#emailcheck').hide();
   $('#passcheck').hide();
   $('#conpasscheck').hide();

   var fname_err = true;
   var lname_err = true;
   var email_err = true;
   var mobile_err = true;
   var pass_err = true;
   var conpass_err = true;

   $('#fname').keyup(function(){
    fname_check();
   });

   $('#lname').keyup(function(){
    lname_check();
   });

   $('#email').keyup(function(){
    email_check();
   });

   $('#mobile').keyup(function(){
    mobile_check();
   });

   $('#password').keyup(function(){
    password_check();
   });

   $('#cnf_password').keyup(function(){
    con_passwrd();
   });


 function fname_check(){
   var user_val = $('#fname').val();
   if(user_val.length == ''){
     $('#fnamecheck').show();
     $('#fnamecheck').html("**Please Fill the First Name");
     $('#fnamecheck').focus();
     $('#fnamecheck').css("color","red");
     fname_err = false;
     return false;
   }else{
     fname_err = true;
     $('#fnamecheck').hide();
   }
 }

 function lname_check(){
   var user_val = $('#lname').val();
   if(user_val.length == ''){
     $('#lnamecheck').show();
     $('#lnamecheck').html("**Please Fill the Last Name");
     $('#lnamecheck').focus();
     $('#lnamecheck').css("color","red");
     lname_err = false;
     return false;
   }else{
     lname_err = true;
     $('#lnamecheck').hide();
   }
 }

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

 function mobile_check(){
   var user_val = $('#mobile').val();
   if(user_val.length == ''){
     $('#mobilecheck').show();
     $('#mobilecheck').html("**Please Fill the Mobile Number");
     $('#mobilecheck').focus();
     $('#mobilecheck').css("color","red");
     mobile_err = false;
     return false;
   }else{
     mobile_err = true;
     $('#mobilecheck').hide();
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


  function con_passwrd(){
     var conpass = $('#cnf_password').val();
     var passwrdstr = $('#password').val();
     if(passwrdstr != conpass){
       $('#conpasscheck').show();
       $('#conpasscheck').html("** Password are not Matching");
       $('#conpasscheck').focus();
       $('#conpasscheck').css("color","red");
       conpass_err = false;
       return false;
     }else{
       $('#conpasscheck').hide();
       conpass_err = true;
     } 
   }


 $('#register_btn').click(function(){
  fname_err = true;
  lname_err = true;
  email_err = true;
  mobile_err = true;
  pass_err = true;
  conpass_err = true;


  fname_check();
  lname_check();
  email_check();
  mobile_check();
  password_check();
  con_passwrd();


  if((fname_err == true ) && (lname_err == true) && (email_err == true) && (mobile_err == true) && (pass_err == true) && (conpass_err == true)){
   return true;
  }else{
   return false;
  }


 });

 });
</script>

</body>

</html>
