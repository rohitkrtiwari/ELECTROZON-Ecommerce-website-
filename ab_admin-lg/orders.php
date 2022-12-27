<?php 
ob_start();
require('home.php');

$ordersArr = getOrder($conn);

// Handle POST request
if(isset($_POST['type'])){
  $type = get_safe_value($conn, $_POST['type']);
  if($type = "update_tracking_id"){
    $tracking_id = get_safe_value($conn, $_POST['tracking_id']);
    $order_id = get_safe_value($conn, $_POST['order_id']);
    $sql = "UPDATE `order` set tracking_id = '$tracking_id' where id = '$order_id'";
    mysqli_query($conn, $sql);
  }
}

ob_end_flush();
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 my-4">

      <div id="alert-msg" style="background-color: #3d1a54;"></div>
      <h2 style="margin-top: 16px;">Order Master</h2>
      <div class="row">

        <div class="col-sm-2">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="order_status_selector" id="order_status" value="0"checked>
            <label class="form-check-label p-light" for="flexRadioDefault2">
              All
            </label>
          </div>
        </div>

        <div class="col-sm-2">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="order_status_selector" id="order_status" value="1">
            <label class="form-check-label p-light" for="flexRadioDefault2">
              Pending
            </label>
          </div>
        </div>

        <div class="col-sm-2">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="order_status_selector" id="order_status" value="2" >
            <label class="form-check-label p-light" for="flexRadioDefault2">
              Processing
            </label>
          </div>
        </div>

        <div class="col-sm-2">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="order_status_selector" id="order_status" value="3" >
            <label class="form-check-label p-light" for="flexRadioDefault2">
              Shipped
            </label>
          </div>
        </div>

        <div class="col-sm-2">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="order_status_selector" id="order_status" value="4" >
            <label class="form-check-label p-light" for="flexRadioDefault2">
              Complete
            </label>
          </div>
        </div>

        <div class="col-sm-2">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="order_status_selector" id="order_status" value="5" >
            <label class="form-check-label p-light" for="flexRadioDefault2">
              Cancelled
            </label>
          </div>
        </div>
      </div>

      <div class="table-responsive toHide" id="add-0" >
        <table class="table table-hover caption-top table_scroll_x" style="margin:25px 0;">
          <caption>Click on the blue button to view orders</caption>
          <thead>
            <tr>
              <th scope="col">Order ID</th>
              <th scope="col" style="width: 300px;">Address</th>
              <th scope="col">Order Date</th>
              <th scope="col">Payment Type</th>
              <th scope="col">Payment Status</th>
              <th scope="col">Order Status</th>
              <th scope="col">Tracking ID</th>
            </tr>
          </thead>
          <tbody>

            <?php
              foreach ($ordersArr as $order) { 
                $address=getAddress($conn, $order['address_id']);
            ?>
              <tr style="vertical-align: baseline;">
              <td><center><a class="btn btn-dark" href="order_details/<?php echo $order['id']; ?>" style="line-height: 1.1;width: 100%;background: #215c90;"><?php echo $order['id']; ?></a></center></td>
                <td><?php print_r($address[0]['address']."<br>".$address[0]['post_code']); ?></td>
                <td><?php echo $order['added_on']; ?></td>
                <td><?php echo $order['PAYMENTMODE']; ?></td>
                <td><?php echo $order['payment_status']; ?></td>
                <td><?php echo $order['order_status_str']; ?></td>
                <td><input type="text" name="<?php echo $order['id']; ?>" id="tracking_id" value="<?php echo $order['tracking_id']; ?>"><button class="tracking_id_update_btn" id="tracking_id_btn"><i class="fa fa-refresh" aria-hidden="true"></i></button></td>
              </tr>
            <?php } ?>

          </tbody>
        </table>
      </div>

      <div class="table-responsive toHide" id="add-1" style="display: none;">
        <table class="table table-hover caption-top table_scroll_x" style="margin:25px 0;">
          <caption>Click on the blue button to view orders</caption>
          <thead>
            <tr>
              <th scope="col">Order ID</th>
              <th scope="col" style="width: 400px;">Address</th>
              <th scope="col">Order Date</th>
              <th scope="col">Payment Type</th>
              <th scope="col">Payment Status</th>
              <th scope="col">Order Status</th>
            </tr>
          </thead>
          <tbody>

            <?php
              foreach ($ordersArr as $order) { 
                $address=getAddress($conn, $order['address_id']);
                if($order['order_status_str']=="pending"){
            ?>
              <tr style="vertical-align: baseline;">
              <td><center><a class="btn btn-dark" href="order_details/<?php echo $order['id']; ?>" style="line-height: 1.1;width: 100%;background: #215c90;"><?php echo $order['id']; ?></a></center></td>
                <td><?php print_r($address[0]['address']."<br>".$address[0]['post_code']); ?></td>
                <td><?php echo $order['added_on']; ?></td>
                <td><?php echo $order['PAYMENTMODE']; ?></td>
                <td><?php echo $order['payment_status']; ?></td>
                <td><?php echo $order['order_status_str']; ?></td>
              </tr>
            <?php } } ?>

          </tbody>
        </table>
      </div>

      <div class="table-responsive toHide" id="add-2" style="display: none;">
        <table class="table table-hover caption-top table_scroll_x" style="margin:25px 0;">
          <caption>Click on the blue button to view orders</caption>
          <thead>
            <tr>
              <th scope="col">Order ID</th>
              <th scope="col" style="width: 400px;">Address</th>
              <th scope="col">Order Date</th>
              <th scope="col">Payment Type</th>
              <th scope="col">Payment Status</th>
              <th scope="col">Order Status</th>
            </tr>
          </thead>
          <tbody>

            <?php
              foreach ($ordersArr as $order) { 
                $address=getAddress($conn, $order['address_id']);
                if($order['order_status_str']=="processing"){
            ?>
              <tr style="vertical-align: baseline;">
              <td><center><a class="btn btn-dark" href="order_details/<?php echo $order['id']; ?>"  style="line-height: 1.1;width: 100%;background: #215c90;"><?php echo $order['id']; ?></a></center></td>
                <td><?php print_r($address[0]['address']."<br>".$address[0]['post_code']); ?></td>
                <td><?php echo $order['added_on']; ?></td>
                <td><?php echo $order['PAYMENTMODE']; ?></td>
                <td><?php echo $order['payment_status']; ?></td>
                <td><?php echo $order['order_status_str']; ?></td>
              </tr>
            <?php } } ?>

          </tbody>
        </table>
      </div>

      <div class="table-responsive toHide" id="add-3" style="display: none;">
        <table class="table table-hover caption-top table_scroll_x" style="margin:25px 0;">
          <caption>Click on the blue button to view orders</caption>
          <thead>
            <tr>
              <th scope="col">Order ID</th>
              <th scope="col" style="width: 400px;">Address</th>
              <th scope="col">Order Date</th>
              <th scope="col">Payment Type</th>
              <th scope="col">Payment Status</th>
              <th scope="col">Order Status</th>
            </tr>
          </thead>
          <tbody>

            <?php
              foreach ($ordersArr as $order) { 
                $address=getAddress($conn, $order['address_id']);
                if($order['order_status_str']=="shipped"){
            ?>
              <tr style="vertical-align: baseline;">
              <td><center><a class="btn btn-dark" href="order_details/<?php echo $order['id']; ?>"  style="line-height: 1.1;width: 100%;background: #215c90;"><?php echo $order['id']; ?></a></center></td>
                <td><?php print_r($address[0]['address']."<br>".$address[0]['post_code']); ?></td>
                <td><?php echo $order['added_on']; ?></td>
                <td><?php echo $order['PAYMENTMODE']; ?></td>
                <td><?php echo $order['payment_status']; ?></td>
                <td><?php echo $order['order_status_str']; ?></td>
              </tr>
            <?php } } ?>

          </tbody>
        </table>
      </div>

      <div class="table-responsive toHide" id="add-4" style="display: none;">
        <table class="table table-hover caption-top table_scroll_x" style="margin:25px 0;">
          <caption>Click on the blue button to view orders</caption>
          <thead>
            <tr>
              <th scope="col">Order ID</th>
              <th scope="col" style="width: 400px;">Address</th>
              <th scope="col">Order Date</th>
              <th scope="col">Payment Type</th>
              <th scope="col">Payment Status</th>
              <th scope="col">Order Status</th>
            </tr>
          </thead>
          <tbody>

            <?php
              foreach ($ordersArr as $order) { 
                $address=getAddress($conn, $order['address_id']);
                if($order['order_status_str']=="complete"){
            ?>
              <tr style="vertical-align: baseline;">
              <td><center><a class="btn btn-dark" href="order_details/<?php echo $order['id']; ?>" style="line-height: 1.1;width: 100%;background: #215c90;"><?php echo $order['id']; ?></a></center></td>
                <td><?php print_r($address[0]['address']."<br>".$address[0]['post_code']); ?></td>
                <td><?php echo $order['added_on']; ?></td>
                <td><?php echo $order['PAYMENTMODE']; ?></td>
                <td><?php echo $order['payment_status']; ?></td>
                <td><?php echo $order['order_status_str']; ?></td>
              </tr>
            <?php } } ?>

          </tbody>
        </table>
      </div>

      <div class="table-responsive toHide" id="add-5" style="display: none;">
        <table class="table table-hover caption-top table_scroll_x" style="margin:25px 0;">
          <caption>Click on the blue button to view orders</caption>
          <thead>
            <tr>
              <th scope="col">Order ID</th>
              <th scope="col" style="width: 400px;">Address</th>
              <th scope="col">Order Date</th>
              <th scope="col">Payment Type</th>
              <th scope="col">Payment Status</th>
              <th scope="col">Order Status</th>
            </tr>
          </thead>
          <tbody>

            <?php
              foreach ($ordersArr as $order) { 
                $address=getAddress($conn, $order['address_id']);
                if($order['order_status_str']=="cancelled"){
            ?>
              <tr style="vertical-align: baseline;">
              <td><center><a class="btn btn-dark" href="order_details/<?php echo $order['id']; ?>"  style="line-height: 1.1;width: 100%;background: #215c90;"><?php echo $order['id']; ?></a></center></td>
                <td><?php print_r($address[0]['address']."<br>".$address[0]['post_code']); ?></td>
                <td><?php echo $order['added_on']; ?></td>
                <td><?php echo $order['PAYMENTMODE']; ?></td>
                <td><?php echo $order['payment_status']; ?></td>
                <td><?php echo $order['order_status_str']; ?></td>
              </tr>
            <?php } } ?>

          </tbody>
        </table>
      </div>
    </main>


<script type="text/javascript">
  $(document).ready(function(){
  $("#search").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#orders tbody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
  $("[name=order_status_selector]").click(function(){
    $('.toHide').hide();
    $("#add-"+$(this).val()).show();
  });
});
</script>