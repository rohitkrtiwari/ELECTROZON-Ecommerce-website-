<?php 
session_start();
require('connection.inc.php');
require('functions.inc.php');

function cartCount($conn,$username){
	$sql = "SELECT * from cart where username = '$username'";
	$res = mysqli_query($conn,$sql);
	return mysqli_num_rows($res);
}

function updateCart($conn, $username, $pid, $qty){
	$sql = "UPDATE cart SET qty='$qty' WHERE username = '$username' and pid = '$pid'";
	if(mysqli_query($conn,$sql)){
		echo $sql;
	}else{
   	return false;
	}
}

function addCart($conn,$loggedin, $username, $pid, $qty){
   $sql = "SELECT username, pid FROM cart WHERE username = '$username' and pid = '$pid'";
   $res = mysqli_query($conn,$sql);
   if(mysqli_num_rows($res)>0){
      return false;
   }else{
      if($loggedin){
         $sql = "INSERT INTO cart (pid, username, qty, verfied) VALUES ('$pid', '$username', '$qty', 1) ";
      }else{
         $sql = "INSERT INTO cart (pid, username, qty, verfied) VALUES ('$pid', '$username', '$qty', 0) ";
      }
      echo $sql;
      if(mysqli_query($conn,$sql)){
         return true;
      }else{
         return false;
      }           
   }
}

function removeCart($conn, $username, $pid){
   $sql = "DELETE FROM cart WHERE username = '$username' and pid = '$pid'";
   if(mysqli_query($conn,$sql)){
      return true;
   }else{
      return false;
   }
}

function emptyCart($conn, $username){
   $sql = "DELETE FROM cart WHERE username = '$username'";
   if(mysqli_query($conn,$sql)){
      return true;
   }else{
      return false;
   }
}

function pid_av($conn, $pid, $qty){
   if($qty>0){   
      $sql = "SELECT * from product where id = '$pid' and qty >= '$qty'";
      if(mysqli_num_rows(mysqli_query($conn, $sql))){
         return true;
      }else{
         return false;
      }
   }else
      return false;
}

if(isset($_POST['type'])){
      $user_id = get_user($conn)[0]; $loggedin = get_user($conn)[1];
   	$type=get_safe_value($conn,$_POST['type']);
   	if($type=='cartCount'){
   		$username=$user_id;
   		echo cartCount($conn,$username);
   	}
   	if($type=='update'){
   		$username=$user_id;
         if((filter_var($_POST['pid'], FILTER_VALIDATE_INT)) && (filter_var($_POST['qty'], FILTER_VALIDATE_INT)))
         {         
      		$pid=get_safe_value($conn,$_POST['pid']);
      		$qty=get_safe_value($conn,$_POST['qty']);
            if(pid_av($conn, $pid, $qty))
            {         
         		if(updateCart($conn, $username, $pid, $qty)){
         			return true;
         		}else{
         			return false;
         		}
            }else
               return false;
         }else
            return false;
   	}
      
      if($type=='add'){
         $username=$user_id;
         if((filter_var($_POST['pid'], FILTER_VALIDATE_INT)) && (filter_var($_POST['qty'], FILTER_VALIDATE_INT)))
         {
            $pid=get_safe_value($conn,$_POST['pid']);
            $qty=get_safe_value($conn,$_POST['qty']);
            if(pid_av($conn, $pid, $qty))
            {
               if(addCart($conn, $loggedin, $username, $pid, $qty)){
                  return true;
               }else{
                  return false;
               }
            }else
               return false;
         }else
            return false;
      }

      if($type=='remove'){
         $username=$user_id;
         if(filter_var($_POST['pid'], FILTER_VALIDATE_INT))
         {
            $pid=get_safe_value($conn,$_POST['pid']);
            if(removeCart($conn, $username, $pid)){
               return true;
            }else{
               return false;
            }
         }return false;
      }

      if($type=='empty'){
         $username=$user_id;
         if(emptyCart($conn, $user_id)){
            return true;
         }else{
            return false;
         }
      }
}


?>
