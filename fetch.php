<?php
require('connection.inc.php');

if(isset($_POST["limit"], $_POST["start"]))
{
 $query = "SELECT * FROM `product` ORDER BY id DESC LIMIT ".$_POST["start"].", ".$_POST["limit"]."";
 $result = mysqli_query($conn, $query);
 while($row = mysqli_fetch_array($result))
 {
  $body='<div class="col-sm-3 py-3 m-auto cat_prdct_view">';
  $body.='<div class="prdct-box border rounded-3 pt-3 position-relative" style="height: 400px;">';
  $body.='<a href="'.SITE_PATH.'product/'.$row['id'].'" target="_blank" class="product-link">';
  $body.='<div class="product-img">';
  $body.='<img src="'.PRODUCT_IMAGE_SITE_PATH.$row['image'].'" style="height: 100%; width: 100%;object-fit: contain;"alt="Avatar">';
  $body.='</div>';
  $body.='<div class="container mt-4 text-center">';
  $body.='<span class="product-name">'.$row['short_name'].' </span><br>';
  $body.='<span class="product-price"><i class="fa fa-inr"></i>'.$row['price'].'  </span>';
  $body.='</div>';
  $body.='</a>';
  $body.='<div class="shopping-controls mt-3 position-absolute bottom-0">';
  $body.='<button class="product-button py-2" onclick="addCart(&#39rohitkrtiwari2002@gmail.com&#39,'.$row['id'].'"><i class="fa fa-shopping-cart"></i> Add to Cart</button>';
  $body.='</div></div></div>';
  echo $body;
 }
}

?>
