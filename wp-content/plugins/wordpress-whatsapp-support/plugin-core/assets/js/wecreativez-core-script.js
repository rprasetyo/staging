(function($) { 
"use strict"; 

	tippy('.wecreativez-admin-tooltip');

	// Add Color Picker to all inputs that have 'color-field' class
	jQuery('.wecreativez-color-field').wpColorPicker();
	  

	jQuery('.wecreativez-multi-select').select2();


    jQuery('.wecreativez-datatable').DataTable({
        "order": [[ 0, "asc" ]],
    });

    // upload image
    jQuery( document ).on( 'click', '[data-wecreativez-upload-id]', function(e) {
        e.preventDefault();
        var uid = jQuery( this ).attr( 'data-wecreativez-upload-id' );
        var image = wp.media({ 
            title: 'Upload Image',
            // mutiple: true if you want to upload multiple files at once
            multiple: false
        }).open()
        .on('select', function(e){
            // This will return the selected image from the Media Uploader, the result is an object
            var uploaded_image = image.state().get('selection').first();
            // We convert uploaded_image to a JSON object to make accessing it easier
            // Output to the console uploaded_image
            console.log(uploaded_image);
            var image_url = uploaded_image.toJSON().url;
            // Let's assign the url value to the input field
            jQuery('[data-wecreativez-upload-url-id='+uid+']').val(image_url);
        });
    });


})(jQuery)