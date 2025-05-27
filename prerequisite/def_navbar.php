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
          <a href="#" class="top_nav_contact"><?php echo CONTACT_NUMBER ?></a>
        </li>
        <li>|</li>
        <li>
          <i class="fa fa-envelope-o"></i>
          <a href="#" class="top_nav_contact"><?php echo EMAIL ?></a>
        </li>
      </ul>
    </div>
    <div class="top-links top-left">
      <ul>
        <li>
          <i class="fa fa-user-o"></i>
          <a href="<?php echo SITE_PATH ?>register">Register</a>
        </li>
        <li>|</li>
        <li>
          <i class="fa fa-sign-in"></i>
          <a href="<?php echo SITE_PATH ?>login">Login</a>
        </li>
        <li>|</li>
        <li>
          <i class="fa fa-credit-card"></i>
          <a href="<?php echo SITE_PATH ?>checkout">Checkout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Navigation -->

<section class="header">
  <div class="nav-row">
    <div class="nav-left">
      <center><a style="text-decoration: none" href="<?php echo SITE_PATH ?>"><img src="<?php echo SITE_PATH ?>assets/images/logo.png" style="height: 56px;"></a></center>
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
          <a class="link btn rounded-0 fw-bold p-0 pt-2 me-2" style="font-size: 17px;" href="<?php echo SITE_PATH ?>login"><i class="fa fa-user-circle-o text-dark" ></i> <span style="vertical-align: text-bottom;" >Login</span></a>
        </a>
      </div>
      <?php 
      $cart = getCartPID($conn,$_SESSION['user_id']);
      ?>
      <div class="cart fs-5 py-1">
        <a href="<?php echo SITE_PATH ?>cart"  class="link">
          <i class="fa fa-shopping-cart"></i>
          <b class="cart_count" id="cart_count"><?php echo count($cart); ?></b><b>Cart</b>
        </a>
      </div>
    </div>
  </div>
</section>

