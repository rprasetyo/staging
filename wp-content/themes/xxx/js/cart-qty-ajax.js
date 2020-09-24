(function($) {
    "use strict";

    $( document ).on( 'change', '.woocommerce-cart-form input.qty', function() {

		if (greenmart_settings.ajax_update_quantity) {
			$("[name='update_cart']").trigger('click')
		}

    });

});