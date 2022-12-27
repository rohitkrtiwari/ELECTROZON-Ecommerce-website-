<?php
$conn=mysqli_connect("localhost","root","","electrozon");
define('SERVER_PATH',$_SERVER['DOCUMENT_ROOT'].'/electrozon/');
define('SITE_PATH','http://localhost/electrozon/');
define('SITE_ADMIN_PATH','http://localhost/electrozon/ab_admin-lg/');

define('PRODUCT_IMAGE_SERVER_PATH',SERVER_PATH.'media/products/');
define('PRODUCT_IMAGE_SITE_PATH',SITE_PATH.'media/products/');
?>
