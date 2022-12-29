<?php

define('SHIPPING_CHARGE_1',69);
define('SHIPPING_CHARGE_2',49);
define('SHIPPING_CHARGE_3',0);
define('SHIPPING_CHARGE_LIMIT_1',500);
define('SHIPPING_CHARGE_LIMIT_2',1000);
define('MAINMENU_CATEGORY_LIMIT',7);
define('CONTACT_NUMBER',1234567890);
define('EMAIL','electrozon926@gmail.com');


$conn=mysqli_connect("localhost","root","root","electrozon");

function conn(){
	$conn=mysqli_connect("localhost","root","root","electrozon");
	if($conn){
		return $conn;
	}
}

define('SERVER_PATH',$_SERVER['DOCUMENT_ROOT'].'/');
define('SITE_PATH','http://localhost/electrozon/');
define('EMAIL_VERIFICATION', '604fb25b275fd396d4079facd1daded964e9e63dba4b1fb003f04fa3ad59f68f9e185c547cf58616ea83f22f251c0223b541');
define('SUCCESS', '909823fdcc59e4176d64a4200a5091a2e81f4478df26fab4748030160f6e8ca8fa5f899149d6721d62dc93c87175eeb50447');
define('FAILURE', '17ea5cc422034420396ff7c6f8910d20319e27fa664c57de420322def8e50883a73f045346dd9dcda6f6dc08a453f6f6a660');
define('PRODUCT_IMAGE_SERVER_PATH',SERVER_PATH.'media/products/');
define('PRODUCT_IMAGE_SITE_PATH',SITE_PATH.'media/products/');
?>
