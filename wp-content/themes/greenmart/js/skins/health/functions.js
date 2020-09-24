(function($) {
    "use strict";
    jQuery( document).ready( function($){

    	function click_icon_dropdown() {
	    	$('.click-icon-wrapper .dropdown-menu').on('click', function(event){
			    // The event won't be propagated up to the document NODE and 
			    // therefore delegated events won't be fired
			    event.stopPropagation();
			});
    	}

    	click_icon_dropdown();

    });
})(jQuery)
