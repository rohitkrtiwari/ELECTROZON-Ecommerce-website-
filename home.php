<?php
session_start();
session_regenerate_id( true );
require('connection.inc.php');
require('functions.inc.php');

$user_id = get_user($conn)[0]; $loggedin = get_user($conn)[1];
$new_arrivals_data=get_product($conn, 5);
$best_seller_data=get_product($conn,5,'','','',1);
?>

<!DOCTYPE html>
<html>
<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo SITE_PATH ?>assets/css/theme.css" rel="stylesheet">
  <link href="<?php echo SITE_PATH ?>assets/css/style.css" rel="stylesheet">
  <link href="<?php echo SITE_PATH ?>assets/css/preloader.css" rel="stylesheet">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="HandheldFriendly" content="true">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">



	<title>Electrozon | Home</title>

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

<!-- Banner Section -->
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner carousel-height">
    <div class="carousel-item active">
      <img class="d-block w-100" src="assets/images/banner/1.jpg" alt="First slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="assets/images/banner/2.jpg" alt="Second slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="assets/images/banner/3.jpg" alt="Third slide">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>



<div id="alert-msg"></div>


<!-- New Arrivals -->

  <!-- Products Full View Section -->
  <section class="category_full_view  d-flex">

    <div class="grid-view px-2">
      <div class="product-row-heading border-bottom d-flex">
        <div class="product-row-heading-title ">
          <span class="fs-5 fw-bold text-uppercase">New Arrivals</span>
        </div>

        <div class="ms-auto pb-3"> 
          <a class="btn view_all_btn" href="<?php echo SITE_PATH ?>all_product/new_arrivals">VIEW ALL</a> 
        </div>
      </div>

      <div class="row">

        <?php $n=0; foreach ($new_arrivals_data as $product) { $n+=1; if($n>5) break;?>
        <div class="col-2 product-img py-3 my-1 h-75 cat_prdct_view">
          <div class="prdct-box border rounded-3 pt-3 position-relative" style="height: 354px;">
            <a href="<?php echo SITE_PATH; ?>product/<?php echo $product['id'] ?>" class="product-link">
              <div class="product-img">
                <img src=" <?php echo PRODUCT_IMAGE_SITE_PATH.$product['image'];?> " style="height: 100%; width: 100%;object-fit: contain;"alt="Avatar">
              </div>
              <div class="container mt-4 text-center">
                <span class="product-name"><?php echo $product['short_name'] ?></span><br>
                <span class="product-price"><i class="fa fa-inr"></i><?php echo $product['price'] ?></span>
              </div>
            </a>
            <div class="shopping-controls mt-3 position-absolute bottom-0"><button class="product-button py-2" onclick="addCart('<?php echo $user_id; ?>',<?php echo $product['id'] ?>)"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
            </div>
          </div>
        </div> 
        <?php } ?>
      </div>
    </div>
  </section>


  <!-- Products Responsive View Section -->
  <div class="category_resp mt-4">
    <div class="product-row-heading d-flex">
      <div class="product-row-heading-title ">
        <span class="fs-5 fw-bold text-uppercase" >NEW ARRIVALS</span>
      </div>

      <div class="ms-auto mb-3 pe-3"> 
        <a class="btn view_all_btn" href="<?php echo SITE_PATH ?>all_product/new_arrivals">VIEW ALL</a> 
      </div>
    </div>
    <table class="table table-bordered">
      <tr>
      <?php $i=0; foreach ($new_arrivals_data as $product) { $i+=1;?>
        <td class="w-50 " onclick="location.href='<?php echo SITE_PATH ?>product/<?php echo $product['id'] ?>'" style="cursor:pointer; background: #fff;">
          
          <div class="row"><img src=" <?php echo PRODUCT_IMAGE_SITE_PATH.$product['image'];?> " class="p-4" style="max-height:250px;width: 100%;object-fit: contain;"alt="Avatar"></div>

          <div style="vertical-align: bottom; display: table-cell">
            <div class="ps-3"><?php echo $product['short_name'] ?></div>
            <div class="ps-3">
              <?php 
                echo "<span class='p-dark'><i class='fa fa-inr'></i>".$product['price']."</span>";
                
              ?>
            </div>
          </div>
        </td>
      <?php if ($i==4) break; if(($i%2)==0) echo "</tr><tr>"; } ?>
      </tr>
    </table>
  </div>


