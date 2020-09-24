(function($) {
    "use strict";
    function product_ajax_cart() {

        $(".mini-cart.v2").on( "click", function(e) {
            $('#wrapper-container').toggleClass('active-cart');
            $('#wrapper-container').toggleClass(e.currentTarget.dataset.offcanvas);
            $('.tbay-dropdown-cart').toggleClass('active');          
        });

        var $win = $(window); // or $box parent container
        var $box = $('.tbay-dropdown-cart .dropdown-content, .topbar-mobile .btn,#tbay-mobile-menu, .active-mobile button,#tbay-offcanvas-main,.topbar-mobile .btn-toggle-canvas,#tbay-offcanvas-main .btn-toggle-canvas');

        $win.on("click.Bst,click touchstart tap", function(event){       
            if ( $box.has(event.target).length == 0 && !$box.is(event.target) ){
                $('#wrapper-container').removeClass('active active-cart');
                $('.tbay-dropdown-cart').removeClass('active');  
                $('#tbay-offcanvas-main,.tbay-offcanvas').removeClass('active');    
                $( "#tbay-dropdown-cart" ).hide('500');          
            }
        });
        
    }
    function fixhome3() {
        // Fix Home 3
        var mainwidth       = jQuery('#tbay-main-content').width();
        var marginleft      = (mainwidth - jQuery('#tbay-main-content>.container').width())/2;
        jQuery('.tb-full').css('width', mainwidth);
        jQuery('.tb-full').css('max-width', mainwidth);

        if (jQuery('body').hasClass("rtl")) {
            jQuery('.tb-full').css('margin-right', - marginleft + 15);
        }
        else {
            jQuery('.tb-full').css('margin-left', - marginleft + 15);
        }

        jQuery('.tb-full .vc_fluid').css('padding', 0);
    }
    
    var width = $(window).width(); 

    if ( width >= 1600 ) {
        fixhome3();
    }
    jQuery(window).load(function(){
        if ( width >= 1600 ) {
            fixhome3();
        }
    });

    jQuery(window).scroll(function () {
        if ($(window).scrollTop() > 0) {

            if( jQuery('.header-v3').hasClass('fix') ) return;

            jQuery('.header-v3').addClass('fix');
        } else {
            jQuery('.header-v3').removeClass('fix');
        }
    });
    jQuery( window ).resize(function() {

        fixhome3();
    });
    jQuery( document).ready( function($){

    	//search horizontal
        $(".search-horizontal .btn-search-totop").on( "click", function() {
            $( ".container-search-horizontal" ).toggleClass('active');
        });

        function greenmart_click_horizontal_search() {
            var $win_search = $(window); // or $box parent container
            var $box_search = $('.search-horizontal .btn-search-totop, .container-search-horizontal,.ui-autocomplete.ui-widget-content.horizontal');

            $win_search.on("click.Bst", function(event){       
            if ( $box_search.has(event.target).length == 0 && !$box_search.is(event.target) ){
                    $( ".container-search-horizontal" ).removeClass('active');
                }
            });
        } 

        greenmart_click_horizontal_search();

        product_ajax_cart();

        //top menu
        $(".top-menu .dropdown .account-button").on( "click", function() {
            $( ".top-menu .dropdown .account-menu" ).slideToggle( 500, function() {});
        });

        function greemart_click_not_top_menu() {
            var $win_my_account = $(window); // or $box parent container
            var $box_my_account = $('.top-menu .dropdown .account-menu, .top-menu .dropdown .account-button');

            $win_my_account.on("click.Bst", function(event){       
            if ( $box_my_account.has(event.target).length == 0 && !$box_my_account.is(event.target) ){
                    $( ".top-menu .dropdown .account-menu" ).slideUp( 500, function() {});
                }
            });
        }
        greemart_click_not_top_menu(); 
    });
})(jQuery)
