<?php

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );

/**
* WooCommerce Product Query
* @package WeCreativez/Classes
* @since 1.5
*/
class WWS_Product_Query {


    public function __construct() {

        if ( $this->_get_setting( 'status' ) != '1' ) {
            return false;
        }

        if ( $this->_get_setting( 'btn_location' ) == 'woocommerce_before_add_to_cart_form' ) {
            add_action( 'woocommerce_before_add_to_cart_form', array( $this, 'product_query_button' ) );
        }

        if ( $this->_get_setting( 'btn_location' ) == 'woocommerce_after_add_to_cart_button' ) {
            add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'product_query_button' ) );
        }

        add_shortcode( 'wws_product_query', array( $this, 'product_query_button_shortcode' ) );

    }


    /**
    * Get saved settings
    * @param  string $setting value of the option
    * @since 1.5
    */
    private function _get_setting( $setting ) {
        $data = get_option( 'wws_product_query', array() );
        return $data[$setting];
    }


    public function product_query_button() {

        if ( $this->is_displayable() != true ) {
            return false;
        }

        
        $support_pre_message = str_replace( 
            array(
                '{url}',
                '{title}',
            ),
            array(
                get_the_permalink( get_the_ID() ),
                get_the_title( get_the_ID() ),
            ),
            $this->_get_setting( 'support_pre_message' )
        );

        $btn_label                      = esc_html( $this->_get_setting( 'btn_label' ) );
        $btn_bg_color                   = esc_html( $this->_get_setting( 'btn_bg_color' ) );
        $btn_text_color                 = esc_html( $this->_get_setting( 'btn_text_color' ) );
        $support_person_img             = esc_url( $this->_get_setting( 'support_person_img' ) );
        $support_person_name            = esc_html( $this->_get_setting( 'support_person_name' ) );
        $support_person_title           = esc_html( $this->_get_setting( 'support_person_title' ) );
        $support_number                 = esc_html( $this->_get_setting( 'support_number' ) );
        $support_pre_message            = do_shortcode( $support_pre_message );

        echo do_shortcode( "[wws_product_query 
            bg-color='{$btn_bg_color}' 
            text-color='{$btn_text_color}' 
            button-text='{$btn_label}' 
            number='{$support_number}' 
            name='{$support_person_name}' 
            title='{$support_person_title}' 
            image='{$support_person_img}' 
            message='{$support_pre_message}']" 
        );

    }





    public function is_displayable() {  

        if ( function_exists( 'is_product' ) && ! is_product() ) {
            return false;
        }

        if ( in_array( get_the_ID(), $this->_get_setting( 'exclude_by_products' ) ) == true ) {
            return false;
        }

        //  Get the WooCommerce products categories
        $terms = get_the_terms ( get_the_ID(), 'product_cat' );

        foreach ( $terms as $term ) {
            // Assign each category slug in $cat_slugs array
            $cat_slugs[] = $term->slug;
        }

        // Check, if category exists in admin selected category
        foreach ( $cat_slugs as $cat_slug) {
            // If exists then return true.
            if ( in_array( $cat_slug, (array)$this->_get_setting( 'exclude_by_categories' ) ) ) {
                return false;
            }
        }

        return true;

    }



    public function product_query_button_shortcode( $atts ) {
        
        $a = shortcode_atts( array(
            'bg-color'      => '#22C15E',
            'text-color'    => '#ffffff',
            'button-text'   => 'Need Help? Contact Us via WhatsApp',
            'number'        => '911234567890',
            'name'          => 'Maya',
            'title'         => 'Pre-sale Questions',
            'image'         => '',
            'message'       => 'Hi, I need help with {title} {url}'
        ), $atts );

        ob_start();
        ?>
        <style>
            a.wws-product-query-btn {
                display: inline-flex;
                width: auto;
                align-items: center;
                justify-content: center;
                padding: 5px 8px;
                border-radius: 3px;
                position: relative;
                text-decoration: none !important;
                margin: 5px 0;
            }
            .wws-product-query-btn__img {
                width: 50px;
                height: 50px;
            }
            .wws-product-query-btn__img img {
                width: 100%;
                height: 100%;
            }
            .wws-product-query-btn__text {
                margin-left: 10px;
                display: flex;
                flex-direction: column;
            }
            .wws-product-query-btn__text span {
                line-height: 20px;
                font-size: 15px;
            }
        </style>

        <?php 
            if ( wp_is_mobile() ) {
                $link =  "https://api.whatsapp.com/send?phone={$a['number']}&text={$a['message']}";
                $whatsapp_link = apply_filters( 'wws_product_query_mobile_link', $link, $a['number'], $a['message'] ); 
            } else {
                $link = "https://web.whatsapp.com/send?phone={$a['number']}&text={$a['message']}";
                $whatsapp_link = apply_filters( 'wws_product_query_desktop_link', $link, $a['number'], $a['message'] );
            } 
        ?>

        <a class="wws-product-query-btn" href="<?php echo esc_url( $whatsapp_link ) ?>" target="_blank" style="background-color: <?php echo esc_html( $a['bg-color'] ) ?>; color: <?php echo esc_html( $a['text-color'] ) ?>;">

        <?php if ( $a['image'] ) : ?>
            <span class='wws-product-query-btn__img' class=''>
            <img src='<?php echo esc_url( $a['image'] ) ?>' alt='wws'>
            </span>
        <?php endif; ?>

        <span class='wws-product-query-btn__text'>
        
        <?php if ( $a['name'] && $a['title'] ) : ?>
            <span><?php echo esc_html( $a['name'] ) ?> / <?php echo esc_html( $a['title'] ) ?></span>
        <?php elseif ( $a['name'] ) : ?>
            <span><?php echo esc_html( $a['name'] ) ?></span>
        <?php endif; ?>

        <span><strong><?php echo esc_html( $a['button-text'] ) ?></strong></span>
        </span>
        </a><br>

        <?php

        return ob_get_clean();

    }


} // end of class WWS_Product_Query

$wws_product_query = new WWS_Product_Query;