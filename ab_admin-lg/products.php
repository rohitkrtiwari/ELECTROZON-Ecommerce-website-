<?php 
ob_start();
require('home.php');

// Get request handling for performing CRUD operations
if(isset($_GET['type']) && $_GET['type']!=''){
  $type=get_safe_value($conn,$_GET['type']);

  // Product Status update
  if($type=='status'){
    $operation=get_safe_value($conn,$_GET['operation']);
    $id=get_safe_value($conn,$_GET['id']);
    if($operation=='active'){
      $status='1';
    }else{
      $status='0';
    }
    $update_status_sql="update product set status='$status' where id='$id'";
    if(mysqli_query($conn,$update_status_sql)) header('location:'.SITE_ADMIN_PATH.'products');
    else $error_msg = "Can't Update the product status";

  }
  

  // Product Delete request handling
  if($type=='delete'){
    $id=get_safe_value($conn,$_GET['id']);
    $delete_sql="delete from product where id='$id'";
    if(mysqli_query($conn,$delete_sql)) header('location'.SITE_ADMIN_PATH.'products');
    else $error_msg = "Can't Delete the product right now";
  }
}
$sql="select * from product order by id"; 
$res = mysqli_query($conn,$sql);
ob_end_flush();
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 my-4">

      <h2 style="margin-top: 16px;">Products</h2>
      <a class="add-new-link" href="<?php echo SITE_ADMIN_PATH ?>manage_products">Add New Product</a>
      <div class="table-responsive">
        <table class="table table-striped table-sm" id="products">
          <thead>
            <tr>
              <th>#</th>
              <th>CATEGORY</th>
              <th style="width: 40%;">NAME</th>
              <th>IMAGE</th>
              <th>MRP</th>
              <th>PRICE</th>
              <th>QTY</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php 
              $i=0;
              while($row=mysqli_fetch_assoc($res)) { $i=$i+1;
            ?>
              <tr class="admin-table-row">
                <td><?php echo $i; ?></td>
                <td>
                  <?php 
                    $category_id = $row['category_id']; 
                    $sql = "SELECT category from categories where id = '$category_id'";
                    $category_row = mysqli_query($conn,$sql);
                    $data=mysqli_fetch_assoc($category_row);
                    echo $data['category'];
                  ?>  
                </td>
                <td><?php echo $row['name']; ?></td>
                <td><img class="admin-table-image" src="<?php echo PRODUCT_IMAGE_SITE_PATH.$row['image']; ?>"></td>
                <td><?php echo $row['mrp']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><?php echo $row['qty']; ?></td>
                <td>
                  <div class="op-link">
                  <?php 
                    if($row['status']==1){
                      echo '<span class="badge-green"><a href="'.SITE_ADMIN_PATH.'products.php?type=status&operation=deactive&id='.$row['id'].'">'."Active".'</a></span>&nbsp';
                    } else{
                      echo '<span class="badge-light-red"><a href="'.SITE_ADMIN_PATH.'products.php?type=status&operation=active&id='.$row['id'].'">'."Deactive".'</a></span>&nbsp';
                    }
                  ?>  
                  <span class="badge-blue"><a href="<?php echo SITE_ADMIN_PATH ?>manage_products.php?operation=edit&id=<?php echo $row['id']; ?>">Edit</a></span>
                  <span class="badge-red"><a href="<?php echo SITE_ADMIN_PATH ?>products.php?type=delete&id=<?php echo $row['id']?>">Delete</a></span>
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
    $("#products tbody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