<!-- Best Sellers -->
<!-- Products Full View Section -->
  <section class="category_full_view  d-flex">

    <div class="grid-view px-2">
      <div class="product-row-heading border-bottom d-flex">
        <div class="product-row-heading-title ">
          <span class="fs-5 fw-bold text-uppercase" >Best Sellers</span>
        </div>

        <div class="ms-auto pb-3"> 
          <a class="btn view_all_btn" href="<?php echo SITE_PATH ?>all_product/best_seller">VIEW ALL</a> 
        </div>
      </div>

      <div class="row">

        <?php 
          $n=0; 
          foreach ($best_seller_data as $product) 
            { 
              if($product['best_seller']==1){
              $n+=1;  
              if($n>5) break;
        ?>

        <div class="col-2 product-img py-3 my-1 h-75 cat_prdct_view">
          <div class="prdct-box border rounded-3 pt-3 position-relative" style="height: 354px;">
            <a href="<?php echo SITE_PATH; ?>product/<?php echo $product['id'] ?>" class="product-link">
              <div class="product-img">
                <img src=" <?php echo PRODUCT_IMAGE_SITE_PATH.$product['image'];?> " style="height: 100%; width: 100%;object-fit: contain;"alt="Avatar">
              </div>
              <div class="container mt-4 text-center">
                <span class="product-name"><?php echo $product['short_name'] ?></span><br>
                <span class="product-price"><i class="fa fa-inr"></i><?php echo $product['price'] ?></span>
              </div>
            </a>
            <div class="shopping-controls mt-3 position-absolute bottom-0"><button class="product-button py-2" onclick="addCart('<?php echo $user_id; ?>',<?php echo $product['id'] ?>)"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
            </div>
          </div>
        </div> 
        <?php } } ?>
      </div>
    </div>
  </section>


  <!-- Products Responsive View Section -->
  <div class="category_resp">
    <div class="product-row-heading d-flex">
      <div class="product-row-heading-title ">
        <span class="fs-5 fw-bold text-uppercase" >Best Sellers</span>
      </div>

      <div class="ms-auto mb-3 pe-3"> 
        <a class="btn view_all_btn" href="<?php echo SITE_PATH ?>all_product/best_seller">VIEW ALL</a> 
      </div>
    </div>
    <table class="table table-bordered">
      <tr>
      <?php $i=0; foreach ($best_seller_data as $product) { if($product['best_seller']==1){ $i+=1;?>
        <td class="w-50 " onclick="location.href='<?php echo SITE_PATH ?>product/<?php echo $product['id'] ?>'" style="cursor:pointer; background: #fff;">
          
          <div class="row"><img src=" <?php echo PRODUCT_IMAGE_SITE_PATH.$product['image'];?> " class="p-4" style="max-height:250px;width: 100%;object-fit: contain;"alt="Avatar"></div>

          <div style="vertical-align: bottom; display: table-cell">
            <div class="ps-3"><?php echo $product['short_name'] ?></div>
            <div class="ps-3">
              <?php 
                echo "<span class='p-dark'><i class='fa fa-inr'></i>".$product['price']."</span>";
                
              ?>
            </div>
          </div>
        </td>
      <?php if ($i==4) break; if(($i%2)==0) echo "</tr><tr>"; } }?>
      </tr>
    </table>
  </div>



<!-- Footer Section -->

<?php
require('prerequisite/footer.php');
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script src="<?php echo SITE_PATH; ?>assets/js/custom.js"></script>

</body>
</html>
