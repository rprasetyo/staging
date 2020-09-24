(function( $ ) {
    "use strict";

    // Time picker initilization
    jQuery(document).ready(function() { 
        jQuery('.wws-timepicker').timepicker({ 'timeFormat': 'H:i:s'});
    });

    // Datatable init
    jQuery('.wws-admin-datatable').DataTable({
        order: [[ 0, "asc" ]],
        dom: 'Bfrtip',
        buttons: [
            {
              extend: 'csv',
              text: 'Export CSV'
            },
        ]
    });

    /*
     * Button generator JS
     * @since 1.3
     */
    jQuery( document ).on('keyup change click load', '.wws-button-generator', function(event) {
        event.preventDefault();
        
        var buttonType          = jQuery( '#wws-button-gen-button-type' ).val();

        var buttonText          = jQuery( '#wws-button-gen-button-text' ).val();
        var buttonBgColor       = jQuery( '#wws-button-gen-bg-color' ).val();
        var buttonTextColor     = jQuery( '#wws-button-gen-text-color' ).val();
        var buttonBoldText      = jQuery( '#wws-button-gen-bold-text' ).val();
        var buttonFullWidth     = jQuery( '#wws-button-gen-full-width' ).val();

        jQuery( '#wws-button-gen-support, #wws-button-gen-invitation' ).hide();
        if ( buttonType == 'support-button' ) {
            jQuery( '#wws-button-gen-support' ).show();
        } else {
            jQuery( '#wws-button-gen-invitation' ).show();
        }

        // change button text
        jQuery( '#wws-button-gen-btn-visual' ).html( '<i class="wc-fa wc-fa-whatsapp"></i> ' + buttonText );
        // change button style
        jQuery( '#wws-button-gen-btn-visual' ).css({
            'background-color': buttonBgColor,
            'color': buttonTextColor,
            'font-weight': ( buttonBoldText == 1 ) ? '700' : 'inherit',
            'width': ( buttonFullWidth == 1 ) ? '100%' : 'auto',
        });

    });

    jQuery( document ).on('click', '#wws-button-gen-code', function(event) {
        event.preventDefault();
        
        var shortcodeBox        = jQuery( '#wws-button-gen-shortcode' );
        var htmlBox             = jQuery( '#wws-button-gen-html' );

        var supportNumber       = jQuery( '#wws-button-gen-support-number' ).val();
        var invitationID        = jQuery( '#wws-button-gen-invitation-id' ).val();

        var buttonType          = jQuery( '#wws-button-gen-button-type' ).val();

        var buttonText          = jQuery( '#wws-button-gen-button-text' ).val();
        var buttonBgColor       = jQuery( '#wws-button-gen-bg-color' ).val();
        var buttonTextColor     = jQuery( '#wws-button-gen-text-color' ).val();
        var buttonBoldText      = jQuery( '#wws-button-gen-bold-text' ).val();
        var buttonFullWidth     = jQuery( '#wws-button-gen-full-width' ).val();
        var buttonFont          = jQuery( '#wws-button-gen-font' ).val();
        var message             = jQuery( '#wws-button-gen-message' ).val();
        var onMobile            = jQuery( '#wws-button-gen-on-mobile' ).val();
        var onDesktop           = jQuery( '#wws-button-gen-on-desktop' ).val();

        var shortcode = '';
            shortcode += '[whatsappsupport ';
        
        if ( buttonType == 'support-button' ) {
            shortcode += 'number="'+supportNumber+'" ';
        } else if ( buttonType == 'invitation-button' ) {
            shortcode += 'group="'+invitationID+'" ';
        }

            shortcode += 'text="'+buttonText+'" ';
            shortcode += 'text-color="'+buttonTextColor+'" ';
            shortcode += 'bg-color="'+buttonBgColor+'" ';

            if ( buttonBoldText == 1 ) {
                shortcode += 'bold-text="'+( ( buttonBoldText == 1 ) ? '700' : 'inherit' )+'" ';
            }

            if ( buttonFont != 'inherit' ) {
                shortcode += 'font="'+buttonFont+'" ';
            }

            shortcode += 'message="'+message+'" ';

            if ( buttonFullWidth == 1 ) {
                shortcode += 'full-width="'+( ( buttonFullWidth == 1 ) ? 'yes' : 'no' )+'" ';
            }

            if ( onMobile == 0 ) {
                shortcode += 'on-mobile="'+( ( onMobile == 1 ) ? 'yes' : 'no' )+'" ';
            }
            if ( onDesktop == 0 ) {
                shortcode += 'on-desktop="'+( ( onDesktop == 1 ) ? 'yes' : 'no' )+'"';
            }
            
            shortcode += ']';

        var html = '';

            if ( buttonType == 'support-button' ) {
                html += '<a href="https://wa.me/'+supportNumber+'?text='+message+'" ';
            } else if ( buttonType == 'invitation-button' ) {
                html += '<a href="https://chat.whatsapp.com/'+invitationID+'" ';
            }

            html += 'style="';
            html += 'background-color:'+buttonBgColor+'; ';
            html += 'color:'+buttonTextColor+'; ';
            html += 'font-weight:'+( ( buttonBoldText == 1 ) ? '700' : 'inherit' )+'; ';
            html += 'width:'+( ( buttonFullWidth == 1 ) ? '100%; display: block; ' : 'auto' )+'; ';
            html += 'padding: 8px 25px; ';
            html += 'margin: 2px ;';
            html += 'border-radius: 3px; ';
            html += 'text-align: center;';
            html += '" '; // Style tag close
            html += 'target="_blank">'+buttonText+'</a>';
            
            htmlBox.val( html );
            shortcodeBox.val( shortcode );

    });


    /*
     * Link generator JS
     * @since 1.3
     */
    jQuery( document ).on('keyup change click load', '.wws-link-generator', function(event) {
        event.preventDefault();

        var linkType        = jQuery( '#wws-link-gen-link-type' ).val();

        jQuery( '#wws-link-gen-chat, #wws-link-gen-group, #wws-link-gen-message-field' ).hide();

        if ( linkType == 'chat-link' ) {

            jQuery( '#wws-link-gen-chat, #wws-link-gen-message-field' ).show();

        } else if ( linkType == 'group-link' ) {

            jQuery( '#wws-link-gen-group' ).show();

        }

    });

    jQuery( document ).on('click', '#wws-link-gen-code', function(event) {
        event.preventDefault();

        var linkBox         = jQuery( '#wws-link-gen-link' );
        
        var linkType        = jQuery( '#wws-link-gen-link-type' ).val();

        var whatsappNumber  = jQuery( '#wws-link-gen-chat-number' ).val();
        var groupID         = jQuery( '#wws-link-gen-group-id' ).val();
        var message         = jQuery( '#wws-link-gen-message' ).val();

        if ( linkType == 'chat-link' ) {

            linkBox.val( 'https://wa.me/'+whatsappNumber+'?text='+message+'' );
            
        } else if ( linkType == 'group-link' ) {

            linkBox.val( 'https://chat.whatsapp.com/'+groupID+'' );

        }

    });

    // Display edit multi account popup
    jQuery('.wws_edit_multi_account_show_popup').click(function() {
        var key = jQuery(this).attr('data-multi-account-key');
        tb_show('Edit Multi Account Support', 'admin-ajax.php?action=wws_edit_multi_support_person&person_id=' + key);
        return false;
    });

    // Display add multi account popup
    jQuery('.wws_add_multi_account_show_popup').click(function() {
        tb_show('Add Multi Account Support', 'admin-ajax.php?action=wws_add_multi_support_person');
        return false;
    });


    // Analytics deep report
    jQuery( document ).on ( 'click', '[data-ip]', function() {

        var ip = jQuery( this ).attr( 'data-ip' );

        tb_show('Analytics Deep Report', 'admin-ajax.php?action=wws_analytics_deep_report&ip=' + ip );
        return false;

    });


    // QR Code generation.
    jQuery( '#wws-qr-gen-code' ).on( 'click', function() {

        jQuery( '#wws-qr-gen-code i' ).css( 'display', 'inline-block' );

        jQuery.ajax({
            url: wwsAdimnObj.adminAjaxURL,
            type: 'post',
            dataType: 'json', 
            data: {
                'action':   'wws_admin_qr_generator',
                'support_number' : jQuery( '#wws-qr-number' ).val(),
                'pre_message' : jQuery( '#wws-qr-textarea' ).val(),
                'qr_size' : jQuery( '#wws-qr-size' ).val(),
            }
        }).done(function( response ) {
            jQuery( '#wws-qr-gen-shortcode' ).val( response.shortcode );
            jQuery( '#wws-admin-qr-view img' ).attr( 'src', response.generatedQR );
            jQuery( '#wws-admin-qr-view div' ).html( response.preMessage );
            jQuery( '#wws-qr-gen-code i' ).hide();
        });

    } );

})(jQuery)