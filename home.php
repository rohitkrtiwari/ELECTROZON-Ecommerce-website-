<?php
session_start();
// session_regenerate_id( true );
require('connection.inc.php');
require('functions.inc.php');

$user_id = get_user($conn)[0]; $loggedin = get_user($conn)[1];
$new_arrivals_data=get_product($conn, 8);
$best_seller_data=get_product($conn,8,'','','',1);
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo SITE_PATH ?>assets/css/theme.css" rel="stylesheet">
  <link href="<?php echo SITE_PATH ?>assets/css/style.css" rel="stylesheet">
  <link href="<?php echo SITE_PATH ?>assets/css/preloader.css" rel="stylesheet">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="HandheldFriendly" content="true">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <style type="text/css">


    /*
    *****************************************
    ! BANNER SLIDER ! ----------------------*
    *****************************************
    */

    .slick-slide {
       height:225px;
    }

    .slick-slide img {
       height:225px;
    }

    /*reset*/
    ul.bannerSlider{
      padding-left:0;
    }
    .bannerSlider{
      height: 225px;
    }
    .bannerSlider .slide__image::before{
      content: "";
      position: absolute;
      width: 100%;
      height: 225px;
      background: rgba(33,33,33,.7);
    }
    .bannerSlider .slick-slide {
      position: relative;
    }
    .bannerSlider .slide__image img {
      width: 100%;
      height: 225px;
      object-fit:cover;
    }
    img.slide__image__top-position {
      object-position:center bottom;
    }
    .bannerSlider .slide__text {
        position: absolute;
        z-index: 100;
        text-align: center;
        width: 100%;
        top: 50%;
        transform: translateY(-50%);
    }
    .bannerSlider .slide__text h2 {
      font-size: 48px;
      font-weight: 100;

      color: #fff;
    }
  </style>


	<title>Online Shopping for electronic components</title>

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

<!--  BANNER SLIDER  -->
  <div class="banner">
    <div class="row fullwidth">
      <div class="col-md-12">
        <ul class="bannerSlider">
          <!--  1. slide  -->
          <li class="slide">
            <a href="#">
              <div class="slide__text">
                <h2>This is the otter.</h2>
              </div>
              <div class="slide__image">
                <img src="<?php echo SITE_PATH ?>assets/images/banner/1.jpg" alt="" />
              </div>
            </a>
          </li>
          <!--  2. slide  -->
          <li class="slide">
            <a href="#">
              <div class="slide__text">
                <h2>Otters are cool. </h2>
              </div>
              <div class="slide__image">
                <img src="<?php echo SITE_PATH ?>assets/images/banner/2.jpg" alt="" />
              </div>
            </a>
          </li>
          <!--  3. slide  -->
          <li class="slide">
            <a href="#">
              <div class="slide__text">
                <h2>They swim, eat and sleep.</h2>
              </div>
              <div class="slide__image">
                <img src="<?php echo SITE_PATH ?>assets/images/banner/3.jpg" alt="" />
              </div>
            </a>
          </li>
          <!--  4. slide  -->
          <li class="slide">
            <a href="#">
              <div class="slide__text">
                <h2>Coming soon.</h2>
              </div>
              <div class="slide__image">
                <img src="<?php echo SITE_PATH ?>assets/images/banner/4.jpg" alt="" />
              </div>
            </a>
          </li>
          
        </ul>
      </div>
    </div>
  </div>



<div id="alert-msg"></div>


