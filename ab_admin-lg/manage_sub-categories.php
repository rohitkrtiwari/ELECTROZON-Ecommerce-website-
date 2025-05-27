<?php
ob_start();
require('home.php');
$sub_categories='';
$msg='';
if(isset($_GET['id']) && $_GET['id']!=''){
	$id=get_safe_value($conn,$_GET['id']);
	$res=mysqli_query($conn,"select * from sub_categories where id='$id'");
	$check=mysqli_num_rows($res);
	if($check>0){
		$row=mysqli_fetch_assoc($res);
		$sub_categories=$row['sub_categories'];
	}
}

if(isset($_POST['submit'])){
	$category_id=get_safe_value($conn,$_POST['category_id']);
	$sub_categories=get_safe_value($conn,$_POST['sub_categories']);
	$res=mysqli_query($conn,"select * from sub_categories where sub_categories='$sub_categories'");
	$check=mysqli_num_rows($res);
	if($check>0){
		if(isset($_GET['id']) && $_GET['id']!=''){
			$getData=mysqli_fetch_assoc($res);
			if($id==$getData['id']){
			
			}else{
				$msg="Sub Categories already exist";
			}
		}else{
			$msg="Sub Categories already exist";
		}
	}
	
	if($msg==''){
		if(isset($_GET['id']) && $_GET['id']!=''){
			mysqli_query($conn,"update sub_categories set sub_categories='$sub_categories' where id='$id'");
		}else{
			$sql = "insert into sub_categories(category_id, sub_categories,status) values('$category_id','$sub_categories','1')";
			echo $sql;
			mysqli_query($conn, $sql);
		}
		header('location:'.SITE_ADMIN_PATH.'sub_categories');
		die();
	}
}

ob_end_flush();
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 my-4">

<form class="ad-form" method="POST">
<h2>Create new Category</h2>
  <div class="form-group ">

  	<div class="input-group mb-3">
	   	<label class="input-group-text">Categories</label>
		<select class="form-control form-control-sm" name="category_id" aria-label="Default select example"  >
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

    <input type="text" name="sub_categories" placeholder="Enter Sub Category" class="form-control" required value="<?php echo $sub_categories?>">
  </div>
  <button type="submit" name="submit" class="btn btn-dark mt-2" style="line-height: 1.1">Submit</button>
   <div class="field_error"><?php echo $msg?></div>

</form>
</main>
