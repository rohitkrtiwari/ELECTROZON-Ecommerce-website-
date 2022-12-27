<?php
ob_start();
require('connection.inc.php');
require('functions.inc.php');
session_start();

// Check if user is logged in or not 
if(isset($_SESSION['ADMIN_LOGIN'])==true && isset($_SESSION['email_verify'])==true){
  if($_SESSION['ADMIN_LOGIN'] == true && $_SESSION['email_verify']==true)
  {
    $loggedin = $_SESSION['ADMIN_LOGIN'];
    $username = $_SESSION['username'];
  }else{
    $loggedin = false;
    header('location:'.SITE_ADMIN_PATH.'logout');
    die();  
  }
}else{
  $loggedin = false;
  header('location:'.SITE_ADMIN_PATH.'logout');
  die();
}


$request=$_SERVER['REQUEST_URI'];
$router = str_replace('/ab_admin-lg/','',$request);

ob_end_flush();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.79.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>ELECTROZON Admin Panel</title>


    <!-- Bootstrap core CSS -->
<link href="<?php echo SITE_ADMIN_PATH ?>assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="<?php echo SITE_ADMIN_PATH ?>assets/dist/css/dashboard.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  </head>



  <body>
  
<!-- Preloader -->
<div id="preloader">
  <div id="status">&nbsp;</div>
</div>

<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="<?php echo SITE_ADMIN_PATH ?>">Electrozon</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <input class="form-control form-control-dark w-100" id="search" type="text" placeholder="Search">
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="<?php echo SITE_ADMIN_PATH ?>logout
      ">Sign out</a>
    </li>
  </ul>
</header>

<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link <?php if($router == 'categories') echo 'active'?>" aria-current="page" href="<?php echo SITE_ADMIN_PATH ?>categories">
              <span data-feather="home"></span>
              Categories Master
            </a>
            <a class="nav-link <?php if($router == 'sub_categories') echo 'active'?>" aria-current="page" href="<?php echo SITE_ADMIN_PATH ?>sub_categories">
              <span data-feather="home"></span>
              Sub Categories Master
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if($router == 'orders') echo 'active'?>" href="<?php echo SITE_ADMIN_PATH ?>orders">
              <span data-feather="file"></span>
              Orders
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if($router == 'products') echo 'active'?>" href="<?php echo SITE_ADMIN_PATH ?>products">
              <span data-feather="shopping-cart"></span>
              Products
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if($router == 'customers') echo 'active'?>" href="<?php echo SITE_ADMIN_PATH ?>customers">
              <span data-feather="users"></span>
              Customers
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if($router == 'manage_address') echo 'active'?> " href="<?php echo SITE_ADMIN_PATH ?>manage_address">
              <span data-feather="bar-chart-2"></span>
              Addresses
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if($router == 'contact_us') echo 'active'?>" href="<?php echo SITE_ADMIN_PATH ?>contact_us">
              <span data-feather="layers"></span>
              Contact Us Queries
            </a>
          </li>
        </ul>

      </div>
    </nav>


  </div>
</div>


    <script src="<?php echo SITE_ADMIN_PATH ?>assets/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="<?php echo SITE_ADMIN_PATH ?>assets/dist/js/dashboard.js"></script>
    <script src="<?php echo SITE_ADMIN_PATH ?>assets/js/custom.js"></script>


<script type="text/javascript">

$(document).ready(function(){
      // Toggle Addresses
  $("[name=billing-address-selecter]").click(function(){
      $('.toHide').hide();
      $("#add-"+$(this).val()).show('slow');
    });
</script>

</body>
</html>

