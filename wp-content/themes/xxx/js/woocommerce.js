(function($) {
    "use strict";
	
    // add to cart modal
    var product_info = null;
    jQuery('body').on('adding_to_cart', function( button, data , data2 ) {
       product_info = data2;
    });

    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + "; " + expires+";path=/";
    }

    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i=0; i<ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1);
            if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
        }
        return "";
    } 



	// Ajax QuickView
	jQuery(document).ready(function(){
		
        if( !jQuery('body').hasClass('tbay-disable-ajax-popup-cart') ) {
            jQuery('body').on('added_to_cart', function( fragments, cart_hash ){
                if ( typeof product_info['page']  === "undefined" ) {
                    jQuery('#tbay-cart-modal').modal();
                    var url = greenmart_ajax.ajaxurl + '?action=greenmart_add_to_cart_product&product_id=' + product_info.product_id;
                    jQuery.get(url,function(data,status) {
                        jQuery('#tbay-cart-modal .modal-body .modal-body-content').html(data);
                    });
                    jQuery('#tbay-cart-modal').on('hidden.bs.modal',function() {
                        jQuery(this).find('.modal-body .modal-body-content').empty();
                    });
                }
            });
        }

        /*Product video iframe*/
        $("#productvideo").tbayIframe();

		$(document).on( 'added_to_wishlist removed_from_wishlist', function(){
		   var counter = $('.count_wishlist');
			   $.ajax({
			   url: yith_wcwl_l10n.ajax_url,
			   data: {
			   action: 'yith_wcwl_update_wishlist_count'
			   },
			   dataType: 'json',
			   success: function( data ){
				counter.html( data.count );
			   },
			   beforeSend: function(){
			   counter.block();
			   },
			   complete: function(){
			   counter.unblock();
			   }
			   })
		  } );

		// Ajax delete product in the cart
        $(document).on('click', '.mini_cart_content a.remove', function (e)
        {
            e.preventDefault();
            var product_id = $(this).attr("data-product_id"),
                cart_item_key = $(this).attr("data-cart_item_key"),
                product_container = $(this).parents('.mini_cart_item');

            var thisItem = $(this).closest('.widget_shopping_cart_content'); 

            // Add loader
            product_container.block({
                message: null,
                overlayCSS: {
                    cursor: 'none'
                }
            });

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: wc_add_to_cart_params.ajax_url,
                data: {
                    action: "product_remove",
                    product_id: product_id,
                    cart_item_key: cart_item_key
                },
                 beforeSend: function() {
                    thisItem.find('.mini_cart_content').append('<div class="ajax-loader-wapper"><div class="ajax-loader"></div></div>');
                    thisItem.find('.mini_cart_content').fadeTo("slow", 0.3);
                    e.stopPropagation();
                },
                success: function(response) {
                    if ( ! response || response.error )
                        return;

                    var fragments = response.fragments;

                    // Replace fragments
                    if ( fragments ) {
                        $.each( fragments, function( key, value ) {
                            $( key ).replaceWith( value );
                        });
                    }

                    $('.add_to_cart_button.added').each(function( index ) {
                        if( $(this).data('product_id') == product_id ) {
                            $(this).removeClass('added');
                            $(this).next('.wc-forward').remove();
                        }
                    });

                }
            });
        });
	
	});

    $(document).on('click', '.single_add_to_cart_button', function (e) {

        if ( !greenmart_settings.ajax_single_add_to_cart ) {
            return;  
        }
 
        if( $(this).closest('form.cart').find('input[name="greenmart_buy_now"]').length > 0 &&  $(this).closest('form.cart').find('input[name="greenmart_buy_now"]').val() === "1" ) return;
     
        let $button = $(this),
            $form = $button.closest('form.cart')

        if( $form.hasClass('grouped_form') || ($form.find('input[name=quantity]').length == 0) ) {
            return
        }

        let     id = $button.val(),
                product_qty = $form.find('input[name=quantity]').val() || 1,
                product_id = $form.find('input[name=product_id]').val() || id,
                variation_id = $form.find('input[name=variation_id]').val() || 0;

        if (!product_id)
            return;
        
        if ($button.is('.disabled'))
            return;

        e.preventDefault();

        var data = {
            action: 'woocommerce_ajax_add_to_cart',
            page: 'single',
            product_id: product_id,
            product_sku: '',
            quantity: product_qty,
            variation_id: variation_id,
        };
 
        $(document.body).trigger('adding_to_cart', [$button, data]);
 
        $.ajax({
            type: 'post',
            url: wc_add_to_cart_params.ajax_url, 
            data: data,
            beforeSend: function (response) {
                $button.removeClass('added').addClass('loading');
            },
            complete: function (response) {
                $button.addClass('added').removeClass('loading');
            },
            success: function (response) {
 
                if (response.error & response.product_url) {
                    window.location = response.product_url;
                    return;
                } else {
                    $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $button]);
                    $('.woocommerce-notices-wrapper').empty().append(response.notices);
                }
            },
        });
 
        return false;
    });

    $(document).on('click', '.plus, .minus', function() {
        // Get values
        var $qty        = $(this).closest('.quantity').find('.qty'),
            currentVal  = parseFloat($qty.val()),
            max         = $qty.data('max'),
            min         = $qty.data('min'),
            step         = $qty.data('step');

        // Format values
        if(! currentVal || currentVal === '' || currentVal === 'NaN') currentVal = 0;
        if(max === '' || max === 'NaN') max = '';
        if(min === '' || min === 'NaN') min = 0;
        if(step === 'any' || step === '' || step === undefined || parseFloat(step) === 'NaN') step = 1;

        // Change the value
        if($(this).is('.plus')) {
            if(max &&(max == currentVal || currentVal > max)) {
                $qty.val(max);
            } else {
                $qty.val(currentVal + parseFloat(step));
            }

        } else {
            if(min &&(min == currentVal || currentVal < min)) {
                $qty.val(min).trigger('change');;
            } else if(currentVal > 0) {
                $qty.val(currentVal - parseFloat(step));
            }
        }

        // Trigger change event
        $qty.change();

    }); 



    $('.tbay-body-woocommerce-quantity-mod .quantity input[type="number"]').change(function() {
       var  currentVal  = parseFloat($(this).val()),
            max         = $(this).data('max'),
            min         = $(this).data('min');

        if ( currentVal < min ) { 
            $(this).val(min);
            $(this).change();
        }  else if( max != ''  && currentVal > max ) {
            $(this).val(max);
            $(this).change();
        } 



        var add_to_cart_button = jQuery( this ).parents( ".product-content" ).find( ".add_to_cart_button" );
        // For AJAX add-to-cart actions
        add_to_cart_button.attr( "data-quantity", currentVal );
    });
	
	// thumb image
	$('.thumbnails-image .thumb-link').on("click", function(e){
		e.preventDefault();
		var image_url = $(this).attr('href');
		var image_full_url = $(this).data('image');
		$('.woocommerce-main-image .featured-image').attr('href', image_full_url);
		$('.woocommerce-main-image .featured-image img').attr('src', image_url);
		$('.cloud-zoom').CloudZoom();
	});

    /*Greenmart Buy Now*/
    $('body').on('click', '.tbay-buy-now', function (e) {
      e.preventDefault();
      let productform = $(this).closest('form.cart'),
          submit_btn = productform.find('[type="submit"]'),
          buy_now = productform.find('input[name="greenmart_buy_now"]'),
          is_disabled = submit_btn.is('.disabled');
 
      if (is_disabled) { 
        submit_btn.trigger('click');
      } else { 
        buy_now.val('1');
        productform.find('.single_add_to_cart_button').click();
      }
    }); 

    $(document.body).on('check_variations', function() {
        let is_submit_disabled = $('form.cart').find('[type="submit"]').is('.disabled');
        if ( is_submit_disabled ) {
            $('.tbay-buy-now').addClass('disabled');  
        } else {  
            $('.tbay-buy-now').removeClass('disabled');
        }
    });

    /*Single product video iframe*/
    $.fn.tbayIframe = function( options ) {
        var self = this;
        var settings = $.extend({
            classBtn: '.tbay-modalButton',
            defaultW: 640,
            defaultH: 360
        }, options );
      
        $(settings.classBtn).on('click', function(e) {
          var allowFullscreen = $(this).attr('data-tbayVideoFullscreen') || false;
          
          var dataVideo = {
            'src': $(this).attr('data-tbaySrc'),
            'height': $(this).attr('data-tbayHeight') || settings.defaultH,
            'width': $(this).attr('data-tbayWidth') || settings.defaultW
          };
          
          if ( allowFullscreen ) dataVideo.allowfullscreen = "";
          
          // stampiamo i nostri dati nell'iframe
          $(self).find("iframe").attr(dataVideo);
        });
      
        // se si chiude la modale resettiamo i dati dell'iframe per impedire ad un video di continuare a riprodursi anche quando la modale è chiusa
        this.on('hidden.bs.modal', function(){
          $(this).find('iframe').html("").attr("src", "");
        });
      
        return this;
    };

    tbay_display_mode_grid();

    function tbay_display_mode_grid() {

        $(document).on('click', '#display-mode-grid', function(event) {
            event.preventDefault();
            $(event.currentTarget).addClass('active').next().removeClass('active');

            setCookie('display_mode', 'grid', 0.1)

            if( !$(event.currentTarget).parents('#primary').find('div.products').hasClass('products-grid') ) {
                $(event.currentTarget).parents('#primary').find('div.products').fadeOut(0, function() {
                    $(this)
                        .addClass('products-grid')
                        .removeClass('products-list')
                        .fadeIn(300); 
                })

                $(event.currentTarget).parents('#primary').find('div.products').find('.product-block')
                .removeClass('list')
                .fadeIn(300)
                .addClass('grid');
            }

            return false;
        });    

        $(document).on('click', '#display-mode-list', function(event) {
            event.preventDefault();
            $(event.currentTarget).addClass('active').prev().removeClass('active');

            setCookie('display_mode', 'list', 0.1);

            if( !$(event.currentTarget).parents('#primary').find('div.products').hasClass('products-list') ) {
                $(event.currentTarget).parents('#primary').find('div.products').fadeOut(0, function() {
                    $(this).addClass('products-list').removeClass('products-grid').fadeIn(300);
                })

                $(event.currentTarget).parents('#primary').find('div.products').find('.product-block')
                .removeClass('grid')
                .fadeIn(300)
                .addClass('list');
            }

            return false;
        });


        if ( getCookie('display_mode') != undefined ) {

            if ( getCookie('display_mode') == 'grid' ) {
                $('.tbay-filter').next('div.products').removeClass('products-list').fadeIn(300)
                $('.display-mode-warpper')
                    .find("#display-mode-grid")
                    .addClass('active')
                    .next()
                    .removeClass('active');

                $('.tbay-filter').parents('#primary').find('div.products').find('.product-block')
                                .removeClass('list')
                                .fadeIn(300)
                                .addClass('grid');
            }

            if ( getCookie('display_mode') == 'list') {
                $('.tbay-filter').parents('#primary').find('div.products').removeClass('products-grid').fadeIn(300)
                $('.display-mode-warpper').find("#display-mode-list")
                    .addClass('active')
                    .prev()
                    .removeClass('active');

                $('.tbay-filter').parents('#primary').find('div.products').find('.product-block')
                                .removeClass('grid')
                                .fadeIn(300)
                                .addClass('list');
            }

            $('.tbay-filter').parents('#primary').find('div.products').addClass('products-'+ getCookie('display_mode'));
        }


    }

 

	
})(jQuery)