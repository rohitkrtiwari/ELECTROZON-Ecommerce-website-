<?php
ob_start();
error_reporting(E_ALL);
require('home.php');
$msg=array();
$tags=array();
$name='';
$short_name='';
$category_id='';
$price='';
$image='';
$description='';
$meta_keyword='';
$best_seller='';

$msg='';
$image_required='required';
if(isset($_GET['id']) && $_GET['id']!=''){
	$image_required='';
	$id=get_safe_value($conn,$_GET['id']);
	$res=mysqli_query($conn,"select * from product where id='$id'");
	$check=mysqli_num_rows($res);
	if($check>0){
		$row=mysqli_fetch_assoc($res);
		$name=$row['name'];
		$short_name=$row['short_name'];
		$category_id=$row['category_id'];
		$price=$row['price'];
		$description=$row['description'];
		$meta_keyword=$row['meta_keyword'];
		$best_seller=$row['best_seller'];
	}else{
		header('location:'.SITE_ADMIN_PATH.'product');
		die();
	}
	$tags_res = mysqli_query($conn, "SELECT tag from tags WHERE pid = '$id'");
	while ($tags_row=mysqli_fetch_assoc($tags_res)){
		$tags[]=$tags_row['tag'];
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
	    $new_tags = array();
	    foreach ($_POST['tags'] as $key ) {
	      array_push($new_tags, $key);
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
	
	if(empty($msg))
	{
		$res=mysqli_query($conn,"select * from product where name='$name'");
		$check=mysqli_num_rows($res);
		if($check>0){
			if(isset($_GET['id']) && $_GET['id']!=''){
				$getData=mysqli_fetch_assoc($res);
				if($id==$getData['id']){
				
				}else{
					array_push($msg,"Product already exist");
				}
			}else{
				array_push($msg,"Product already exist");
			}
		}		
	}

	if(isset($_GET['id']) && $_GET['id']==0){
		if($_FILES['image']['type']!='image/png' && $_FILES['image']['type']!='image/jpg' && $_FILES['image']['type']!='image/jpeg'){
			array_push($msg,"Please select only png,jpg and jpeg image formate");
		}
	}else{
		if($_FILES['image']['type']!=''){
				if($_FILES['image']['type']!='image/png' && $_FILES['image']['type']!='image/jpg' && $_FILES['image']['type']!='image/jpeg'){
				array_push($msg,"Please select only png,jpg and jpeg image formate");
			}
		}
	}
	
	if(empty($msg)){
		echo "no errors found";
		if(isset($_GET['id']) && $_GET['id']!=''){
			if($_FILES['image']['name']!=''){
				$image = rand(111111111,999999999).'_'.$_FILES['image']['name'];
				copy($_FILES['image']['tmp_name'],PRODUCT_IMAGE_SERVER_PATH.$image);
				$update_sql="update product set category_id='$category_id', name='$name', short_name='$short_name', price='$price',  description='$description', meta_keyword='$meta_keyword', best_seller='$best_seller', image='$image' where id='$id'";
			}else{
				$update_sql="update product set category_id='$category_id', name='$name', short_name='$short_name', price='$price', description='$description', meta_keyword='$meta_keyword', best_seller='$best_seller' where id='$id'";
			}
			
			if(mysqli_query($conn,$update_sql)){
				try{
			        add_tags($conn, $id, $new_tags);
			      }
			      catch(Exception $e){
			        echo $e;
			      }
				header('location:'.SITE_ADMIN_PATH.'products ');
			}
			else
				array_push($msg, "query execution failuer");

		}else{
			$image = rand(111111111,999999999).'_'.$_FILES['image']['name'];
			copy($_FILES['image']['tmp_name'],PRODUCT_IMAGE_SERVER_PATH.$image);
			$sql = "insert into product(name, short_name, category_id,price,description, meta_keyword,status,image, best_seller) values('$name', '$short_name', '$category_id', '$price', '$description', '$meta_keyword', '1', '$image', '$best_seller')";
			if(mysqli_query($conn,$sql)){
				echo "query executed successfully";
				header('location:'.SITE_ADMIN_PATH.'products');
			}else{
				array_push($msg, "query execution failuer");
			}
		}
		die();
	}
}

// Function to add tags
function add_tags($conn, $product_id, $tags){
  try{
  	mysqli_query($conn, "DELETE from tags where pid = '$product_id'");
  }
  catch(Exception $e){
    echo $e;
  }
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

ob_end_flush();
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 my-4">
<link rel="stylesheet" type="text/css" href="<?php echo SITE_ADMIN_PATH ?>assets/css/add_product.css">

<form class="ad-form form" method="POST" enctype="multipart/form-data">
<h2>Add new Product</h2>
	<div class="alert alert-danger" id="alert"role="alert">
      <strong>
        <?php
          if(!empty($msg)){
            foreach ($msg as $error) {
            	echo "<script>alertMsg('".$error."')</script>";
            }
          }else{
            echo "<script>";
            echo "var alertbox = document.getElementById('alert');";
            echo "alertbox.style.display='none';";
            echo "</script>";
          }
        ?>
      </strong>
    </div>

    <div class="input-group mb-3">
	   	<label class="input-group-text">Categories</label>
		<select class="form-control form-control-sm" name="category_id" aria-label="Default select example"  >
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

	<div class="input-group mb-3">
	  <label class="input-group-text">Product Name</label>
	  <input type="text" required  name="name" value="<?php echo $name; ?>" class="form-control form-control-sm" placeholder="Enter Product Name">
	  <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
	</div>


	<div class="input-group mb-3">
	  <label class="input-group-text">Product Short Name</label>
	  <input type="text" required  name="short_name" value="<?php echo $short_name; ?>" class="form-control form-control-sm" placeholder="Enter Product Short Name">
	</div>


	<div class="input-group mb-3">
	    <label class="input-group-text">Best Seller</label>
		<select class="form-control form-control-sm" name="best_seller" aria-label="Default select example">
		  <option value="1"<?php if($best_seller){ echo "selected";} ?> >Yes</option>
		  <option value="0" <?php if(!$best_seller){ echo "selected";} ?> >No</option>
		</select>
	</div>

	<div class="input-group mb-3">
	  <label class="input-group-text">Price</label>
	  <input type="number"  required name="price" value="<?php echo $price; ?>" class="form-control form-control-sm" placeholder="Price">
	</div>

	<div class="input-group mb-3">
	  <input type="file" <?php echo $image_required; ?> name='image' accept="image/x-png,image/jpeg"  class="form-control">
	  <label class="input-group-text">Upload Image</label>
	</div>

	<div class="input-group mb-3">
	  <label class="input-group-text">Discription</label>
	  <textarea class="form-control form-control-sm" required name="description" rows="2" placeholder="Enter Product Discription"><?php echo $description; ?></textarea>
	</div>

	<div class="input-group mb-3">
	  <label class="input-group-text">Meta Keyword</label>
	  <textarea class="form-control form-control-sm" required name="meta_keyword" rows="2" placeholder="Enter Product Meta Keyword"> <?php echo $meta_keyword; ?></textarea>
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

  
  <a href="<?php echo SITE_ADMIN_PATH."products" ?>" name="submit" class="btn btn-secondary" style="line-height: 1.1">Back</a>
  <button type="submit" name="submit" class="btn btn-dark float-end" style="line-height: 1.1">Submit</button>
</form>
<script type="text/javascript" src="<?php echo SITE_ADMIN_PATH ?>assets/js/add_product.js"></script>

<script type="text/javascript">
<?php foreach ($tags as $tag) { ?>
	createTagMan('<?php echo $tag ?>');
<?php } ?>
</script>

</main>




