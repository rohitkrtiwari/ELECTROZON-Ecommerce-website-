<?php
session_start();
require('functions.inc.php');
require('connection.inc.php');
$msg='';

$user_id = get_user($conn)[0]; $loggedin = get_user($conn)[1];

if(isset($_POST['submit'])){
  $user_name = get_safe_value($conn, $_POST['user_name']);
  $mobile = get_safe_value($conn, $_POST['mobile']);
  $email = get_safe_value($conn, $_POST['email']);
  $query = get_safe_value($conn, $_POST['query']);
  $sql = "INSERT INTO contact_us(name, mobile,email, query) VALUES ('$user_name','$mobile','$email','$query')";
  $res = mysqli_query($conn, $sql);
  if($res){
    $msg = "You query have been submitted succesfully";
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="<?php echo SITE_PATH; ?>assets/js/custom.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo SITE_PATH; ?>assets/css/style.css" rel="stylesheet">
	<link href="<?php echo SITE_PATH; ?>assets/css/preloader.css" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>Contact Us - Electrozon</title>

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


<!-- Contact Us Section -->

<section class="contact-us"> 
  <div> 
    <div class="alert alert-primary" id="alert"role="alert">
      <strong>
        <?php
          if($msg!=''){
            echo $msg;
          }else{
            echo "<script>";
            echo "var alertbox = document.getElementById('alert');";
            echo "alertbox.style.display='none';";
            echo "</script>";
          }
        ?>
      </strong>
    </div>
    <h2>Contact Us Form</h2> 
    <div class="contact-form"> 
      <form method="post" action="contact_us.php" class="form-control"> 
        <div class="mb-3"> 
          <label class="form-label">Your Name</label> 
          <input type="text" name="user_name" class="form-control" required> 
        </div>
        <div class="mb-3"> 
          <label class="form-label">Mobile</label> 
          <input type="text" name="mobile" class="form-control" required> 
        </div> 
        <div class="mb-3"> 
          <label class="form-label">Your Email address</label> 
          <input type="email" required name="email" class="form-control" value="
          <?php 
            if($loggedin){
              echo $user_id;
            } 
          ?>"> 
        </div> 
        <div class="mb-3"> 
          <label class="form-label">Query</label> 
          <input type="text" name="query" class="form-control" required>
        </div>
          <button type="submit" name="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</section>



<!-- Footer Section -->

<?php
require('prerequisite/footer.php');
?>


</body>
</html>
