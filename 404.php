<?php
session_start();
require('connection.inc.php');
require('functions.inc.php');
// following files need to be included
require("PaytmKit/lib/config_paytm.php");
require("PaytmKit/lib/encdec_paytm.php");

$user_id = get_user($conn)[0]; $loggedin = get_user($conn)[1];

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
  <script src="assets/js/custom.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Electrozon - Thank You Page</title>
</head>
<body>

<style type="text/css">
  
#aa-error .aa-error-area {
    display: inline;
    float: left;
    margin-top: 50px;
    padding: 100px 100px 130px;
    text-align: center;
    width: 100%;
}

#aa-error .aa-error-area {
    border: 5px solid #4337f5;
}

#aa-error .aa-error-area span {
    color: #000;
    display: block;
    font-size: 30px;
    font-weight: bold;
    margin-bottom: 20px;
    text-shadow: 1px 1px 3px #ddd;
}
#aa-error .aa-error-area p {
    font-size: 18px;
}
#aa-error .aa-error-area h2 {
    display: inline-block;
    font-size: 150px;
    line-height: 150px;
    margin-bottom: 30px;
    text-shadow: 0 2px 2px #ddd;
}

#aa-error .aa-error-area a {
    border: 1px solid #ccc;
    display: inline-block;
    font-size: 16px;
    font-weight: bold;
    letter-spacing: 0.5px;
    text-decoration: none;
    color: black;
    margin-top: 30px;
    padding: 10px 15px;
    text-transform: uppercase;
    -webkit-transition: all 0.5s;
    -moz-transition: all 0.5s;
    -ms-transition: all 0.5s;
    -o-transition: all 0.5s;
    transition: all 0.5s;
}

</style>


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

<section id="aa-error" class="mb-5">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="aa-error-area">
          <h2>404</h2>
          <span>Sorry! Page Not Found</span>
          <p>The page you were looking for could not be found. It might have been removed, renamed, or did not exists in the first place.</p>
          <a href="<?php echo SITE_PATH ?>"> Go to Homepage</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Footer Section -->

<?php
require('prerequisite/footer.php');
?>


</body>
</html>