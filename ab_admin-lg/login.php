<?php
require('connection.inc.php');
require('functions.inc.php');
session_start();
$msg='';

if(isset($_SESSION['login_attempt_count'])){}
else{
    $_SESSION['login_attempt_count'] = 0;
}
// Restrict entry of blocked users
if(user_is_blocked($conn)){
    header('location:'.SITE_PATH.'errors/forbid ');
}


// Restrict logged user to visit this page
if(isset($_SESSION['ADMIN_LOGIN'])){
    if(isset($_SESSION['email_verify'])==true){
        header('location:'.SITE_ADMIN_PATH.'categories');
    }else{
        header('location:'.SITE_ADMIN_PATH.'email_verify');
    }
}





// Verifiy users logging
if(isset($_POST['submit']))
{   
    if(isset($_POST['csrf_token']))
    {
        $csrf_token = get_safe_value($conn, $_POST['csrf_token']);
        if($_SESSION['csrf_token']['admin_login_token']  == $csrf_token)
        {
            if($_SESSION['login_attempt_count'] >= 4)
            {
                password_reset($conn, $_SESSION['tmp_username']);    
                $msg = "Password have been reset and emailed to the founders";
                session_destroy();
                block_user($conn);
                header('location:'.SITE_PATH.'errors/forbid ');
            }
            else
            {

                $_SESSION['login_attempt_count'] += 1;    


                $username=get_safe_value($conn,$_POST['username']);
                $_SESSION['tmp_username'] = $username;
                $password=md5(get_safe_value($conn,$_POST['password']));
                $sql="SELECT * from admin_users where username = '$username' and password = '$password'";
                $res=mysqli_query($conn, $sql);
                $count=mysqli_num_rows($res);
                
                // If user exists
                if($count>0)
                {
                    // Details of admin trying to login
                    $remote_addr = $_SERVER['REMOTE_ADDR'];
                    $http_user_agent = $_SERVER['HTTP_USER_AGENT'];
                    $crt_time = crt_time();

                    // Sent email to the founders about tis login
                    notify_admin($username, $remote_addr, $http_user_agent, $crt_time);
                    // Add this login details in database
                    add_login_db($conn, $username, $remote_addr, $http_user_agent, $crt_time);

                    // Further preced for otp Verification
                    $otp = random_strings(6);
                    if(login_otp($username, $otp))
                    {
                        $_SESSION['otp'] = $otp;
                        $_SESSION['ADMIN_LOGIN'] = true;
                        $_SESSION['username'] = $username;
                        header('location:'.SITE_ADMIN_PATH.'email_verify');
                        die();
                    }

                }

                else
                {
                    $msg="Please enter correct login details";
                }
            }
        
        }
        else
            $msg = "Bad Request";
    }
    else
        $msg = "Bad request";
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
        <img src="<?php echo SITE_ADMIN_PATH ?>assets/images/logo.png" alt="logo">
        <div class="form">
            <form method="POST" autocomplete='off'>
                <h1>Welcome Back</h1>
                <h4>ELECTROZON Admin Login</h4>
                <input type="text" name="csrf_token" hidden value="<?php echo csrf_token('admin_login_token'); ?>"> 
                <lable class="lable">Username</lable>
                <input type="email" placeholder="johndoe@gmail.com" name='username' required>
                <lable class="lable">Password</lable>
                <input type="password" name='password' placeholder="Please enter your password" style="margin-bottom: 20px;" required>
                <p class="text-danger"><?php if($_SESSION['login_attempt_count']) echo (5-$_SESSION['login_attempt_count'])." Attempt Left"; ?></p>
                <button type="submit" class="btn-submit" id="submit" name="submit">Login</button>
            </form>    
        </div>
    </div>
</body>

</html>
