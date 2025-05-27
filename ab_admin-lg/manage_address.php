<?php
ob_start();
require('home.php');
if(isset($_GET['type']) && $_GET['type']!=''){
  $type=get_safe_value($conn,$_GET['type']);
  // Update Active inactive status of website
  if($type=='status'){
    $operation=get_safe_value($conn,$_GET['operation']);
    $id=get_safe_value($conn,$_GET['id']);
    if($operation=='active'){
      $status='1';
    }else{
      $status='0';
    }
    $update_status_sql="update address set status='$status' where id='$id'";
    if(mysqli_query($conn,$update_status_sql)) header('location:'.SITE_ADMIN_PATH.'manage_address');
    else $error_msg = "Can't the category right now";

  }
  if($type=='delete'){
    $id=get_safe_value($conn,$_GET['id']);
    $delete_sql="delete from address where id='$id'";
    if(mysqli_query($conn,$delete_sql)) header('location:'.SITE_ADMIN_PATH.'manage_address');
    else $error_msg = "Can't the category right now";
  }

  if($type=='confirm'){
    $id=get_safe_value($conn,$_GET['id']);
    $confirmAdd_sql="update address set verified=1 where id='$id'";
    if(mysqli_query($conn,$confirmAdd_sql)) header('location:'.SITE_ADMIN_PATH.'manage_address');
    else $error_msg = "Can't the category right now";
  }
}
$sql="select * from address where verified = 0"; 
$p_addresses = mysqli_query($conn,$sql);
$sql="select * from address where verified = 1"; 
$s_addresses = mysqli_query($conn,$sql);
ob_end_flush();
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 my-4">
<link rel="stylesheet" type="text/css" href="assets/css/categories.css">
      <h2 style="margin-top: 16px;">Address Manager</h2>

      <div class="row">
        <div class="col-sm-2">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="billing-address-selecter" id="register" value="1"checked>
            <label class="form-check-label p-light" for="flexRadioDefault2">
              Pending Address
            </label>
          </div>
        </div>

        <div class="col-sm-2">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="billing-address-selecter" id="register" value="2" >
            <label class="form-check-label p-light" for="flexRadioDefault2">
              Verified Address
            </label>
          </div>
        </div>
      </div>

      <div class="table-responsive toHide" id="add-1" >
        <table class="table table-striped table-sm address">
          <thead>
            <tr>
              <th>#</th>
              <th>ID</th>
              <th>Name</th>
              <th>Address</th>
              <th>City</th>
              <th>Post Code</th>
              <th>phone_number</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              $i=0;
              while($p_address=mysqli_fetch_assoc($p_addresses)) { $i=$i+1;
            ?>
              <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $p_address['id']; ?></td>
                <td><?php echo $p_address['name']; ?></td>
                <td><?php echo $p_address['address']; ?></td>
                <td><?php echo $p_address['city']; ?></td>
                <td><?php echo $p_address['post_code']; ?></td>
                <td><?php echo $p_address['phone_number']; ?></td>
                <td>
                  <div class="op-link">
                    <span class="badge-green"><a href="<?php echo SITE_ADMIN_PATH ?>manage_address.php?type=confirm&id=<?php echo $p_address['id']?>">Confirm</a></span>
                  </div>
                </td>
                <td>
                  <div class="op-link">
                    <span class="badge-red"><a href="<?php echo SITE_ADMIN_PATH ?>manage_address.php?type=delete&id=<?php echo $p_address['id']?>">Delete</a></span>
                  </div>
                </td>
              <?php } ?>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="table-responsive toHide" id="add-2" style="display: none;">
        <table class="table table-striped table-sm address">
          <thead>
            <tr>
              <th>#</th>
              <th>ID</th>
              <th>Name</th>
              <th>Address</th>
              <th>City</th>
              <th>Post Code</th>
              <th>phone_number</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              $i=0;
              while($s_address=mysqli_fetch_assoc($s_addresses)) { $i=$i+1;
            ?>
              <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $s_address['id']; ?></td>
                <td><?php echo $s_address['name']; ?></td>
                <td><?php echo $s_address['address']; ?></td>
                <td><?php echo $s_address['city']; ?></td>
                <td><?php echo $s_address['post_code']; ?></td>
                <td><?php echo $s_address['phone_number']; ?></td>
                <td>
                  <div class="op-link">
                  <?php 
                    if($s_address['status']==1){
                      echo '<span class="badge-green"><a href="'.SITE_ADMIN_PATH.'manage_address.php?type=status&operation=deactive&id='.$s_address['id'].'">'."Active".'</a></span>&nbsp';
                    } else{
                      echo '<span class="badge-light-red"><a href="'.SITE_ADMIN_PATH.'manage_address.php?type=status&operation=active&id='.$s_address['id'].'">'."Deactive".'</a></span>&nbsp';
                    }
                  ?>
                  </div>
                </td>
              <?php } ?>
            </tr>
          </tbody>
        </table>
      </div>

<script type="text/javascript">
$(document).ready(function(){
    // Toggle Addresses
  $("[name=billing-address-selecter]").click(function(){
    $('.toHide').hide();
    $("#add-"+$(this).val()).show();
  });

  $("#search").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".address tbody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });


});
</script>
</main>