<!-- New Arrivals -->

  <!-- Products Full View Section -->

    <div class="category_full_view container mt-5">
      
      <div class="product-row-heading border-bottom d-flex">
        <div class="product-row-heading-title ">
          <span class="fs-5 fw-bold text-uppercase">New Arrivals</span>
        </div>
        <div class="ms-auto pb-3"> 
          <a class="btn view_all_btn" href="<?php echo SITE_PATH ?>all_product/new_arrivals">VIEW MORE</a> 
        </div>
      </div>

      <div class="row" style="width: fit-content; margin:auto;">

        <?php $n=0; foreach ($new_arrivals_data as $product) { $n+=1; if($n>8) break;?>
        <div class="col-sm-3 py-3 m-auto cat_prdct_view">
          <div class="prdct-box border rounded-3 pt-3 position-relative" style="height: 400px;">
            <a href="<?php echo SITE_PATH ?>product/<?php echo $product['id'] ?>" target="_blank" class="product-link">
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
    </div>

<!-- Products Responsive View Section -->
<div class="category_resp">
  <?php if($new_arrivals_data != '') { ?>
    
  <div class="product-row-heading mt-4 border-bottom d-flex">
        <div class="product-row-heading-title ">
          <span class="fs-5 fw-bold text-uppercase">New Arrivals</span>
        </div>
        <div class="ms-auto pb-3 me-3"> 
          <a class="btn view_all_btn" href="<?php echo SITE_PATH ?>all_product/new_arrivals">VIEW MORE</a> 
        </div>
  </div>
  
  <table class="table table-bordered">
    <tr>
    <?php $i=0; foreach ($new_arrivals_data as $product) { $i+=1;?>
      <td class="w-50" onclick="location.href='<?php echo SITE_PATH ?>product/<?php echo $product['id'] ?>'" style="cursor:pointer; background: #fff;">
        
        <div class="row"><img src=" <?php echo PRODUCT_IMAGE_SITE_PATH.$product['image'];?> " class="p-4" style="max-height:225px;width: 100%;object-fit: contain;"alt="Avatar"></div>

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
  <?php } else {?>
    <!-- Empty Results-->
    <div class="cart-empty-alert">
      <p>
        </p><center><img src="assets/images/shopping_empty.png" style="width: 225px;" alt="Shopping Cart Empty"></center>
      <p></p>
      <p style="font-size: 19px; text-align: center; text-transform: initial;">No results found</p>
      <p style="font-size: 16px; text-align: center;">Try different keywords or remove search filters</p>
      <center><a href="<?php echo SITE_PATH ?>" class="btn btn-dark" style="line-height: 1.1;">Shop Now</a></center>
    </div>
  <?php } ?>
</div>

<!-- Best Sellers -->
<!-- Products Full View Section -->

    <div class="category_full_view container mt-5">
      <div class="product-row-heading border-bottom d-flex">
        <div class="product-row-heading-title ">
          <span class="fs-5 fw-bold text-uppercase">Best Sellers</span>
        </div>

        <div class="ms-auto pb-3"> 
          <a class="btn view_all_btn" href="<?php echo SITE_PATH ?>all_product/new_arrivals">VIEW MORE</a> 
        </div>
      </div>

      <div class="row" style="width: fit-content; margin:auto;">

        <?php 
          $n=0; 
          foreach ($best_seller_data as $product) 
            { 
              if($product['best_seller']==1){
              $n+=1;  
              if($n>8) break;
        ?>

        <div class="col-sm-3 py-3 m-auto cat_prdct_view">
          <div class="prdct-box border rounded-3 pt-3 position-relative" style="height: 400px;">
            <a href="<?php echo SITE_PATH ?>product/<?php echo $product['id'] ?>" target="_blank" class="product-link">
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
        <?php } } ?>
      </div>
    </div>

<!-- Products Responsive View Section -->
<div class="category_resp">
  <?php if($best_seller_data != '') { ?>
  
  <div class="product-row-heading mt-4 border-bottom d-flex">
        <div class="product-row-heading-title ">
          <span class="fs-5 fw-bold text-uppercase">Best Sellers</span>
        </div>
        <div class="ms-auto pb-3 me-3"> 
          <a class="btn view_all_btn" href="<?php echo SITE_PATH ?>all_product/best_seller">VIEW MORE</a> 
        </div>
  </div>

  <table class="table table-bordered">
    <tr>
    <?php $i=0; foreach ($best_seller_data as $product) { if($product['best_seller']==1){ $i+=1;?>
      <td class="w-50" onclick="location.href='<?php echo SITE_PATH ?>product/<?php echo $product['id'] ?>'" style="cursor:pointer; background: #fff;">
        
        <div class="row"><img src=" <?php echo PRODUCT_IMAGE_SITE_PATH.$product['image'];?> " class="p-4" style="max-height:225px;width: 100%;object-fit: contain;"alt="Avatar"></div>

        <div style="vertical-align: bottom; display: table-cell">
          <div class="ps-3"><?php echo $product['short_name'] ?></div>
          <div class="ps-3">
            <?php 
              echo "<span class='p-dark'><i class='fa fa-inr'></i>".$product['price']."</span>";
            ?>
          </div>
        </div>
      </td>
    <?php if(($i%2)==0) echo "</tr><tr>"; } } ?>
    </tr>
  </table>
  <?php } ?>
</div>


<!-- Products Full View Section -->
    <div class="container mt-5">
      <div class="product-row-heading border-bottom d-flex">
        <div class="product-row-heading-title ">
          <span class="fs-5 fw-bold text-uppercase">More Products</span>
        </div>

        <div class="ms-auto pb-3"> 
          <a class="btn view_all_btn" href="<?php echo SITE_PATH ?>all_product/new_arrivals">VIEW MORE</a> 
        </div>
      </div>
      <div class="row" style="width: fit-content; margin:auto;" id="more_products"></div>
     <div id="load_data_message" class="d-none m-auto my-5" style="width: fit-content;"><img src="<?php echo SITE_PATH ?>assets/images/30.gif"></div>
    </div>



<!-- Footer Section -->

<?php
require('prerequisite/footer.php');
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script src="<?php echo SITE_PATH; ?>assets/js/custom.js"></script>
<script>

$(document).ready(function(){
 
 var limit =8;
 var start = 0;
 var action = 'inactive';
 function load_country_data(limit, start)
 {
  $.ajax({
   url:"fetch.php",
   method:"POST",
   data:{limit:limit, start:start},
   cache:false,
   success:function(data)
   {
    $('#more_products').append(data);
    if(data == '')
    {
     $('#load_data_message').addClass("d-none");
     action = 'active';
    }
    else
    {
     $('#load_data_message').removeClass("d-none");
     action = "inactive";
    }
   }
  });
 }

 if(action == 'inactive')
 {
  action = 'active';
  load_country_data(limit, start);
 }
 $(window).scroll(function(){
  if($(window).scrollTop() + $(window).height() > $("#more_products").height() && action == 'inactive')
  {
   action = 'active';
   start = start + limit;
   setTimeout(function(){
    load_country_data(limit, start);
   }, 1000);
  }
 });
 
});
</script>

<script type="text/javascript">
    //banner slider
  $(".bannerSlider").slick({
      dots: false
      , autoplay: true
      , infinite: true
      , dots: false
      , slidesToShow: 1
      , slideswToScroll: 1
      , arrows: false
  });
</script>
</body>
</html>

