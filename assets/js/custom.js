
// function to display alert messages
function alertMsg(msg, link='', time=0){
	$("#alert-msg").html(msg);
    if(time==0)
      time = 2000
    else
      time = time
    $("#alert-msg").fadeIn('fast');
    setTimeout(function(){
    	$("#alert-msg").fadeOut('slow');
    	if(link!=''){
	    	window.location.href=link;
    	}
    },time);
}

$(window).on('load', function() { // makes sure the whole site is loaded 
	jQuery('#wpf-loader-two').delay(200).fadeOut('slow');
})

$(document).ready(function(){


	// Redierecting to register page from checkout 
  $("#checkout-register").click( function()
   {
   		window.location.href="https://electrozon.in/register";
   });

  // Redierecting to Address Manager from checkout 
  $("#address-manager").click( function()
   {
      window.location.href="https://electrozon.in/address_manager";
   });


  // Humburger toggle
  $("#hamburger_btn").click(function(ev) {
    if($('#hamburger_btn').is(':checked')){

      // Prevent scrolling
      $('html').css('overflow','hidden');
      $('body').css('pointer-events','none');
      // prevent click on page
      $('.humburger_blank_space').removeClass('d-none');
      $('#menuToggle').css('pointer-events','all');

    // Humburger Unckeck actions
    }else{
      $('html').css('overflow','auto');
      $('body').css('pointer-events','all');
      $('.humburger_blank_space').addClass('d-none');
    }
  });

  // Humburger Close by clickng on black space
  $("#humburger_blank_space").click(function(ev) {
    $('#hamburger_btn').prop('checked', false);
    $('html').css('overflow','auto');
    $('body').css('pointer-events','all');
    $('.humburger_blank_space').addClass('d-none');
  });

  // Place Order
  $("#place_order_btn").click( function()
   {
    $.ajax({
        type: "POST",
        url: "https://electrozon.in/checkout.php",
        data: {'type':'place_order'},

        success: function (data)
            {
              emptyCart();
              alert(data);
              // window.location.href = data;
            },
        error: function (data)
            {
              alert('Error');
              return false;
            }
      });
   });



  // Toggle billing address 
  $("[name=billing-address-selecter]").click(function(){
      $('.toHide').hide();
      $("#add-"+$(this).val()).show('slow');
    });

});




// Load cart information on Navigation Bar
function loadcart(user_id){
	$.ajax({
	 type: "POST",
	 url: 'https://electrozon.in/manage_cart.php',
	 data: 'type=cartCount&username='+user_id,
	 success: function(result){
  	 console.log(result)
  	 jQuery('#cart_count').html(result)
	 },
  	 error: function(xhr, status, error){
  	 console.error(xhr);
	 }
	});
}


// Update Product Quantity in CART
function update_val(PID, max, inputID){
	var qty = $("#"+inputID+PID).val();
	if(qty<=max){
		$.ajax({
	        type: "POST",
	        url: "https://electrozon.in/manage_cart.php",
	        data: {'type':'update','pid':PID,'qty':qty},

	        success: function (data)
	            {
		            alertMsg('Product Updated Successfully', 'https://electrozon.in/cart', 1);
	            },
	        error: function (data)
	            {
	              alert('Error');
	              return false;
	            }
	    });
	}else{
		alertMsg('We have only '+max+' items of this product.');
	}
}



// Remove product from Cart
function removeCart(PID){
	$.ajax({
        type: "POST",
        url: "https://electrozon.in/manage_cart.php",
        data: {'type':'remove','pid':PID},

        success: function (data)
            {
      				alertMsg('Product Removed Successfully', 'https://electrozon.in/cart', 1);
            },
        error: function (data)
            {
              alert('Error');
              return false;
            }
    });
}

// Empty Cart
function emptyCart(){
  $.ajax({
        type: "POST",
        url: "https://electrozon.in/manage_cart.php",
        data: {'type':'empty'},

        success: function (data)
            {
                return true;
            },
        error: function (data)
            {
              alert('Error');
              return false;
            }
    });
}


// Add product in cart
function addCart(username, PID, qty=1,link=''){
	$.ajax({
        type: "POST",
        url: "https://electrozon.in/manage_cart.php",
        data: {'type':'add','pid':PID,'qty':qty},

        success: function (data)
            {
              	loadcart(username);

              	if(link!=''){
					       alertMsg('Product Added Successfully',link, 1);
              	}else{
					       alertMsg('Product Added Successfully');
              	}
            },
        error: function (data)
            {
              alert('Error');
              return false;
            }
    });
}



// Delete Pending Address Requests
function DeleteAddress(addId){
  $.ajax({
      type: "POST",
      url: "https://electrozon.in/address_manager.php",
      data: {'type':'deleteAddress','addId':addId},

      success: function (data)
          {
            alertMsg('Address Deleted Successfully', 'https://electrozon.in/address_manager.php', 100);
          },
      error: function (data)
          {
            alert('Error');
            return false;
          }
    });
}


// Address Selection for checkout
function AddressData(data){
  $.ajax({
      type: "POST",
      url: "https://electrozon.in/checkout.php",
      data: {'type':'address','data':data},

      success: function (data)
          {
            alertMsg('Address Selected Successfully', 'https://electrozon.in/checkout', 100);
          },
      error: function (data)
          {
            alert('Error');
            return false;
          }
    });
}


// Payment Method Selection for checkout
function PaymentMethod(){
  if($('#TandD').is(':checked')){
    var data = $('input[name="payment_method"]:checked').val();
    $.ajax({
        type: "POST",
        url: "https://electrozon.in/checkout.php",
        data: {'type':'payment_method','data':data},

        success: function (data)
            {
              $('#TandD').attr('checked');
              alertMsg('Payment Method Selected', 'https://electrozon.in/checkout', 100);
            },
        error: function (data)
            {
              alert('Error');
              return false;
            }
      });
  }else{
    alert("Please check Terms and Conditions")
  }
}



function viewOrderDetail(id){
    window.location.href="https://electrozon.in/my_order_details/"+id;
}
