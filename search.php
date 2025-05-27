<?php
session_start();
require('connection.inc.php');
require('functions.inc.php');
$product_count=5;
$product_resp_count=2;

$user_id = get_user($conn)[0]; $loggedin = get_user($conn)[1];

if(isset($_GET['submit']) && $_GET['search']!=''){
  $str=strtolower(get_safe_value($conn,$_GET['search']));
  if($str != ''){
    $tags_sql = "SELECT pid from tags where tag like '%$str%'";
    $tags_res = mysqli_query($conn, $tags_sql);
    if(mysqli_num_rows($tags_res)>0){
      while ($tags_row=mysqli_fetch_assoc($tags_res)){
        $pid_data[]=$tags_row['pid'];
      }
      $category_product=get_product($conn,'','','',$str, '', $pid_data);
    }else
      $category_product=get_product($conn,'','','',$str, '');
    if(count($category_product)>0){

    }else{
      $category_product='';
    }
  }else{
    $category_product='';
  }
}else{
  header('location:'.SITE_PATH);
}



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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="HandheldFriendly" content="true">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<title>Electrozon Search Results : <?php echo $str; ?></title>

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

<!-- Products Full View Section -->
<section class="category_full_view d-flex">

  <div class="grid-view w-25">
    <span class="fs-2 px-5">CATEGORIES</span>


    <!-- Category View Left Panel -->
    <div class="list-group mt-4">
      <?php $sql = 'SELECT * from categories where status=1'; $res=mysqli_query($conn, $sql); while($row=mysqli_fetch_assoc($res)) { ?>
        <button type="button" onclick="location.href='<?php echo SITE_PATH ?>categories/<?php echo $row['id']?>'" class="list-group-item list-group-item-action <?php if($row['category']==$catname['category']) echo "active"; ?>"><?php echo $row['category']; ?>
        </button>
      <?php } ?>
    </div>
  </div>

  <div class="grid-view ms-0 px-2 w-75">
  <?php if($category_product != '') { ?>
    <!-- Grid View Heading -->
    <div class="product-row-heading">
      <div class="product-row-heading-title">
        <span class="fs-3 ps-0 p-light">Search Result: <?php echo $str; ?></span>
        <div id="alert-msg" style="background-color: #3d1a54;"></div>
      </div>
    </div>
    <!-- Product Display Section -->
    <div class="row">
      <?php foreach ($category_product as $product) { ?>
      <div class="col-sm-3 product-img py-3 my-1 h-75 cat_prdct_view">
        <div class="prdct-box border rounded-3 pt-3 position-relative" style="height: 400px;">
          <a href="<?php echo SITE_PATH ?>product/<?php echo $product['id'] ?>" class="product-link">
            <div class="product-img">
              <img src=" <?php echo PRODUCT_IMAGE_SITE_PATH.$product['image'];?> " style="height: 100%; width: 100%;object-fit: contain;"alt="Avatar">
            </div>
            <div class="container mt-4 text-center">
              <span class="product-name"><?php echo $product['short_name'] ?></span><br>
              <span class="product-price"><i class="fa fa-inr"></i><?php echo $product['price'] ?>  </span>
            </div>
          </a>
          <div class="shopping-controls mt-3 position-absolute bottom-0"><button class="product-button py-2" onclick="addCart('<?php echo $user_id; ?>',<?php echo $product['id'] ?>)"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
            </div>
        </div>
      </div> 
      <?php } ?>
    </div>
  <?php } else {?>
    <!-- Empty Results-->
    <div class="grid-view row">
      <p>
        </p><center><img src="<?php echo SITE_PATH ?>assets/images/shopping_empty.png" style="width: 250px;" alt="Shopping Cart Empty"></center>
      <p></p>
      <p style="font-size: 19px; text-align: center; text-transform: initial;">No results found</p>
      <p style="font-size: 16px; text-align: center;">Try different keywords or remove search filters</p>
      <center><a href="<?php echo SITE_PATH ?>" class="btn btn-dark">Shop Now</a></center>
    </div>
  <?php } ?>

</section>


<!-- Products Responsive View Section -->
<div class="category_resp">
  <?php if($category_product != '') { ?>
  <center class="fs-2 my-2">Search Result: <?php echo $str; ?></center>
  <table class="table table-bordered">
    <tr>
    <?php $i=0; foreach ($category_product as $product) { $i+=1;?>
      <td class="w-50" onclick="location.href='<?php echo SITE_PATH ?>product/<?php echo $product['id'] ?>'" style="cursor:pointer; background: #fff;">
        
        <div class="row"><img src=" <?php echo PRODUCT_IMAGE_SITE_PATH.$product['image'];?> " class="p-4" style="max-height:250px;width: 100%;object-fit: contain;"alt="Avatar"></div>

        <div style="vertical-align: bottom; display: table-cell">
          <div class="ps-3"><?php echo $product['short_name'] ?></div>
          <div class="ps-3">
            <?php 
              echo "<span class='p-dark'><i class='fa fa-inr'></i>".$product['price']."</span>";
              echo "<span class='p-sml p-light'> <i class='fa fa-inr'></i><s>".($product['mrp'])."</s></span>"; 
              echo "<span class='prdct-price-percent'> ".number_format(($product['price']/$product['mrp'])*100, 2)."% off</span>";
            ?>
          </div>
        </div>
      </td>
    <?php if(($i%2)==0) echo "</tr><tr>"; } ?>
    </tr>
  </table>
  <?php } else {?>
    <!-- Empty Results-->
    <div class="cart-empty-alert">
      <p>
        </p><center><img src="assets/images/shopping_empty.png" style="width: 250px;" alt="Shopping Cart Empty"></center>
      <p></p>
      <p style="font-size: 19px; text-align: center; text-transform: initial;">No results found</p>
      <p style="font-size: 16px; text-align: center;">Try different keywords or remove search filters</p>
      <center><a href="<?php echo SITE_PATH ?>" class="btn btn-dark" style="line-height: 1.1;">Shop Now</a></center>
    </div>
  <?php } ?>
</div>

<!-- Footer Section -->

<?php
require('prerequisite/footer.php');
?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="assets/js/custom.js"></script>


</body>
</html>
