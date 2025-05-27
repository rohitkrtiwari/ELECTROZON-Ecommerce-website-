<?php
$cat_sql = 'SELECT * from categories where status=1';
$cat_res=mysqli_query($conn, $cat_sql);
while ($cat_row=mysqli_fetch_assoc($cat_res)){
  $cat_data[]=$cat_row;
}
?>

<style type="text/css">
  .sticky{
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 99;
    left: 0;
    transition: 0.1s;
  }
</style>
<style type="text/css">

/* side bar css start */

.new_sidebar {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 999;
  top: 0;
  left: 0;
  background-color: #fff;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
}

.new_sidebar a:not(#heading) {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 17px;
  color: black;
  display: block;
  transition: 0.3s;
}

.new_sidebar a:hover {
  color: #fff !important;
}

.new_sidebar .closebtn {
  position: absolute;
  top: -5px;
  right: 15px;
  font-size: 36px;
  margin-left: 50px;
}

.new_openbtn {
  font-size: 20px;
  cursor: pointer;
  background-color: #362059;
  color: white;
  padding: 10px 15px;
  border: none;
}

.sidenav_user_id{
    background: #362059;
    padding-top: 11px;
    position: absolute;
    padding-left: 20px;
    font-size: 19px;
    color: white;
    top: 0;
    width: inherit;
}

#new_main {
  transition: margin-left .5s;
  padding: 6px;
  position: sticky;
  top: 0;
  z-index: 9;
  width: 100%;
  background: white;
  height: 150px;
}

.new_down_menu{
    position: absolute;
    top: 75px;
    left: 16px;
}

/* On smaller screens, where height is less than 450px, change the style of the sidenav (less padding and a smaller font size) */
@media screen and (max-height: 450px) {
  .new_sidebar {padding-top: 0px;}
  .new_sidebar a {font-size: 18px;}
}

/* side bar css end*/






#button {
  display: inline-block;
  background-color: #FF9800;
  width: 50px;
  height: 50px;
  text-align: center;
  border-radius: 4px;
  position: fixed;
  color: #FF9800;
  bottom: 30px;
  right: 30px;
  transition: background-color .3s, 
    opacity .5s, visibility .5s;
  opacity: 0;
  visibility: hidden;
  z-index: 1000;
}
#button::after {
  content: "\f077";
  font-family: FontAwesome;
  font-weight: normal;
  font-style: normal;
  font-size: 2em;
  line-height: 50px;
  color: #fff;
}
#button:hover {
  cursor: pointer;
  background-color: #333;
  color: #333;
}
#button:active {
  background-color: #555;
  color: #555;
}
#button.show {
  opacity: 1;
  visibility: visible;
}

/* Styles for the content section */

.content {
  width: 77%;
  margin: 50px auto;
  font-family: 'Merriweather', serif;
  font-size: 17px;
  color: #6c767a;
  line-height: 1.9;
}
@media (min-width: 500px) {
  .content {
    width: 43%;
  }
  #button {
    margin: 30px;
  }
}
.content h1 {
  margin-bottom: -10px;
  color: #03a9f4;
  line-height: 1.5;
}
.content h3 {
  font-style: italic;
  color: #96a2a7;
}

</style>
<script type="text/javascript">
$(window).scroll(function() {
   var hT = $('#nav').offset().top,
       hH = $('#nav').outerHeight(),
       wH = $(window).height(),
       wS = $(this).scrollTop();
   if ((wS+20) >= hT ){
       $("#nav").addClass("sticky");
       $("#nav").removeClass("mt-2");
   }if(wS < 230 ){
       $("#nav").addClass("mt-2");
       $("#nav").removeClass("sticky");
   }
});

</script>

<!-- Back to top button -->
<a id="button"></a>


<div id="new_mySidebar" class="new_sidebar">
  <a href="javascript:void(0)" class="closebtn" style="color: white !important; font-size: 36px; z-index: 2;" onclick="closeNav()">×</a>
  <div class="sidenav_user_id"><?php if(!$loggedin) echo "<a id='heading' class='btn text-white fs-4' href='".SITE_PATH."login'>Hello, Sign in</a>"; else{ $userArr = userProfileData($conn, $_SESSION['user_id']); echo "<a id='heading' class='btn text-white fs-4' href='".SITE_PATH."my_account'>Hello, ".$userArr[0]['fname']."</a>"; } ?></div>
  <div class="new_down_menu">
    <h5 class="p-dark">All Categories</h5>
    <ul class="nav flex-column">
      <?php foreach ($cat_data as $cat_row) { ?>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo SITE_PATH ?>categories/<?php echo $cat_row['id']?>">
          <span data-feather="shopping-cart"></span>
          <?php echo $cat_row['category']; ?>
        </a>
      </li>
      <?php  } ?>
    </ul>
    <h5 class="p-dark mt-5">Help & Settings</h5>
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link" href="<?php echo SITE_PATH ?>my_account">
          <span data-feather="shopping-cart"></span>
          Your Account
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo SITE_PATH ?>my_order">
          <span data-feather="shopping-cart"></span>
          Your Orders
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo SITE_PATH ?>address_manager">
          <span data-feather="shopping-cart"></span>
          Your Addressess
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo SITE_PATH ?>cart">
          <span data-feather="shopping-cart"></span>
          Cart
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo SITE_PATH ?>checkout">
          <span data-feather="shopping-cart"></span>
          Checkout
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo SITE_PATH; if($loggedin){ echo "logout"; }else{ echo "login"; } ?>">
          <span data-feather="shopping-cart"></span>
          <?php if($loggedin){ echo "Sign Out"; }else{ echo "Login"; } ?>
        </a>
      </li>
    </ul>

  </div>
</div>


<!-- Main Menu  -->
<section class="mainmenu-container mt-2 py-0" id="nav">
  <nav class="navbar navbar-expand-lg navbar-dark container-fluid py-0 my-0">

    <a class="navbar-brand nav-item px-2 my-0 py-0"><button class="new_openbtn btn" onclick="openNav()">☰ All</button></a>
    <button class="btn navbar-toggler border-0 text-white fs-2">
      <?php $cart = getCartPID($conn,$_SESSION['user_id']); ?>
      <i class="fa fa-shopping-cart"></i><b class="cart_count" id="cart_count"><?php echo count($cart); ?></b>
    </button>

    <div class="collapse navbar-collapse " id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">

        <?php 
            $i=0;
            foreach ($cat_data as $cat_row) { $i+=1;
          ?>
        <li class="nav-item ">
          <a class="nav-link navbar-nav_ul_a text-light" href="<?php echo SITE_PATH ?>categories/<?php echo $cat_row['id']?>"><?php echo $cat_row['category'];?></a>
        </li>
        <?php if($i==MAINMENU_CATEGORY_LIMIT) break; } ?>
      </ul>
    </div>
  </nav>
</section>

<script>
function openNav() {
  document.getElementById("new_mySidebar").style.width = "350px";
  document.getElementById("new_main").style.marginLeft = "0px";
}

function closeNav() {
  document.getElementById("new_mySidebar").style.width = "0";
  document.getElementById("new_main").style.marginLeft= "0";
}

  var btn = $('#button');

$(window).scroll(function() {
  if ($(window).scrollTop() > 300) {
    btn.addClass('show');
  } else {
    btn.removeClass('show');
  }
});

btn.on('click', function(e) {
  e.preventDefault();
  $('html, body').animate({scrollTop:0}, '300');
});


</script>


