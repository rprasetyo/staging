(function($) {
    "use strict";

    jQuery(document).ready(function ($){

        var acs_action  = 'greenmart_autocomplete_search',
            $t          = $("input[name='s']");


        $t.on("focus", function(){

            var appendto = ( typeof jQuery(this).parents('form').data('appendto') !== "undefined" ) ? jQuery(this).parents('form').data('appendto') : '';

            $(this).autocomplete({ 
                source: function(req, response){ 
                    $.ajax({
                        url: greenmart_ajax.ajaxurl+'?callback=?&action='+acs_action,
                        dataType: "json",
                        data: {
                            term: req.term,
                            category: this.element.parent().find('.dropdown_product_cat').val(),
                            style: this.element.data('style'),
                            post_type: this.element.parent().find('.post_type').val()
                        },
                        success: function(data,event, ui) {
                            response(data); 
                        },
                    });
                }, 
                minLength: 2,
                appendTo: appendto,
                autoFocus: true,
                search: function(event, ui) {
                    $(event.currentTarget).parents('.tbay-search-form').addClass('load');
                },
                select: function(event, ui) {
                    window.location.href = ui.item.link;
                },
                create: function() {

                    $(this).data('ui-autocomplete')._renderItem = function( ul, item ) {
                        var string = '';
                        if ( item.image != '' ) {
                            var string = '<a class="image" href="' + item.link + '" title="'+ item.label +'"><img class="pull-left" src="'+ item.image+'" style="margin-right:10px;"></a>';
                        }

                        string += '<div class="group">';
                        string += '<div class="name"><a href="' + item.link + '" title="'+ item.label +'">'+ item.label +'</a></div>';
                        if ( item.price != '' ) {
                            string += '<div class="price">'+ item.price +'</div> ';
                        }
                        string += '</div>';


                        return $( "<li>" ).append( string ).appendTo( ul );
                    };

                    jQuery(this).data('ui-autocomplete')._renderMenu = function (ul, items) {
                        var that = this
                        jQuery.each(items, function (index, item) {
                            that._renderItemData(ul, item)
                        })
                        
                        if( items[0].view_all ) {
                            ul.append('<li class="list-header ui-menu-divider">' + items[0].result + '</li>')
                            ul.append('<li class="list-bottom ui-menu-divider"><a class="search-view-all" href="javascript:void(0)">'+ greenmart_settings.view_all +'</a></li>')
                        } else {
                            ul.append('<li class="list-header ui-menu-divider">' + items[0].result + '</li>')
                        }

                        $( document.body ).trigger( 'greenmart_search_view_all' )
                    }

                }, 
                response: function(event, ui) {
                    // ui.content is the array that's about to be sent to the response callback.
                    if (ui.content.length === 0) {
                        $(".tbay-preloader").text("No results found");
                        $(".tbay-preloader").addClass('no-results');
                    } else {
                        $(".tbay-preloader").empty();
                        $(".tbay-preloader").removeClass('no-results');
                    }
                },
                open: function(event, ui) {
                    $(event.target).parents('.tbay-search-form').removeClass('load');
                    $(event.target).parents('.tbay-search-form').addClass('active');
                },
                close: function() {
                } 
            });

        });


        $(document.body).on('greenmart_search_view_all', () => {
            $('.search-view-all').on("click", function() {
                jQuery(this).parents('form').submit();
             });
        });

        $('.tbay-preloader').on('click', function(){    
            $(this).parents('.tbay-search-form').removeClass('active');          
            $(this).parents('.tbay-search-form').find('input[name=s]').val('');                  
        });

        $("input[name=s]").keyup(function(){
            if($(this).val().length == 0) {
                $(this).parents('.tbay-search-form').removeClass('load');
                $(this).parents('.tbay-search-form').removeClass('active');
                $(this).parents('.tbay-search-form').find('.tbay-preloader').empty();
            }           
        });

    });
})(jQuery)