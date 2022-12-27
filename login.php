<?php
session_start();
require('connection.inc.php');
require('functions.inc.php');
$msg='';
$static_msg='';
$user_id = get_user($conn)[0]; $loggedin = get_user($conn)[1];
if($loggedin){
   header('location:'.SITE_PATH.'') ;
}

if(isset($_POST['submit']))
{
    $username=get_safe_value($conn,$_POST['email']);
    $password=md5(get_safe_value($conn,$_POST['password']));
    if($username!='' && $password !='')
    {
        $sql="select * from customers where username = '$username' and password = '$password'";
        $res=mysqli_query($conn, $sql);
        $count=mysqli_num_rows($res);
        if($count>0)
        {
            while ($row=mysqli_fetch_assoc($res)){
              if($username == $row['username'] && $password == $row['password'])
              {
                if($row['status'] == 1)
                {
                  $_SESSION['login'] = true;
                  $_SESSION['username'] = $username;
                  $user_id = get_user($conn)[0]; $loggedin = get_user($conn)[1];
                  header('location:'.SITE_PATH.'home');
                }
                else{
                  $static_msg = "Please verify your Email ID First";
                }
              }else{
              $msg = "Please Enter Correct Login Details";   
              }
            }
        }
        else
        {
            $msg = "Please Enter Correct Login Details";
        }
    }
    else{
        $msg = "Please Enter Correct Login Details";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="<?php echo SITE_PATH ?>assets/js/custom.js"></script>
    <title>Electrozon Login</title>
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
<style type="text/css">
  .login-reg-box{
    background: #fff;
    border: 1px solid #e3e3e3;
    padding: 19px;
    margin-bottom: 20px;
    box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
  }
</style>


<div class="row px-3 m-auto my-4 login_resp"> 
<p > <a class="fs-14 text-decoration-none fw-bold" href="<?php echo SITE_PATH ?>">Home > </a> <a class="fs-14 text-decoration-none text-danger fw-bold" href="#"> Login </a></p>
  <div class="col mx-1 login-reg-box">



    <h4>Sign Up</h4>
    <p class="p-sml p-light">Checkout Options:</p>
    <div class="form-check">
      <input class="form-check-input" type="radio" name="register" id="register" checked>
      <label class="form-check-label p-light" for="flexRadioDefault2">
        Register Account
      </label>
    </div>
    <p class="p-sml p-light">By creating an account you will be able to shop faster, be up to date on an order's status, and keep track of the orders you have previously made.</p>
    <button type="submit" id ="checkout-register" class="btn btn-dark" style="line-height: 1.1;">Sign Up</button>
  </div>

  <div class="col mx-1 align-right login-reg-box">
    <div id="alert-msg"></div>
    <h4>Login</h4>
    <p class="p-sml p-light">I am A returning Customer</p>
      <?php if($msg!='') echo "<script>alertMsg('".$msg."')</script>"; ?>
      <?php if($static_msg!='') echo "<span style='color:red'>**".$static_msg."</span>"; ?>
    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Email address</label>
        <input type="email" name='email' id="email" required class="form-control">
        <div class="form-text">We'll never share your email with anyone else.</div>
        <p id="emailcheck" class="m-0"></p>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" id="password" class="form-control">
        <p id="passcheck" class="m-0"></p>
        <a href="<?php echo SITE_PATH?>forgot_password" class="text-decoration-none p-sml text-primary">Forgotten Password</a><br>
      </div>
      <button type="submit" name="submit" id="login-btn" class="btn btn-dark" style="line-height: 1.1;">Submit</button>
    </form>
  </div>
</div>



<!-- Footer Section -->

<?php
require('prerequisite/footer.php');
?>

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

 $('#login-btn').click(function(){
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
