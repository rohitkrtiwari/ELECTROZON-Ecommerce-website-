// function to display alert messages
function alertMsg(msg, link=''){
  $("#alert-msg").html(msg);
    $("#alert-msg").fadeIn('fast');
    $(window).scrollTop(0);
    setTimeout(function(){
      $("#alert-msg").fadeOut('slow');
      if(link!=''){
        window.location.href=link;
      }
    },500);
}

function show_preloader(){
    $('body').css({'overflow':'hidden'});
    $('#status').fadeIn(); 
    $('#preloader').delay(350).fadeIn('slow');  
}

function hide_preloader(){
    $('#status').fadeOut(); 
    $('#preloader').delay(350).fadeOut('slow'); 
    $('body').delay(350).css({'overflow':'visible'}); 
}


$(document).click(function(e) {
   if($(e.target).is(".edit_field")){
   } else{ 
     $(".edit_field").prop('disabled', true);
   }
});



$(window).on('load', function() {
  hide_preloader();
})


$(document).ready(function() {

  $('.confirm').click(function() {
    event.preventDefault();
    var r=confirm("Are you sure ?");
    if (r==true)   {  
       window.location = $(this).attr('href');
    }
  });

  $(".cat_name").change(function() {
    catname = $(this).val();
    catId = $(this).attr('id');
    $.ajax({
      type: "POST",
      url: "https://electrozon.in/ab_admin-lg/categories.php",
      data: {'type':'update_catname', 'catId':catId, 'catname':catname},

      success: function (data)
          {
            hide_preloader();
            alertMsg("Category Updated", "https://electrozon.in/ab_admin-lg/categories");

          },
      error: function (data)
          {
            hide_preloader();
            alert('Error');
            return false;
          }
    });
    
  })

  
   $(".subcat_name").change(function() {
    subcatname = $(this).val();
    subcatId = $(this).attr('id');
    $.ajax({
      type: "POST",
      url: "https://electrozon.in/ab_admin-lg/sub_categories.php",
      data: {'type':'update_subcatname', 'subcatId':subcatId, 'subcatname':subcatname},

      success: function (data)
          {
            hide_preloader();
            alertMsg("Category Updated", "https://electrozon.in/ab_admin-lg/sub_categories");

          },
      error: function (data)
          {
            hide_preloader();
            alert('Error');
            return false;
          }
    });
    
  })

   $(".subcat_catID").change(function() {
    catId = $(this).val();
    subcatId = $(this).attr('sd');
    $.ajax({
      type: "POST",
      url: "https://electrozon.in/ab_admin-lg/sub_categories.php",
      data: {'type':'update_subcat_catID', 'subcatId':subcatId, 'catId':catId},

      success: function (data)
          {
            hide_preloader();
            alertMsg("Category Updated", "https://electrozon.in/ab_admin-lg/sub_categories");

          },
      error: function (data)
          {
            hide_preloader();
            alert('Error');
            return false;
          }
    });
    
  })

  $('#tracking_id_btn').click(function() {
    $.when(show_preloader()).then(function() {
      trackingId = $("#tracking_id").val();
      if(trackingId == '') trackingId = 'None';
      order_id = $("#tracking_id").attr('name');
      $.ajax({
          type: "POST",
          url: "https://electrozon.in/ab_admin-lg/orders.php",
          data: {'type':'update_tracking_id', 'tracking_id':trackingId, 'order_id':order_id},

          success: function (data)
              {
                hide_preloader();
                alertMsg("Tracking ID updated", "https://electrozon.in/ab_admin-lg/orders");

              },
          error: function (data)
              {
                hide_preloader();
                alert('Error');
                return false;
              }
        });
    });
  });
});


function enable(id){
  $("#"+id).prop('disabled', false);
  $('.edit_field:not(#'+id+')').prop('disabled', true);
}