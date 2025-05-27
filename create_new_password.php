<?php
session_start();
require('connection.inc.php');
require('functions.inc.php');
$errors = array();
$msg='';
$notification = '';
if(!isset($verified))
  $verified = false;


$user_id = get_user($conn)[0]; $loggedin = get_user($conn)[1];


if(isset($_GET['e']) && $_GET['e']!='')
{
  if(isset($_GET['username']) && $_GET['username']!='')
  {
    $token = get_safe_value($conn, $_GET['e']);
    $username = get_safe_value($conn, $_GET['username']);
    $sql = "SELECT * FROM password_reset WHERE username = '$username' AND email_sent = 1 AND used = 0 AND created_at >= now() - INTERVAL 30 MINUTE";
    $count = mysqli_num_rows(mysqli_query($conn, $sql));
    if($count>0)
      $verified = true;
    else
      $msg = "Activation Link Expired";
  }
  else
    header('location:'.SITE_PATH.'404');
}
else
  header('location:'.SITE_PATH.'404'); 


if(isset($_POST['submit']))
{
  if(isset($_POST['password']) && $_POST['password']!='')
  {
    deactive_token($conn, $token, $username);
    $password = get_safe_value($conn, $_POST['password']);
    if($username != '')
    {
      $enc_password = md5($password);
      $sql = "UPDATE customers SET password = '$enc_password' where username = '$username'";
      $res = mysqli_query($conn, $sql);
      if($res){
        $notification = 'Password Updated Successfully';
      }else{
        $notification = 'error';
      }
    }
    else
      $msg = 'Activation Link expired';
  }
}


function deactive_token($conn, $token, $username){
  $sql = "UPDATE password_reset SET used = 1 WHERE username = '$username' AND reset_token = '$token'";
  mysqli_query($conn, $sql);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="HandheldFriendly" content="true">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo SITE_PATH ?>assets/css/theme.css" rel="stylesheet">
  <link href="<?php echo SITE_PATH ?>assets/css/style.css" rel="stylesheet">
  <link href="<?php echo SITE_PATH ?>assets/css/preloader.css" rel="stylesheet">
  <link href="<?php echo SITE_PATH ?>assets/css/header.css" rel="stylesheet">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="<?php echo SITE_PATH ?>assets/js/custom.js"></script>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>ELECTROZON - Create New Psssword</title>
</head>
<body>


<?php if($msg != '') echo $msg; else { ?>

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
      if($notification == 'error') echo "<script>alertMsg('Sorry..! Can't perform this operation right now.)</script>";

      elseif($notification !='') echo "<script>alertMsg('".$notification."','".SITE_PATH."login')</script>";
    ?>

    <div class="col m-4 register_resp">
    <span class="fs-1 mb-3">Change Password</span>
      <div id="alert-msg" style="background-color: #3d1a54;"></div>
      <form method="POST" class="register_form_resp col-10 p-sml p-light ">

        <span class="fs-4 mb-3">Your Password</span>
        <div class="mb-3 row border-top pt-3">
          <label class="col-sm-2 text-end resp_lable_left col-form-label">Create New Password</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" name="password" id="password">
            <span id="passcheck" ></span>
          </div>
        </div>
        <div class="mb-3 row ">
          <label class="col-sm-2 text-end resp_lable_left col-form-label">Confirm Pasword</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" name="cnf_password" id="cnf_password">
            <span id="conpasscheck" ></span>
          </div>
        </div>
        <div class="col-12 text-end">
          <button type="submit" name="submit" id="change_password" class="btn btn-dark" style="line-height: 1.1;">Change Account Password</button>
        </div>
      </form>

    </div>

  </div>
</section>


<!-- Footer Section -->

<?php
require('prerequisite/footer.php');
?>

<?php } ?>


<script type="text/javascript">
 $(document).ready(function(){

   $('#passcheck').hide();
   $('#conpasscheck').hide();

   var pass_err = true;
   var conpass_err = true;


   $('#password').keyup(function(){
    password_check();
   });

   $('#cnf_password').keyup(function(){
    con_passwrd();
   });



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


 $('#change_password').click(function(){
  pass_err = true;
  conpass_err = true;


  password_check();
  con_passwrd();


  if((pass_err == true) && (conpass_err == true)){
   return true;
  }else{
   return false;
  }


 });

 });
</script>

</body>

</html>