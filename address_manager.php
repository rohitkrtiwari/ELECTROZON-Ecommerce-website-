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

   	// Add New Address Reuqest
   	if($type=='add'){
      $csrf_token=get_safe_value($conn,$_POST['csrf_token']);
      if($csrf_token == $_SESSION['csrf_token']['add_new_address'])

	    $username=$user_id;
      $name=get_safe_value($conn,$_POST['name']);
      $address=get_safe_value($conn,$_POST['address']);
      $city=get_safe_value($conn,$_POST['city']);
      $post_code=get_safe_value($conn,$_POST['post_code']);
      $phone_number=get_safe_value($conn,$_POST['phone_number']);
	    if(addNewAddress($conn, $username, $name, $address, $city, $post_code, $phone_number)){
	       return true;
	    }else{
	       return false;
	    }
	}
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
<section class="grid-view my_order_resp">  
  <div class="container-fluid p-5" style="padding: 50px 0;">
    <div class="row">
      <div class="content">
        <h2>Address Manager</h2>
      </div>
    </div>

    <div class="row">

      <div class="col">

      	<!-- Saved Address Heading -->
        <div class="form-check">
          <input class="form-check-input" type="radio" name="billing-address-selecter" id="register" value="3" checked>
          <label class="form-check-label p-light" for="flexRadioDefault2">
            Saved Address
          </label>
        </div>

      	<!-- Saved Address Form -->
        <div class="row mb-3 mt-2 toHide" id="add-3">
          <div class="col-sm-12">
            <table class="table table-striped table-sm table_scroll_x">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Address</th>
                  <th>City</th>
                  <th>Post Code</th>
                  <th>Phone Number</th>
                  <th>Status</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php if (count($s_addresses) == 0){ ?>
                  <td>No Saved Address Found</td>
                  <td>Add a new Address </td>

                <?php } else { $i=0; foreach ($s_addresses as $s_address) { if($s_address['verified'] == 1){$i=$i+1;
                ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $s_address['name']; ?></td>
                    <td><?php echo $s_address['address']; ?></td>
                    <td><?php echo $s_address['city']; ?></td>
                    <td><?php echo $s_address['post_code']; ?></td>
                    <td><?php echo $s_address['phone_number']; ?></td>
                    <td class="badge-red">Verified</td>
                    <td>
                      <div class="op-link">
                        <span class="badge-red"><a onclick="DeleteAddress(<?php echo $s_address['id']; ?>)" href="#">Delete</a></span>
                      </div>
                    </td>
                  <?php } } } ?>
                </tr>
              </tbody>
            </table>
          </div>
        </div>


        <!-- Pending Address Heading -->
        <div class="form-check">
          <input class="form-check-input" type="radio" name="billing-address-selecter" id="register" value="2">
          <label class="form-check-label p-light" for="flexRadioDefault2">
            Pending Address Request
          </label>
        </div>

      	<!-- Pending Address Form -->
        <div class="row mb-3 mt-2 toHide" id="add-2"  style="display:none">
          <div class="col-sm-12">


          	<table class="table table-striped table-sm table_scroll_x">
	          <thead>
	            <tr>
	              <th>#</th>
                <th>Name</th>
	              <th>Address</th>
	              <th>City</th>
	              <th>Post Code</th>
	              <th>Phone Number</th>
	              <th>Status</th>
	              <th></th>
	            </tr>
	          </thead>
	          <tbody>
	            <?php if (count($s_addresses) == 0){ ?>
	              <td>No requests Found</td>

	            <?php } else { $i=0; foreach ($s_addresses as $s_address) { if($s_address['verified'] == 0){$i=$i+1;
	            ?>
	              <tr>
	                <td><?php echo $i; ?></td>
                  <td><?php echo $s_address['name']; ?></td>
	                <td><?php echo $s_address['address']; ?></td>
	                <td><?php echo $s_address['city']; ?></td>
	                <td><?php echo $s_address['post_code']; ?></td>
	                <td><?php echo $s_address['phone_number']; ?></td>
	                <td class="badge-red">Pending</td>
	                <td>
	                  <div class="op-link">
	                    <span class="badge-red"><a onclick="DeleteAddress(<?php echo $s_address['id']; ?>)" href="#">Delete</a></span>
	                  </div>
	                </td>
	              <?php } } } ?>
	            </tr>
	          </tbody>
	        </table>


            
          </div>
        </div>


      	<!-- Add New Address Heading -->
        <div class="form-check">
          <input class="form-check-input" type="radio" name="billing-address-selecter" id="register" value="1" >
          <label class="form-check-label p-light" for="flexRadioDefault2">
            Add a New Address
          </label>
        </div>
        
      	<!-- Add New Address Form -->
        <form method="POST" id="add-1" class="toHide" style="display:none">
          <input type="text" name="csrf_token" id="csrf_token" value="<?php echo csrf_token('add_new_address'); ?>" hidden>
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label pull-right p-sml p-light">* Name</label>
            <div class="col-sm-10">
              <input type="text" id="name" class="form-control" placeholder="Name" required>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label pull-right p-sml p-light">* Address</label>
            <div class="col-sm-10">
              <input type="text" id="address" class="form-control" placeholder="Address" required>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label pull-right p-sml p-light">* City</label>
            <div class="col-sm-10">
              <input type="text" id="city" class="form-control" placeholder="City" required>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label pull-right p-sml p-light">* Post Code</label>
            <div class="col-sm-10">
              <input type="text" id="post_code" class="form-control" placeholder="Post Code" required>
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
              <input type="text" id="phone_number" class="form-control" placeholder="Enter your phone Number" required>
            </div>
          </div>

          <button name="add-new-address" id="add-new-address" class="btn btn-dark pull-right" style="line-height: 1.1;">Continue</button>
        </form>



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