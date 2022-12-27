<?php 
ob_start();
require('home.php');



if(isset($_GET['id'])){
  $order_id = get_safe_value($conn, $_GET['id']);
  $ProductsArr = getOrderDetails($conn, $order_id);
}else{
  header('location:'.SITE_ADMIN_PATH.'');
}
if(isset($_POST['update_order_status'])){
  $update_order_status = get_safe_value($conn, $_POST['update_order_status']);
  mysqli_query($conn, "UPDATE `order` set order_status='$update_order_status' where id = '$order_id'");
}
ob_end_flush();
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 my-4">

        <h2 style="margin-top: 16px;">Order Details</h2>
        
      
      <div class="table-responsive">
        <table class="table table-hover table-sm">
          <!-- <caption>Click on the blue button to view orders</caption> -->
            <thead>
              <tr>
                <th scope="col">Image</th>
                <th scope="col" style="width: 650px;">Product Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
                <th scope="col">Total Price</th>
              </tr>
            </thead>
            <tbody>

              <?php
                $total_amount=0;
                foreach ($ProductsArr as $product) {
              ?>
                <tr style="vertical-align: baseline;">
                  <td>
                    <img style="max-width: 85px;" src="<?php echo PRODUCT_IMAGE_SITE_PATH.$product['image'];?> ">
                  </td>
                  <td><?php echo $product['name']; ?></td>
                  <td><?php echo $product['qty']; ?></td>
                  <td><?php echo $product['price']; ?></td>
                  <td><?php echo $total=($product['price']*$product['qty']); $total_amount+=$total; ?></td>
                </tr>
              <?php } ?>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td >Total Price</td>
                    <td ><?php echo $total_amount; ?></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td >Shipping Charges</td>
                    <td ><?php if($total_amount<500) $shipping_amount = 49; else $shipping_amount = 0; echo $shipping_amount;?></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="fw-bold">Amount Payed</td>
                    <td class="fw-bold"><?php echo (int) ($total_amount + $shipping_amount); ?></td>
                  </tr>
            </tbody>
        </table>
      </div>
      
      <div class="row">

        <div class="col">
          <?php 
            $userInfo=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM address WHERE id = (SELECT address_id FROM `order` WHERE id = '$order_id')"));
            $order_status_arr=mysqli_fetch_assoc(mysqli_query($conn,"select order_status.name from order_status,`order` where `order`.id='$order_id' and `order`.order_status=order_status.id"));
          ?>

          <h5 class="card-title"><b>Address:</b><br></h5>
            <?php echo "<b>".$userInfo['name']."</b><br>";
               echo "<p class='p-sml p-light'>".$userInfo['address']."<br>";
               echo $userInfo['post_code']."<br>";
               echo "Phone: ".$userInfo['phone_number']."<br></p>";?>

          
        </div>

        <div class="col">
          <?php 
            $paymentInfo=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM `order` WHERE id = '$order_id'"));
          ?>

          <h5 class="card-title"><b>Payment Info:</b><br></h5>
            <?php echo "<span class='p-sml fw-bold'>Payment Status : </span>".$paymentInfo['payment_status']."<br>";
               echo "<span class='p-sml fw-bold'>Payment Request Id : </span>".$paymentInfo['payment_request_id']."<br>";
               echo "<span class='p-sml fw-bold'>Payment Id : </span>".$paymentInfo['payment_id']."<br>";?>

          <h5 class="card-title pt-2"><b>Payment Status: </b><?php echo $order_status_arr['name'];?></h5>   
        </div>

      </div>
      <form method="POST" >
        <div class="d-flex">
          <h5 class="card-title mt-1"><b>Order Status: </b><?php echo $order_status_arr['name'];?></h5>   
          <select class="form-select ms-3" name="update_order_status" style="width: auto;" onchange="this.form.submit()">
            <option>Select Status </option>
            <?php
            $res=mysqli_query($conn,'select * from order_status');
            while($row=mysqli_fetch_assoc($res)){
              if($row['name'] == $order_status_arr['name']) $value = 'selected'; else $value = '';
              echo "<option ".$value." value=".$row['id'].">".$row['name']."</option>";
            }
            ?>
          </select>
        </div>
        <a href="<?php echo SITE_ADMIN_PATH."orders" ?>" name="submit" class="btn btn-secondary mt-2 me-2" style="line-height: 1.1">Back</a>
      </form>

    </main>

