<?php
ob_start();
require('home.php');
$msg='';
// Handling category CRUD operations
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
    $update_status_sql="update sub_categories set status='$status' where id='$id'";
    if(mysqli_query($conn,$update_status_sql)) header('location:'.SITE_ADMIN_PATH.'sub_categories');
    else $error_msg = "Can't the category right now";

  }
  

  // Delete Category from website
  if($type=='delete'){
    $id=get_safe_value($conn,$_GET['id']);
    $delete_sql="delete from sub_categories where id='$id'";
    if(mysqli_query($conn,$delete_sql)) header('location:'.SITE_ADMIN_PATH.'sub_categories');
    else $error_msg = "Can't delete the category right now";
  }

}


if(isset($_POST['type']) && $_POST['type']!=''){

  $type=get_safe_value($conn,$_POST['type']);

  // Update Sub Category Name of website
  if($type=='update_subcatname'){
    $subcatId=get_safe_value($conn,$_POST['subcatId']);
    $subcatname=get_safe_value($conn,$_POST['subcatname']);
    
    $update_status_sql="UPDATE sub_categories set sub_categories='$subcatname' where id='$subcatId'";
    if(mysqli_query($conn,$update_status_sql)) return true; 
    else return false;

  }

  // Update Category ID of website
  if($type=='update_subcat_catID'){
    $subcatId=get_safe_value($conn,$_POST['subcatId']);
    $category_id=get_safe_value($conn,$_POST['catId']);
    
    $update_status_sql="UPDATE sub_categories set category_id='$category_id' where id='$subcatId'";
    if(mysqli_query($conn,$update_status_sql)) return true; 
    else return false;

  }

}

if(isset($_POST['new_subcat_submit'])){

  if(isset($_POST['sub_category']) && $_POST['sub_category']!='')
  {
    $sub_category=get_safe_value($conn,$_POST['sub_category']);
    $category_id=get_safe_value($conn,$_POST['category_id']);
    if($sub_category!='')
    {  
      $sql="INSERT INTO `sub_categories`(`category_id`, `sub_categories`, `status`) VALUES ('$category_id', '$sub_category', 1)";
      if(mysqli_query($conn,$sql)) header('location:'.SITE_ADMIN_PATH.'sub_categories ');
      else $msg="**Sub Categories Field can't be empty";
    }
  }
  else
    $msg="**Sub Categories Field can't be empty";

}



// Fetch all the categories from database 
$sql="select * from sub_categories order by id"; 
$res = mysqli_query($conn,$sql);


ob_end_flush();
?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 my-4">
<link rel="stylesheet" type="text/css" href="assets/css/categories.css">
      <h2 style="margin-top: 16px;">Sub Categories</h2>
      <a class="btn add-new-link p-0" id="add_new_cat">Add New Sub Category</a>
      <div class="field_error text-danger"><?php echo $msg?></div>

      <div id="add_form" class="mb-3">
        <form class="ad-form" method="POST">
          <h4>Create new Category</h4>

          <div class="input-group input-group-sm mb-3">
            <label class="input-group-text">Categories</label>
            <select class="form-control form-control-sm" name="category_id" aria-label="Default select example"  >
              <?php
              $cat_res=mysqli_query($conn,'select id, category from categories order by category asc');
              while($cat_row=mysqli_fetch_assoc($cat_res)){
                  echo "<option value=".$cat_row['id'].">".$cat_row['category']."</option>";
              }
              ?>
            </select>
          </div>
          
          <div class="form-group input-group-sm">
            <input type="text" name="sub_category" id="sub_category" placeholder="Enter Sub Category" class="form-control" >
            <span id="catnamecheck" ></span>
          </div>
          <button type="submit" name="new_subcat_submit" id="new_cat_submit" class="btn btn-dark mt-2" style="line-height: 1.1">Submit</button>
        </form> 
      </div>


      <div class="table-responsive">
        <table class="table table-striped table-sm" id="categories">
          <thead>
            <tr>
              <th>#</th>
              <th>ID</th>
              <th>CATEGORIES</th>
              <th>SUB CATEGORIES</th>
              <th></th>
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
                <td ondblclick="enable(<?php echo $i+100 ?>)"><select disabled class="form-control form-control-sm subcat_catID edit_field" id="<?php echo $i+100 ?>" sd="<?php echo $row['id']; ?>" name="category_id" aria-label="Default select example"  >
                  <?php
                    $category_id = $row['category_id'];
                    $cat_res=mysqli_query($conn,"select * from categories order by category asc");
                    while($cat_row=mysqli_fetch_assoc($cat_res)){
                      if($cat_row['id']==$category_id){
                        echo "<option selected value=".$cat_row['id'].">".$cat_row['category']."</option>";
                      }else{
                        echo "<option value=".$cat_row['id'].">".$cat_row['category']."</option>";
                      }
                    }
                  ?></select>
                </td>
                <td ondblclick="enable(<?php echo $row['id']; ?>)"><input value="<?php echo $row['sub_categories']; ?>" class="subcat_name edit_field" id="<?php echo $row['id']; ?>" title="double click to edit category" disabled></td>
                <td>
                  <div class="op-link">
                  <?php 
                    if($row['status']==1){
                      echo '<span class="badge-green"><a href="'.SITE_ADMIN_PATH.'sub_categories.php?type=status&operation=deactive&id='.$row['id'].'">'."Active".'</a></span>&nbsp';
                    } else{
                      echo '<span class="badge-light-red"><a href="'.SITE_ADMIN_PATH.'sub_categories.php?type=status&operation=active&id='.$row['id'].'">'."Deactive".'</a></span>&nbsp';
                    }
                  ?>  
                  <span class="badge-red"><a href="<?php echo SITE_ADMIN_PATH ?>sub_categories.php?type=delete&id=<?php echo $row['id']?>">Delete</a></span>
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
    $("#categories tbody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });

  $('#catnamecheck').hide();
    var fname_err = true;
    $('#sub_category').keyup(function(){
     fname_check();
    });
    function fname_check(){
      var user_val = $('#sub_category').val();
      if(user_val.length == ''){
        $('#catnamecheck').show();
        $('#catnamecheck').html("**Please Fill the Sub-Category Field");
        $('#catnamecheck').focus();
        $('#catnamecheck').css("color","red");
        fname_err = false;
        return false;
      }else{
        fname_err = true;
        $('#catnamecheck').hide();
      }
    }

    $('#new_cat_submit').click(function(){
      fname_err = true;
      fname_check();
      
      if(fname_err == true ){
       return true;
      }else{
       return false;
      }

    });



  });

$("#add_form").hide();
$("#add_new_cat").click(function(){
  $("#add_form").toggle('hidden');
});
</script>
