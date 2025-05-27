<?php 
$request=$_SERVER['REQUEST_URI'];
$router = str_replace('/ab_admin-lg','',$request);

if($router=='/' or $router=='/index' or $router=='/home' or $router=='/index.php')
{
	include('home.php');
}

elseif($router == '/categories')
{
	include('categories.php');
}

elseif($router == '/sub_categories')
{
	include('sub_categories.php');
}

elseif($router == '/orders')
{
	include('orders.php');
}

elseif($router == '/products')
{
	include('products.php');
}

elseif($router == '/customers')
{
	include('customers.php');
}

elseif($router == '/manage_address')
{
	include('manage_address.php');
}

elseif($router == '/manage_sub-categories')
{
	include('manage_sub-categories.php');
}

elseif($router == '/manage_products')
{
	include('manage_products.php');
}

elseif($router == '/order_details' || preg_match("/order_details\/[0-9]/i", $router))
{
	$arr=explode('/', $router);
	if(isset($arr[2])){
		$_GET['id']=$arr[2];
	}
	include('order_details.php');
}

elseif($router == '/contact_us')
{
	include('contact_us.php');
}


elseif($router == '/logout')
{
	include('logout.php');
}


elseif($router == '/login')
{
	include('login.php');
}

elseif($router == '/email_verify')
{
	include('email_verify.php');
}

else{
	include('not-found.php');
}

?>

