<?php
ob_start();
require('home.php');


if(isset($_GET['type']) && $_GET['type']!=''){
  $type=get_safe_value($conn,$_GET['type']);
  if($type=='delete'){
    $id=get_safe_value($conn,$_GET['id']);
    $delete_sql="delete from contact_us where id='$id'";
    mysqli_query($conn,$delete_sql);
  }
}
$sql="select * from contact_us order by id desc"; 
$res = mysqli_query($conn,$sql);
ob_end_flush();
?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 my-4">
<link rel="stylesheet" type="text/css" href="assets/css/categories.css">
      <h2 style="margin-top: 16px;">Contact Us</h2>
      <div class="table-responsive">
        <table class="table table-striped table-sm" id="contact_us">
          <thead>
            <tr>
              <th>#</th>
              <th>User ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Mobile</th>
              <th>Query</th>
              <th>Date</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php 
              $i=0;
              while($row=mysqli_fetch_assoc($res)) { $i=$i+1;
            ?>
              <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['mobile']; ?></td>
                <td><?php echo $row['query']; ?></td>
                <td><?php echo $row['added_on']; ?></td>
                <td>
                  <div class="op-link">
                    <span class="badge-red"><a class="confirm" href="<?php echo SITE_ADMIN_PATH ?>contact_us.php?type=delete&id=<?php echo $row['id']?>">Delete</a></span>
                  </div>
                </td>
              <?php } ?>
            </tr>
          </tbody>
        </table>
      </div>
    </main>

<script type="text/javascript">
  $(document).ready(function(){
  $("#search").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#contact_us tbody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
