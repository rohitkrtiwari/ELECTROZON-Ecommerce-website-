<?php
session_start();
require('connection.inc.php');
require('functions.inc.php');

$product_resp_count=2;
$user_id = get_user($conn)[0]; $loggedin = get_user($conn)[1];

if(isset($_GET['catid']) && $_GET['catid']!=''){
  $catid=get_safe_value($conn,$_GET['catid']);
  $catname_sql = 'SELECT * from categories where id='.$catid;
  $catname_data=mysqli_query($conn, $catname_sql);
  $catname=mysqli_fetch_assoc($catname_data);
}else{
  header('location:'.SITE_PATH);
}


$category_product=get_product($conn,'', $catid);

?>

<!DOCTYPE html>
<html>
<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo SITE_PATH ?>assets/css/theme.css" rel="stylesheet">
  <link href="<?php echo SITE_PATH ?>assets/css/style.css" rel="stylesheet">
  <link href="<?php echo SITE_PATH ?>assets/css/preloader.css" rel="stylesheet">
  <link href="<?php echo SITE_PATH ?>assets/css/header.css" rel="stylesheet">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="HandheldFriendly" content="true">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<title><?php echo $catname['category']; ?> - ELECTROZON</title>

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



<div id="alert-msg"></div>

<section class="bg-white">  
  <div class="container-fluid mt-2">
    <div class="row my-3">

      <div class="col-auto mt-2">
        <nav id="sidebarMenu" class=" d-md-block bg-light sidebar collapse">
        <h5 class="mx-3 mt-3">All Categories</h5>
          <div class="position-sticky pt-3">
            <ul class="nav flex-column">
              <?php $sql = 'SELECT * from categories where status=1'; $res=mysqli_query($conn, $sql); while($row=mysqli_fetch_assoc($res)) { ?>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo SITE_PATH ?>categories/<?php echo $row['id']?>">
                  <span data-feather="shopping-cart"></span>
                  <?php echo $row['category']; ?>
                </a>
              </li>
              <?php } ?>
            </ul>

          </div>
        </nav>
      </div>

      <div class="col pt-1">
        <p > <a class="fs-14 text-decoration-none fw-bold" href="<?php echo SITE_PATH ?>">Home > </a> <a class="fs-14 text-decoration-none text-danger fw-bold" href="#"> <?php echo $catname['category'] ?> </a></p>
        <h2 class="text-dark"><?php echo $catname['category'] ?></h2>
        <div class="row">
      
      <?php if(count($category_product)>0) { ?>

      <?php foreach ($category_product as $product) { ?>
      <div class="category_full_view col-sm-3 py-3 px-0 mx-0 my-1 h-75 cat_prdct_view">
        <div class="prdct-box border rounded-3 pt-3 position-relative" style="height: 385px;">
          <a href="<?php echo SITE_PATH ?>product/<?php echo $product['id'] ?>" target="_blank" class="product-link">
            <div class="product-img">
              <img src=" <?php echo PRODUCT_IMAGE_SITE_PATH.$product['image'];?> " style="height: 100%; width: 100%;object-fit: contain;"alt="Avatar">
            </div>
            <div class="container mt-4 text-center">
              <span class="product-name"><?php echo $product['short_name'] ?></span><br>
              <span class="product-price"><i class="fa fa-inr"></i><?php echo $product['price'] ?> <span><i class="fa fa-inr"></i><?php echo $product['mrp'] ?></span> </span>
            </div>
          </a>
          <div class="shopping-controls mt-3 position-absolute bottom-0"><button class="product-button py-2" onclick="addCart('<?php echo $user_id; ?>',<?php echo $product['id'] ?>)"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
            </div>
        </div>
      </div> 
      <?php } ?>
      <?php } else {?>
      <!-- Empty Results-->
      <div class="cart-empty-alert">
        <p>
          </p><center><img src="<?php echo SITE_PATH ?>assets/images/shopping_empty.png" style="width: 250px;" alt="Shopping Cart Empty"></center>
        <p></p>
        <p style="font-size: 19px; text-align: center; text-transform: initial;">No Products found in This Category</p>
        <p style="font-size: 16px; text-align: center;">Try different Categories or Search the Product by Name</p>
      </div>
    <?php } ?>
  </div>
</section>

 <!-- Products Responsive View Section -->
<section class="responsive">
  <div class="category_resp">
    <?php if($category_product != '') { ?>
    
    <table class="table table-bordered">
      <tr>
      <?php $i=0; foreach ($category_product as $product) { $i+=1;?>
        <td class="w-50" onclick="location.href='<?php echo SITE_PATH ?>product/<?php echo $product['id'] ?>'" style="cursor:pointer; background: #fff;">
          
          <div class="row"><img src=" <?php echo PRODUCT_IMAGE_SITE_PATH.$product['image'];?> " class="p-4" style="max-height:250px;width: 100%;;object-fit: contain;"alt="Avatar"></div>

          <div style="vertical-align: bottom; display: table-cell">
            <div class="ps-3"><?php echo $product['short_name'] ?></div>
            <div class="ps-3">
              <?php 
                echo "<span class='p-dark'><i class='fa fa-inr'></i>".$product['price']."</span>";
              ?>
            </div>
          </div>
        </td>
      <?php if(($i%2)==0) echo "</tr><tr>"; } ?>
      </tr>
    </table>
    <?php } ?>
  </div>
</section>


<!-- Footer Section -->

<?php
require('prerequisite/footer.php');
?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="<?php echo SITE_PATH; ?>assets/js/custom.js"></script>


</body>
</html>
