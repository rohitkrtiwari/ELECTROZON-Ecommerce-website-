<?php
ob_start();
require('home.php');




// Handling customera CRUD operations
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
    $update_status_sql="update customers set status='$status' where id='$id'";
    if(mysqli_query($conn,$update_status_sql)) header('location:'.SITE_ADMIN_PATH.'customers');
    else $error_msg = "Can't the category right now";

  }


  // Delete Customers from website
  if($type=='delete'){
    $id=get_safe_value($conn,$_GET['id']);
    $delete_sql="delete from customers where id='$id'";
    if(mysqli_query($conn,$delete_sql)) header('location:'.SITE_ADMIN_PATH.'customers ');
    else $error_msg = "Can't block the customer right now";
  }
}
$sql="select * from customers order by id desc"; 
$res = mysqli_query($conn,$sql);
ob_end_flush();
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 my-4">
<link rel="stylesheet" type="text/css" href="<?php echo SITE_ADMIN_PATH ?>assets/css/categories.css">
      <h2 style="margin-top: 16px;">Customers</h2>
      <div class="table-responsive">
        <table class="table table-striped table-sm" id="customers">
          <thead>
            <tr>
              <th>#</th>
              <th>ID</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Email</th>
              <th>Mobile</th>
              <th>Added On</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php 
              $i=0;
              while($row=mysqli_fetch_assoc($res)) { $i=$i+1;
            ?>
              <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['fname']; ?></td>
                <td><?php echo $row['lname']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['mobile']; ?></td>
                <td><?php echo $row['created_on']; ?></td>
                <td>
                  <div class="op-link">
                    <?php 
                    if($row['status']==1){
                      echo '<span class="badge-green"><a href="'.SITE_ADMIN_PATH.'customers.php?type=status&operation=deactive&id='.$row['id'].'">'."Active".'</a></span>&nbsp';
                    } else{
                      echo '<span class="badge-light-red"><a href="'.SITE_ADMIN_PATH.'customers.php?type=status&operation=active&id='.$row['id'].'">'."Deactive".'</a></span>&nbsp';
                    }
                    ?>
                  </div>
                </td>
              <?php } ?>
            </tr>
          </tbody>
        </table>
      </div>
    </main>

<script type="text/javascript">
  $(document).ready(function(){
  $("#search").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#customers tbody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
