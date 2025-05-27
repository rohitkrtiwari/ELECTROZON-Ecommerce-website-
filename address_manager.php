<?php
session_start();
require('connection.inc.php');
require('functions.inc.php');


// Setting the User
$user_id = get_user($conn)[0]; $loggedin = get_user($conn)[1];

if(!$loggedin){
	header('location:'.SITE_PATH.'login');
}

// Fetch saved address details of user
$s_addresses = getAddress($conn,$user_id);


// POST Request Handler
if(isset($_POST['type'])){
    $type=get_safe_value($conn,$_POST['type']);

   	// Delete Address Reuqest
   	if($type=='deleteAddress'){
	    $username=$user_id;
      $addId=get_safe_value($conn,$_POST['addId']);
	    if(deletAddress($conn, $username, $addId)){
	       return true;
	    }else{
	       return false;
	    }
	}
}


// Add New Address Reuqest
if(isset($_POST['add-new-address'])){
    $csrf_token=get_safe_value($conn,$_POST['csrf_token']);
    if($csrf_token == $_SESSION['csrf_token']['add_new_address'])
    {
        $username=$user_id;
        $name=get_safe_value($conn,$_POST['name']);
        $address=get_safe_value($conn,$_POST['address']);
        $city=get_safe_value($conn,$_POST['city']);
        $post_code=get_safe_value($conn,$_POST['post_code']);
        $phone_number=get_safe_value($conn,$_POST['phone_number']);
      if(addNewAddress($conn, $username, $name, $address, $city, $post_code, $phone_number)){
         header('location:'.SITE_PATH.'address_manager ');
      }else{
         $msg = "Error";
      }
    }
    else
      $msg = "Bad Request";
}

// Function for deleting Pending Addresses
function deletAddress($conn, $username, $addId){
	$sql = "DELETE FROM address WHERE username = '$username' and id = '$addId'";
	echo $sql;
	if(mysqli_query($conn,$sql)){
    	return true;
	}else{
		return false;
	}
}


// Function for Adding New Addresses
function addNewAddress($conn, $username, $name, $address, $city, $post_code, $phone_number){
	$sql = "INSERT INTO address (username, name, address, city, post_code, phone_number) VALUES ('$username', '$name', '$address', '$city', '$post_code', '$phone_number') ";
	if(mysqli_query($conn,$sql)){
		return true;
    }else{
		return false;
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

	<title>Electrozon Addresss Manager</title>
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
        <p > <a class="fs-14 text-decoration-none fw-bold" href="<?php echo SITE_PATH ?>">Home > </a> <a class="fs-14 text-decoration-none fw-bold" href="<?php echo SITE_PATH ?>my_account">My Account > </a> <a class="fs-14 text-decoration-none text-danger fw-bold" href="#"> Address Manager </a></p>
        <h2 class="text-dark">Address Manager</h2>
        <nav class="mt-4">
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">My Addresses</a>
            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Add New Address</a>
          </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
          
          <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="row mx-3 my-2">
              <?php if (count($s_addresses) == 0){ ?>
                <option selected>No saved address found</option>
              <?php } else { foreach ($s_addresses as $address) { ?>

                <div class="card col-sm-4 me-md-3 my-3" style="width: 18rem;">
                  <div class="card-body">
                    <?php if($address['verified'] == 1) echo '<p class="add_status add_status_verified">Verified</p>'; else echo '<p class="add_status add_status_pending">Pending</p>'; ?>
                    <h5 class="card-title mt-5">
                      <?php echo "<b>".$address['name']."</b><br>";
                         echo "<p class='p-sml p-light'>".$address['address']."<br>";
                         echo $address['post_code']."<br>";
                         echo $address['phone_number']."<br></p>";?>
                    </h5>
                  </div>
                </div>
              <?php } } ?>  
            </div>
          </div>

          <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <!-- Add New Address Form -->
            <form method="POST" class="my-3">
              <input type="text" name="csrf_token" id="csrf_token" value="<?php echo csrf_token('add_new_address'); ?>" hidden>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label pull-right p-sml p-light">* Name</label>
                <div class="col-sm-10">
                  <input type="text" name="name" class="form-control" placeholder="Name" required>
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label pull-right p-sml p-light">* Address</label>
                <div class="col-sm-10">
                  <input type="text" name="address" class="form-control" placeholder="Address" required>
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label pull-right p-sml p-light">* City</label>
                <div class="col-sm-10">
                  <input type="text" name="city" class="form-control" placeholder="City" required>
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label pull-right p-sml p-light">* Post Code</label>
                <div class="col-sm-10">
                  <input type="text" name="post_code" class="form-control" placeholder="Post Code" required>
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label pull-right p-sml p-light">* Country</label>
                <div class="col-sm-10">
                  <select class="form-select" aria-label="Disabled select example" disabled>
                    <option selected>India</option>
                  </select>
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label pull-right p-sml p-light">* Mobile</label>
                <div class="col-sm-10">
                  <input type="text" name="phone_number" class="form-control" placeholder="Enter your phone Number" required>
                </div>
              </div>

              <button name="add-new-address" type="submit" class="btn btn-dark pull-right" style="line-height: 1.1;">Continue</button>
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

</body>
</html>
