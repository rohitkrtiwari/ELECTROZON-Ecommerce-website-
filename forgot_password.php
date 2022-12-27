<?php
session_start();
require('connection.inc.php');
require('functions.inc.php');
$msg='';

$user_id = get_user($conn)[0]; $loggedin = get_user($conn)[1];

$static_msg = '';

$valid = true;

if($valid)
{

	if(isset($_POST['reset_password']))
	{
		if(isset($_POST['email'])){

			$email = $_POST['email'];

			$sql = "SELECT * FROM customers WHERE username = '$email'";

			$rows = mysqli_num_rows(mysqli_query($conn, $sql));

			if($rows > 0)
			{
				
				if(user_can_reset($conn, $email))
				{

					$token = bin2hex(random_bytes(50));
				    if(SendPasswordResetMail($email, $token))
				    {
					    $sql="INSERT INTO password_reset(username, reset_token, used, email_sent) VALUES('$email','$token', 0, 1)";

						if(mysqli_query($conn, $sql)){
							$msg = "Password Reset Mail Sent to ".$email;
						}

						else
							$msg = "Can't Connect the the server... Please try later";
					}
					else
						$msg = "Can't Connect the the server... Please try later";
				}
				else
				{	
					if(user_changed_password($conn, $email))
					{
						$static_msg = "You've recently changed your password. Please try after 24 Hours";
						$valid = false;
					}
					else
					{
						$static_msg = 'mailed';
						$valid = false;	
					}
				}

			}
			else
				$msg = "No Accounts found with E-Mail Address ".$email;
	    }
	}

}


function user_can_reset($conn, $email){
	// Check for Requests Made Withing 24 Hours 
	$sql = "SELECT * FROM password_reset WHERE username = '$email' AND email_sent = 1 AND created_at >= now() - INTERVAL 24 HOUR";
	$count = mysqli_num_rows(mysqli_query($conn, $sql));
	if($count > 5)
		return false;
	else
		return true;
}

function user_changed_password($conn, $email){
	// Check password changed within 24 hours 
	$sql = "SELECT * FROM password_reset WHERE username = '$email' AND email_sent = 1 and used = 1 AND created_at >= now() - INTERVAL 24 HOUR";
	$count = mysqli_num_rows(mysqli_query($conn, $sql));
	if($count > 0)
		return true;
	else
		return false;
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
	<title>Electrozon - Forgot Password</title>
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

<!-- STEP 2 : Sending Password Reset Mail -->
<?php if($valid) {?>
	<section class="grid-view  px-2 " >
	    <div class="container-xxl">
	      <?php if($msg!='') echo "<script>alertMsg('".$msg."')</script>"; ?>
			<div class="col m-4 mt-2 register_resp">
			<span class="fs-2 mb-3">Forgot Password </span>
	        <div id="alert-msg" style="background-color: #3d1a54;"></div>           
	        <form method="POST" name="submit">
		        <div class="input-group my-3" style="max-width: 400px">
				  <input type="email" name="email" required id="verified_email" class="form-control form-control-sm" placeholder="Enter your email ID">
			 	</div>
				
				<p class="fs-5 mt-1">1. Request Password Change Link</p>
				<p class="p-sml p-light">By clicking on the reset password button, you'll get an email containing a link to link to reset this account's password.</p>
		        <button class="btn view_all_btn mt-3" name="reset_password">RESET PASSWORD</button>
	    	</form>
	      </div>    
	    </div>
	</section>


<!-- STEP 3 : Check your email for password reset link -->
<?php } elseif(!$valid && $static_msg == 'mailed') {?>
	<section class="grid-view  px-2 " >
	    <div class="container-xxl">
	      <div id="alert-msg" style="background-color: #3d1a54;"></div>
	      <?php if($msg!='') echo "<script>alertMsg('".$msg."')</script>"; ?>
			<div class="col m-4 mt-2 register_resp">
			<span class="fs-2 mb-3">Forgot Password </span>
	        <div id="alert-msg" style="background-color: #3d1a54;"></div>           
			  <p class="fs-5 mt-1">2. Check email for reset link</P>
              <p class="p-sml p-light">An email has been sent to the administrative email address on file. Check the inbox of the administrative's email account, and click the reset link provided</p>
              <p class="p-sml p-light">The link will expire after 30 mins</p>
	      </div>    
	    </div>
	</section>
<?php }else{ ?>
	<section class="grid-view  px-2 " >
	    <div class="container-xxl">
	        <div id="alert-msg" style="background-color: #3d1a54;"></div>
	        <?php if($msg!='') echo "<script>alertMsg('".$msg."')</script>"; ?>
			<div class="col m-4 my-5 py-5 register_resp">
				<center>
					<span class="fs-2 mb-3">Forgot Password </span>
			        <div id="alert-msg" style="background-color: #3d1a54;"></div>           
					  <p class="text-danger">**<?php echo $static_msg; ?></p>
				</center>
	        </div>    
	    </div>
	</section>
<?php } ?>

<!-- Footer Section -->

<?php
require('prerequisite/footer.php');
?>

</body>
</html>
