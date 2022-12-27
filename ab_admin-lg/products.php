<?php 
ob_start();
require('home.php');

$msg=array();
$name='';
$short_name='';
$category_id='';
$price='';
$image='';
$description='';
$meta_keyword='';
$best_seller='';

$image_required='required';
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
    if(mysqli_query($conn,$update_status_sql)){ header('location:'.SITE_ADMIN_PATH.'products'); }
    else {$error_msg = "Can't Update the product status"; header('location:'.SITE_ADMIN_PATH.'products');}

  }
  

  // Product Delete request handling
  if($type=='delete'){
    $id=get_safe_value($conn,$_GET['id']);
    $delete_sql="delete from product where id='$id'";
    if(mysqli_query($conn,$delete_sql)) { header('location'.SITE_ADMIN_PATH.'products'); }
    else {$error_msg = "Can't Delete the product status"; header('location:'.SITE_ADMIN_PATH.'products');}
  }
}




if(isset($_POST['submit'])){

  
  if(isset($_POST['name'])){
    $name=get_safe_value($conn,$_POST['name']);
    if ($name == ''){
      array_push($msg,"Product Name missing");
    }
  }

  if(isset($_POST['short_name'])){
    $short_name=get_safe_value($conn,$_POST['short_name']);
    if ($short_name == ''){
      array_push($msg,"Product Shor Name missing");
    }
  }

  if(isset($_POST['category_id'])){
    $category_id=get_safe_value($conn,$_POST['category_id']);
  }

  if(isset($_POST['tags'])){
    $tags = array();    
    foreach ($_POST['tags'] as $key ) {
      array_push($tags, $key);
    }
  }

  if(isset($_POST['price'])){
    $price=get_safe_value($conn,$_POST['price']);
    if ($price == ''){
      array_push($msg,"Product Price missing");
    }
  }

  if(isset($_POST['description'])){
    $description=get_safe_value($conn,$_POST['description']);
    if ($description == ''){
      array_push($msg,"Product Description missing");
    }
  }

  if(isset($_POST['meta_keyword'])){
    $meta_keyword=get_safe_value($conn,$_POST['meta_keyword']);
    if ($meta_keyword == ''){
      array_push($msg,"Product meta_keyword missing");
    }
  }

  if(isset($_POST['best_seller'])){
    $best_seller=get_safe_value($conn,$_POST['best_seller']);
    if ($best_seller == ''){
      array_push($msg,"Product best_seller missing");
    }
  }
  
  
  if(empty($msg)){
    $image = rand(111111111,999999999).'_'.$_FILES['image']['name'];
    copy($_FILES['image']['tmp_name'],PRODUCT_IMAGE_SERVER_PATH.$image);
    $ins_sql = "insert into product(name, short_name, category_id,price,description, meta_keyword,status,image, best_seller) values('$name', '$short_name', '$category_id', '$price', '$description', '$meta_keyword', '1', '$image', '$best_seller')";
    if(mysqli_query($conn,$ins_sql)){
      try{
        $product_id= mysqli_insert_id($conn);
        add_tags($conn, $product_id, $tags);
      }
      catch(Exception $e){
        echo $e;
      }
      echo "query executed successfully";
      header('location:'.SITE_ADMIN_PATH.'products');
    }else{
      array_push($msg, "query execution failuer");
    }
    die();
  }
}


// Function to add tags
function add_tags($conn, $product_id, $tags){
  $tags_sql = "INSERT INTO tags(pid, tag) VALUES";
  $i=0;
  $len = count($tags);
  foreach ($tags as $index => $key ) {
    if($i == $len-1){
      $tags_sql.="('$product_id','$key')";
    }else
      $tags_sql.="('$product_id','$key'),";
    $i++;
  }
  if(mysqli_query($conn, $tags_sql))
    return true;
  else
    return false;
}


$product_sql="select * from product order by id"; 
$product_res = mysqli_query($conn,$product_sql);
ob_end_flush();
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 my-4">

<link rel="stylesheet" type="text/css" href="<?php echo SITE_ADMIN_PATH ?>assets/css/add_product.css">

      <h2 style="margin-top: 16px;">Products</h2>
      <a class="btn add-new-link p-0" id="add_new_cat">Add New Product</a>
      <div class="field_error text-danger"><?php if(!empty($msg)) print_r($msg)?></div>

      <div id="add_form" class="mb-3">

        <form class="row g-3 mt-2" method="POST" enctype="multipart/form-data">
          <div class="col-md-4">
            <select class="form-control form-control-sm" name="category_id"  required aria-label="Default select example"  >
              <option>Select Category</option>
              <?php
              $res=mysqli_query($conn,'select id, category from categories order by category asc');
              while($row=mysqli_fetch_assoc($res)){
                if($row['id']==$category_id){
                  echo "<option selected value=".$row['id'].">".$row['category']."</option>";
                }else{
                  echo "<option value=".$row['id'].">".$row['category']."</option>";
                }
              }
              ?>
            </select>
          </div>
          <div class="col-md-4">
            <select class="form-control form-control-sm" name="best_seller" required aria-label="Default select example">
              <option value="0">Select Best Seller</option>
              <option value="1">Yes</option>
              <option value="0">No</option>
            </select>
          </div>
          <div class="col-md-4">
            <input type="text" class="form-control form-control-sm" name="name" required placeholder="Product Name" id="name">
          </div>
          <div class="col-md-4">
            <input type="text" class="form-control form-control-sm" name="short_name" required placeholder="Product Short Name" id="short_name">
          </div>
          <div class="col-md-4">
            <input type="file" <?php echo $image_required; ?> name='image' accept="image/x-png,image/jpeg"  class="form-control form-control-sm">
          </div>
          <div class="col-md-4">
            <input type="number" class="form-control form-control-sm" required name="price" placeholder="price" id="inputZip">
          </div>
          <div class="col-12">
            <textarea class="form-control form-control-sm" required name="description" rows="2" placeholder="Enter Product Discription"></textarea>
          </div>
          <div class="col-12">
            <textarea class="form-control form-control-sm" required name="meta_keyword" rows="2" placeholder="Enter Product Meta Keyword"></textarea>
          </div>
          <div class="col-12">
            <div class="container">
              Add Tags | Press enter after you typed.
              <br />
              <br />
              <div class="tag-container">
                <input>  
              </div>
            </div>
          </div>
          <div class="col-12">
            <button type="submit" name="submit" id="new_cat_submit" class="btn btn-dark mt-2" style="line-height: 1.1">Submit</button>
          </div>
        </form>
      </div>

<script type="text/javascript" src="<?php echo SITE_ADMIN_PATH ?>assets/js/add_product.js"></script>

      <div class="table-responsive">
        <table class="table table-striped table-sm" id="products">
          <thead>
            <tr>
              <th>#</th>
              <th>CATEGORY</th>
              <th style="width: 40%;">NAME</th>
              <th>IMAGE</th>
              <th>PRICE</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php 
              $i=0;
              while($row=mysqli_fetch_assoc($product_res)) { $i=$i+1;
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
                <td><?php echo $row['price']; ?></td>
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

  $("#add_form").hide();
    $("#add_new_cat").click(function(){
    $("#add_form").toggle('hidden');
  });
});
</script>

