<?php
$sql = 'SELECT * from categories where status=1';
$res=mysqli_query($conn, $sql);
?>

<style type="text/css">
  .sticky{
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 999;
    left: 0;
    transition: 0.1s;
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

<!-- Main Menu  -->
<section class="mainmenu-container mt-2 py-1" id="nav">
  <nav class="navbar navbar-expand-lg navbar-dark container">

    <a class="navbar-brand nav-item px-2" href="<?php echo SITE_PATH ?>"><i class="fa fa-home fa-lg"></i></a>
    <button class="btn navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse " id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">

        <?php 
            $i=0;
            while($row=mysqli_fetch_assoc($res)) { $i+=1;
          ?>
        <li class="nav-item ">
          <a class="nav-link navbar-nav_ul_a text-light" href="<?php echo SITE_PATH ?>categories/<?php echo $row['id']?>"><?php echo $row['category'];?></a>
        </li>
        <?php if($i==MAINMENU_CATEGORY_LIMIT) break; } ?>
      </ul>
    </div>
  </nav>
</section>
