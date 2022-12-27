<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">

const width1000 = window.matchMedia('(max-width: 1000px)')
 
function handleTabletChange(e) {
  if (e.matches) {
    $(".top_nav_contact").hide();
    $(".top-row").removeClass("px-5");
    $(".top-row").addClass("px-1");
    $(".footer-row").css("display", "block");
  }else{
    $(".top_nav_contact").show();
    $(".top-row").addClass("px-5");
    $(".top-row").removeClass("px-1");
    $(".footer-row").css("display", "flex");
  }
}

  $( document ).ready(function() {
      
      width1000.addListener(handleTabletChange)
      handleTabletChange(width1000)
      loadcart("<?php echo $user_id; ?>")
      
  });
</script>
