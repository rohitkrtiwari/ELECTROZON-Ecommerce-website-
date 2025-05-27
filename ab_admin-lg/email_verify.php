<?php
require('connection.inc.php');
require('functions.inc.php');
session_start();
$msg='';

if(isset($_SESSION['otp_attempt_count'])){}
else{
    $_SESSION['otp_attempt_count'] = 0;
}
// Restrict entry of blocked users
if(user_is_blocked($conn)){
    header('location:'.SITE_PATH.'errors/forbid ');
}


// Redirect user to login page if not logged in
if(isset($_SESSION['ADMIN_LOGIN'])){
    if($_SESSION['ADMIN_LOGIN'] ==true){
        
    }else{
        header('location:'.SITE_ADMIN_PATH.'login');
    }
}else{
    header('location:'.SITE_ADMIN_PATH.'login');
}


// POST request for getting otp for verification
if(isset($_POST['submit']))
{
    
    if($_SESSION['otp_attempt_count'] >= 4)
    {
        password_reset($conn, $_SESSION['tmp_username']); 
        $msg = "Otp have been reset and emailed to the founders";
        session_destroy();
        block_user($conn);
        header('location:'.SITE_PATH.'errors/forbid ');
    }
    else
    {
        $_SESSION['otp_attempt_count'] += 1;  
        $otp=get_safe_value($conn,$_POST['otp']);
        
        if(isset($_SESSION['otp']))
        {
            if($otp == $_SESSION['otp'])
            {
                $_SESSION['email_verify'] = true;
                unset($_SESSION['otp']);
                header('location:'.SITE_ADMIN_PATH.'categories');
                die();
            }

            else
            {
                $_SESSION['email_verify'] = false;            
                $msg="OTP MisMatch";
            }
        }
        else
        {
            $msg="OTP Expired";
            
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Admin | Login</title>
</head>

<body>
    <div class="alert alert-warning alert-dismissible fade show" role="alert"><?php echo $msg; ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
    <div class="main">
        <img src="assets/images/logo.png" alt="logo">
        <div class="form">
            <form method="POST" autocomplete='off'>
                <h1>Welcome Back</h1>
                <h4>ELECTROZON Admin Login</h4>
                <lable class="lable">Enter otp</lable>
                <input type="text" name='otp' required>
                <p class="text-danger"><?php if($_SESSION['otp_attempt_count']!=0) echo (5-$_SESSION['otp_attempt_count'])." Attempt left"; ?></p>
                <button type="submit" class="btn-submit" id="submit" name="submit">SUBMIT</button>
            </form>    
        </div>
    </div>
</body>
<script>
    
</script>


</html>
