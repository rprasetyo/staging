<?php

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );

/**
 * Plugin GDPR Compliance
 */
class WWS_GDPR_Compliance   {
    
    function __construct()  {

        if ( $this->_get_option( 'gdpr_status' ) != 1 )
            return;
        
        add_action( 'wws_action_plugin', array( $this, 'display_gdpr' ) );

    }

    function display_gdpr() {
        ?>
        <div class="wws-gdpr">
            <div>
                <label for="wws-gdpr-checkbox">
                    <input type="checkbox" id="wws-gdpr-checkbox"> <?php echo $this->get_gdpr_link(); ?>
                    </label>
            </div>
        </div>

        <?php
    }


    function get_gdpr_link() {

        $gdpr_page_slug         = $this->_get_option( 'gdpr_privacy_page' );
        $gdpr_page_data         = get_page_by_path( $gdpr_page_slug );
        $gdpr_page_title        = get_the_title( $gdpr_page_data );
        $gdpr_page_permalink    = site_url( '/'.$gdpr_page_slug.'/' );

        $gdpr_msg = str_replace(
            '{policy_url}',
            "<a href='{$gdpr_page_permalink}' target='_blank'>$gdpr_page_title</a>",
            $this->_get_option( 'gdpr_msg' )
        );

        return do_shortcode( $gdpr_msg );

    }


    private function _get_option( $data ) {

        $option = get_option( 'wws_gdpr_settings', array() );
        
        return $option[$data];
    }

} // end of WWS_GDPR_Compliance class

$wws_gdpr_compliance = new WWS_GDPR_Compliance;