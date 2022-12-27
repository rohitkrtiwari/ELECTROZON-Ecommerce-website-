<?php
session_start();
require('connection.inc.php');
require('functions.inc.php');

if(isset($_GET['id']) && $_GET['id']!=''){
	$user_id = get_user($conn)[0]; $loggedin = get_user($conn)[1];
	$id=get_safe_value($conn,$_GET['id']);
	$product_data=mysqli_query($conn,"select * from product where id='$id'");
}else{
	header('location:'.SITE_PATH.'');
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="HandheldFriendly" content="true">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo SITE_PATH ?>assets/css/theme.css" rel="stylesheet">
	<link href="<?php echo SITE_PATH ?>assets/css/style.css" rel="stylesheet">
	<link href="<?php echo SITE_PATH ?>assets/css/preloader.css" rel="stylesheet">
	<link href="<?php echo SITE_PATH ?>assets/css/header.css" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="<?php echo SITE_PATH; ?>assets/css/jquery.exzoom.css" rel="stylesheet" type="text/css"/>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Electrozon Product</title>
</head>
<body>
	
<!-- wpf loader Two -->
<div id="wpf-loader-two">          
  <div class="wpf-loader-two-inner">
    <span>Loading</span>
  </div>
</div> 

	<?php
	if($loggedin==true){
	  require('prerequisite/login_navbar.php');
	}else {
	  require('prerequisite/def_navbar.php');
	}
	require('prerequisite/main-menu.php');
	?>


	<!-- Product Section -->
	<section class="grid-view pb-3" id="product_resp_view">
	    <div id="alert-msg" style="background-color: #3d1a54;"></div>

		<div class="main-prdct">
	        <?php 
	        while($row=mysqli_fetch_assoc($product_data)) {
	        	$shipping_charge = shipping_charge($row['price']);
	        ?>
				<div class="prdct-left-section p-5 m-3">

					<div class="exzoom hidden" id="exzoom">
				        <div class="exzoom_img_box">
				            <ul class='exzoom_img_ul'>
				                <li><img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$row['image'];?>" style="width: 100%;"></li>
				            </ul>
				        </div>
				    </div>

				    <div class="d-none prdct-image" >
		                <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$row['image'];?>" style="width: 100%;">
				    </div>

				</div>
				<div class="prdct-right-section">
					<p class="prdct-name w-75"><?php echo $row['name']; ?></p>
					<span>Product code: EC-4902</span><br>
					<?php if($row['qty']>0) echo "<h4 style='color:green;'>Available in stock</h4>"; else echo "<h4 style='color:red;'>Out of Stock</h4>"; ?></span>
					<p class="prdct-price"><i class="fa fa-inr"></i> <?php echo $row['price'] ?> <span class="p-sml">(inc. All Taxes)</span></p>
					<?php if($shipping_charge!=0){ ?><span class="p-dark"><i class="fa fa-truck"></i> Shipping Charges:   <i class="fa fa-inr"></i><?php echo $shipping_charge ?></span><br><span class="p-dark text-danger">Free Delivery On orders over <i class="fa fa-inr"></i>1000</span><?php } else{ ?>
						<span class="p-dark text-danger">Free Delivery</span>
					<?php } ?>
					 	<div class="col-3"> 
				        <label class="form-label">Quantity</label>
				          <select id="quantity" class="form-select form-select-sm mb-3" aria-label=".form-select-lg example">
				            <?php for($n=1; $n<=($row['qty']*10/10); $n++ ){ ?>
				              <option value="<?php echo $n; ?>"><?php echo $n; ?></option>
				            <?php } ?>
				          </select>
				        </div>

					  	<div class="row">
						    <div class="col-auto">
								<a class="prdct-btn prdct-add-btn" onclick="addCart('<?php echo $user_id; ?>',<?php echo $row['id'] ?>,document.getElementById('quantity').value)">
									<i class="fa fa-shopping-cart"></i> Add to Cart
								</a>
						    </div>
						    <div class="col-auto float-left">
						    	<a onclick="addCart('<?php echo $user_id; ?>',<?php echo $row['id'] ?>,document.getElementById('quantity').value,'<?php echo SITE_PATH ?>cart')" class="prdct-btn prdct-buy-btn"><i class="fa fa-shopping-basket"></i> Buy Now</a>
						    </div>
					    </div>

					<div class="row mt-3">
						<div class="col-sm-auto fw-light"><b>Delivery:</b></div>
						<div class="col-sm-auto p-dark">Between 5 to 10 Buisness Days</div>
					</div>


					<div class="row prdct-details">
						<div class="col-sm-auto"><b>Discription:</b></div>
						<div class="col-sm-auto w-75">
							<?php 
								echo $row['description'];
							?>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</section>



<!-- Best Sellers -->
<!-- Products Full View Section -->
  <section class="category_full_view  d-flex">

    <div class="grid-view px-2">
      <div class="product-row-heading border-bottom d-flex">
        <div class="product-row-heading-title ">
          <span class="fs-5 fw-bold " >You might be interested in</span>
        </div>

        <div class="ms-auto pb-3"> 
          <a class="btn view_all_btn" href="<?php echo SITE_PATH ?>all_product/you_might_be_intrested_in">VIEW MORE</a> 
        </div>
      </div>
      <div id="alert-msg" style="background-color: #3d1a54;"></div>
      <div class="row">

        <?php 
		$new_arrivals_data=get_product($conn, '', '', '', '', 1);
          $n=0; 
          foreach ($new_arrivals_data as $product) 
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
                <span class="product-price"><i class="fa fa-inr"></i><?php echo $product['price'] ?> </span>
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

  <center class="p-sml p-light my-3 mb-3 resp_view d-none"><span class="fs-4"><i class="fa fa-shield" aria-hidden="true"></i> 100% Original Products</span><br> With Assured Brand Warranty</center>

  <!-- Products Responsive View Section -->
  <div class="category_resp border-top pt-3 bg-white">
    <div class="product-row-heading d-flex">
	    <div class="product-row-heading-title ">
	      <span class="fs-5 fw-bold" >Similar Products</span>
	    </div>

	    <div class="ms-auto mb-2 pe-3"> 
	      <a class="btn view_all_btn" href="<?php echo SITE_PATH ?>all_product/similar_products">View all</a>  
	    </div>
    </div>
    <table class="table table-bordered">
      <tr>
      <?php $i=0; foreach ($new_arrivals_data as $product) { if($product['best_seller']==1){ $i+=1;?>
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

</div>

<script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
<script src="<?php echo SITE_PATH; ?>assets/js/jquery.exzoom.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="<?php echo SITE_PATH; ?>assets/js/custom.js"></script>
<script type="text/javascript">
      
    $('.container').imagesLoaded( function() {
      $("#exzoom").exzoom({
            autoPlay: false,
        });
      $("#exzoom").removeClass('hidden')
    });
</script>

</body>
</html>

