<?php 
require("prerequisite/responsive_header.php");
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

<!-- Top Row -->
<nav id="top">
  <div class="top-row px-5">

    <div class="top-links top-right">
      <ul>
        <li>
          <i class="fa fa-phone"></i>
          <a href="#" class="top_nav_contact">+91-8076643316</a>
        </li>
        <li>|</li>
        <li>
          <i class="fa fa-envelope-o"></i>
          <a href="#" class="top_nav_contact">care@electrozon.com</a>
        </li>
      </ul>
    </div>

    <div class="top-links top-left">
      <ul class="top-left-ul">
        <li>
          <i class="fa fa-user-o"></i>
          <div class="dropdown d-inline">
            <button class="btn dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php $userArr = userProfileData($conn, $_SESSION['user_id']); echo "Hello <span class='text-capitalize fw-bold'>".$userArr[0]['fname']." ".$userArr[0]['lname']."</span>";?> 
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="<?php echo SITE_PATH ?>my_account">My Account</a>
              <a class="dropdown-item" href="<?php echo SITE_PATH ?>my_order">Orders History</a>
              <a class="dropdown-item" href="<?php echo SITE_PATH ?>address_manager">Address Book</a>
            </div>
          </div>
        </li>
        <li>|</li>
        <li>
          <i class="fa fa-sign-out"></i>
          <a href="<?php echo SITE_PATH ?>logout">Logout</a>
        </li>
        <li>|</li>
        <li>
          <i class="fa fa-credit-card"></i>
          <a href="<?php echo SITE_PATH ?>checkout">Checkout</a>
        </li>
      </ul>

      <div class="dropdown d-none" id="top-left-resp">
        <button class="btn dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    	 <?php $userArr = userProfileData($conn, $_SESSION['user_id']); echo "Hello <span class='text-capitalize fw-bold'>".$userArr[0]['fname']." ".$userArr[0]['lname']."</span>";?> 
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
          <a class="dropdown-item" href="<?php echo SITE_PATH ?>my_account">My Account</a>
          <a class="dropdown-item" href="<?php echo SITE_PATH ?>my_order">Order History</a>
          <a class="dropdown-item" href="<?php echo SITE_PATH ?>checkout">Chekout</a>
          <a class="dropdown-item" href="<?php echo SITE_PATH ?>address_manager">Address Book</a>
          <a class="dropdown-item" href="<?php echo SITE_PATH ?>logout">Logout</a>
        </div>
      </div>

    </div>
  </div>
</nav>

<!-- Navigation -->

<section class="header">
  <div class="nav-row">
    <div class="nav-left"><a href="<?php echo SITE_PATH ?>">
        <img src="<?php echo SITE_PATH ?>assets/images/logo.png"></a>
    </div>
    <div class="nav-middle">
      <div class="search-bar">
        <form action="<?php echo SITE_PATH; ?>search.php" method="get">
          <input type="text" name="search" placeholder="search" id="search">
          <span class="input-group-btn">
            <button type="submit" name="submit" class="btn btn-default btn-lg"><i class="fa fa-search"></i></button>
          </span>
        </form>
      </div>
    </div>
    <div class="nav-right">

      <div class="wishlist">
        <a href="#" class="link">
          <i class="fa fa-heart-o "></i>
          <b class="cart_count" id="wishlist_count">0</b>Wishlist
        </a>
      </div>

      <?php 
      $cart = getCartPID($conn,$_SESSION['user_id']);
      ?>

      <div class="cart" >
        <a href="<?php echo SITE_PATH; ?>cart"  class="link">
          <i class="fa fa-shopping-cart"></i>
          <b class="cart_count" id="cart_count"><?php echo count($cart); ?></b>Cart
        </a>
      </div>
    
    </div>
  </div>
</section>
