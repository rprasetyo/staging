var thwmscf_admin = (function($){
	$(function(){
		$( ".thpladmin-colorpick" ).each(function() {     	
			var value = $(this).val();
			$( this ).parent().find( '.thpladmin-colorpickpreview' ).css({ backgroundColor: value });
		});

	    $('.thpladmin-colorpick').iris({
			change: function( event, ui ) {
				$( this ).parent().find( '.thpladmin-colorpickpreview' ).css({ backgroundColor: ui.color.toString() });
			},
			hide: true,
			border: true
		}).click( function() {
			$('.iris-picker').hide();
			$(this ).closest('td').find('.iris-picker').show(); 
		});

		$('body').click( function() {
			$('.iris-picker').hide();
		});

		$('.thpladmin-colorpick').click( function( event ) {
			event.stopPropagation();
		});
	});

	function backtocart(elm){
		var cart_text_settings = $('.back-to-cart-show');		
		if(elm.checked){
			cart_text_settings.show();;
		}else{
			cart_text_settings.hide();
		}
	}

	function displaylogin(elm){
		var cart_text_settings = $('.display-login-step');		
		if(elm.checked){
			cart_text_settings.show();;
		}else{
			cart_text_settings.hide();
		}
	}

	return {
		backtocart : backtocart,
		displaylogin : displaylogin,
	}
}(window.jQuery, window, document))

function thwmscfBackToCart(elm){
	thwmscf_admin.backtocart(elm);
}
function thwmscfDisplayLogin(elm){
	thwmscf_admin.displaylogin(elm);
}