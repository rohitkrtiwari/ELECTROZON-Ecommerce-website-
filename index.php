<?php 
$request=$_SERVER['REQUEST_URI'];
$router = str_replace('/electrozon','',$request);

if($router=='/' or $router=='/index' or $router=='/home' or $router=='/index.php')
{
	include('home.php');
}

elseif($router == '/categories' || preg_match("/categories\/[0-9]/i", $router))
{
	$arr=explode('/', $router);
	if(isset($arr[2])){
		$_GET['catid']=$arr[2];
	}
	include('categories.php');
}

elseif($router == '/product' || preg_match("/product\/[0-9]/i", $router))
{
	$arr=explode('/', $router);
	if(isset($arr[2])){
		$_GET['id']=$arr[2];
	}
	include('product.php');
}

elseif($router == '/cart')
{
	include('cart.php');
}

elseif($router == '/checkout')
{
	include('checkout.php');
}

elseif($router == '/all_product' || preg_match("/all_product\/[a-z]/i", $router))
{
	$arr=explode('/', $router);
	if(isset($arr[2])){
		$_GET['cat']=$arr[2];
	}
	include('all_product.php');
}

elseif($router == '/contact_us')
{
	include('contact_us.php');
}

elseif($router == '/my_account' || preg_match("/my_account\/[a-z]/i", $router))
{
	$arr=explode('/', $router);
	if(isset($arr[2])){
		$_GET['route']=$arr[2];
	}
	include('my_account.php');
}

elseif($router == '/address_manager')
{
	include('address_manager.php');
}

elseif($router == '/my_order')
{
	include('my_order.php');
}

elseif($router == '/my_order_details' || preg_match("/my_order_details\/[0-9]/i", $router))
{
	$arr=explode('/', $router);
	if(isset($arr[2])){
		$_GET['id']=$arr[2];
	}
	include('my_order_details.php');
}

elseif($router == '/logout')
{
	include('logout.php');
}

elseif($router == '/register')
{
	include('register.php');
}

elseif($router == '/login')
{
	include('login.php');
}

elseif($router == '/create_new_password')
{
	include('create_new_password.php');
}

elseif($router == '/forgot_password' || preg_match("/forgot_password\/[a-z]/i", $router))
{
	$arr=explode('/', $router);
	if(isset($arr[2])){
		$_GET['_forgot_route']=$arr[2];
	}
	include('forgot_password.php');
}

elseif($router == '/errors/not-found')
{
	include('errors/not-found.php');
}

elseif($router == '/errors/bad-request')
{
	include('errors/bad-request.php');
}

elseif($router == '/errors/forbid')
{
	include('errors/forbid.php');
}

elseif($router == '/errors/server-err')
{
	include('errors/server-err.php');
}

else
{
	include('errors/not-found.php');
}
?>
