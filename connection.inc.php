<?php

$conn=mysqli_connect("localhost","root","","electrozon");

function conn(){
	$conn=mysqli_connect("localhost","root","","electrozon");
	if($conn){
		return $conn;
	}
}

define('MAINMENU_CATEGORY_LIMIT',6);
define('SERVER_PATH',$_SERVER['DOCUMENT_ROOT'].'/');
define('SITE_PATH','http://localhost/electrozon/');
define('EMAIL_VERIFICATION', '604fb25b275fd396d4079facd1daded964e9e63dba4b1fb003f04fa3ad59f68f9e185c547cf58616ea83f22f251c0223b541');
define('PRODUCT_IMAGE_SERVER_PATH',SERVER_PATH.'media/products/');
define('PRODUCT_IMAGE_SITE_PATH',SITE_PATH.'media/products/');
?>