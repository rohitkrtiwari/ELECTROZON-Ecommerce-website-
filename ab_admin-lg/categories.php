<?php
ob_start();
require('home.php');

$msg = '';

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
    $update_status_sql="update categories set status='$status' where id='$id'";
    if(mysqli_query($conn,$update_status_sql)) header('location:'.SITE_ADMIN_PATH.'categories');
    else $error_msg = "Can't the category right now";

  }
  

  // Delete Category from website
  if($type=='delete'){
    $id=get_safe_value($conn,$_GET['id']);
    $delete_sql="delete from categories where id='$id'";
    if(mysqli_query($conn,$delete_sql)) header('location:'.SITE_ADMIN_PATH.'categories');
    else $error_msg = "Can't delete the category right now";
  }
}



if(isset($_POST['type']) && $_POST['type']!=''){
  $type=get_safe_value($conn,$_POST['type']);

  // Update Category Name of website
  if($type=='update_catname'){
    $catId=get_safe_value($conn,$_POST['catId']);
    $catname=get_safe_value($conn,$_POST['catname']);
    
    $update_status_sql="update categories set category='$catname' where id='$catId'";
    if(mysqli_query($conn,$update_status_sql)) return true;
    else return false;

  }

}

if(isset($_POST['new_cat_submit'])){

  if(isset($_POST['categories']) && $_POST['categories']!='')
  {
    $categories=get_safe_value($conn,$_POST['categories']);
    if($categories!='')
    {  
      $sql="INSERT INTO `categories`(`category`, `status`) VALUES ('$categories', 1)";
      if(mysqli_query($conn,$sql)) header('location:'.SITE_ADMIN_PATH.'categories ');
      else $msg="**Category Field can't be empty";
    }
  }
  else
    $msg="**Category Field can't be empty";

}

// Fetch all the categories from database 
$sql="select * from categories order by id"; 
$res = mysqli_query($conn,$sql);


ob_end_flush();
?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 my-4">
<link rel="stylesheet" type="text/css" href="<?php echo SITE_ADMIN_PATH ?>assets/css/categories.css">


      <h2 style="margin-top: 16px;">Category Master</h2>
      <a class="btn add-new-link p-0" id="add_new_cat">Add New Category</a>
      <div class="field_error text-danger"><?php echo $msg?></div>

      <div id="add_form" class="mb-3">
        <form class="ad-form" method="POST">
          <h4>Create new Category</h4>
          <div class="form-group input-group-sm">
            <input type="text" name="categories" id="categories" placeholder="Enter Sub Category" class="form-control" >
            <span id="catnamecheck" ></span>
          </div>
          <button type="submit" name="new_cat_submit" id="new_cat_submit" class="btn btn-dark mt-2" style="line-height: 1.1">Submit</button>
        </form> 
      </div>


      <div class="table-responsive">
        <table class="table table-sm" id="categories">
          <thead>
            <tr>
              <th>#</th>
              <th>ID</th>
              <th title="double click to edit category">CATEGORIES</th>
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
                <td ondblclick="enable(<?php echo $row['id']; ?>)"><input value="<?php echo $row['category']; ?>" class="cat_name edit_field" id="<?php echo $row['id']; ?>" title="double click to edit category" disabled></td>
                <td>
                  <div class="op-link">
                  <?php 
                    if($row['status']==1){
                      echo '<span class="badge-green"><a href="'.SITE_ADMIN_PATH.'categories.php?type=status&operation=deactive&id='.$row['id'].'">'."Active".'</a></span>&nbsp';
                    } else{
                      echo '<span class="badge-light-red"><a href="'.SITE_ADMIN_PATH.'categories.php?type=status&operation=active&id='.$row['id'].'">'."Deactive".'</a></span>&nbsp';
                    }
                  ?>  
                  <span class="badge-red"><a href="<?php echo SITE_ADMIN_PATH ?>categories.php?type=delete&id=<?php echo $row['id']?>">Delete</a></span>
                  </div>
                </td>
              <?php } ?>
            </tr>
          </tbody>
        </table>
      </div>
    </main>


<script type="text/javascript">
  $("form").attr('autocomplete', 'off');
  $(document).ready(function(){
    
    $("#search").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#categories tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

    $('#catnamecheck').hide();
    var fname_err = true;
    $('#categories').keyup(function(){
     fname_check();
    });
    function fname_check(){
      var user_val = $('#categories').val();
      if(user_val.length == ''){
        $('#catnamecheck').show();
        $('#catnamecheck').html("**Please Fill the Category");
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
