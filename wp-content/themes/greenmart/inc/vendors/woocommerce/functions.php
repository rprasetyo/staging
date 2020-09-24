<?php


// add to cart modal box 
if ( !function_exists('greenmart_tbay_woocommerce_add_to_cart_modal') ) {
    function greenmart_tbay_woocommerce_add_to_cart_modal(){
    ?>
    <div class="modal fade" id="tbay-cart-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close btn btn-close" data-dismiss="modal" aria-hidden="true">
                        <i class="fa fa-times"></i>
                    </button>
                    <div class="modal-body-content"></div>
                </div>
            </div>
        </div>
    </div>
    <?php    
    }
}

// cart modal
if ( !function_exists('greenmart_tbay_woocommerce_cart_modal') ) {
    function greenmart_tbay_woocommerce_cart_modal() {
        wc_get_template( 'content-product-cart-modal.php' , array( 'product_id' => (int)$_GET['product_id'] ) );
        die;
    }
}

add_action( 'wp_ajax_greenmart_add_to_cart_product', 'greenmart_tbay_woocommerce_cart_modal' );
add_action( 'wp_ajax_nopriv_greenmart_add_to_cart_product', 'greenmart_tbay_woocommerce_cart_modal' );
add_action( 'wp_footer', 'greenmart_tbay_woocommerce_add_to_cart_modal' );

if ( !function_exists('greenmart_tbay_get_woocommerce_mini_cart') ) {
    function greenmart_tbay_get_woocommerce_mini_cart($name = null) {
        $active_theme = greenmart_tbay_get_part_theme(); 
        if(is_null($name)) {
            get_template_part( 'woocommerce/cart/'.$active_theme.'/mini-cart-button' );
        } else {
            get_template_part( 'woocommerce/cart/'.$active_theme.'/mini-cart-button', $name);
        }
    }
}


/** Mini-Cart */

function woocommerce_mini_cart( $args = array() ) {
    $active_theme = greenmart_tbay_get_part_theme();
    $defaults = array(
        'list_class' => '',
    );

    $args = wp_parse_args( $args, $defaults );

    wc_get_template( 'cart/'.$active_theme.'/mini-cart.php', $args );
}

/*get category by id array*/
if ( !function_exists('greenmart_tbay_get_category_by_id') ) {
    function greenmart_tbay_get_category_by_id($categories_id = array()) {
        $categories = array(); 

        if( !is_array($categories_id)) return $categories;

        foreach ($categories_id as $key => $value) {
           $categories[$key] = get_term_by( 'id', $value, 'product_cat' )->slug;
        }

        return $categories;

    }
}

if ( !function_exists('greenmart_tbay_get_products') ) {
    function greenmart_tbay_get_products($categories = array(), $product_type = 'featured_product', $paged = 1, $post_per_page = -1, $orderby = '', $order = '') {
        global $woocommerce, $wp_query;
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => $post_per_page,
            'post_status' => 'publish',
            'paged' => $paged,
            'orderby'   => $orderby,
            'order' => $order
        );

        if ( isset( $args['orderby'] ) ) {
            if ( 'price' == $args['orderby'] ) {
                $args = array_merge( $args, array(
                    'meta_key'  => '_price',
                    'orderby'   => 'meta_value_num'
                ) );
            }
            if ( 'featured' == $args['orderby'] ) {
                $args = array_merge( $args, array(
                    'meta_key'  => '_featured',
                    'orderby'   => 'meta_value'
                ) );
            }
            if ( 'sku' == $args['orderby'] ) {
                $args = array_merge( $args, array(
                    'meta_key'  => '_sku',
                    'orderby'   => 'meta_value'
                ) );
            }
        }

        
        if ( !empty($categories) && is_array($categories) ) {
            $args['tax_query']    = array(
                array(
                    'taxonomy'      => 'product_cat',
                    'field'         => 'slug',
                    'terms'         =>  $categories,
                    'operator'      => 'IN'
                )
            );
        }

        switch ($product_type) {
            case 'best_selling':
                $args['meta_key']='total_sales';
                $args['orderby']='meta_value_num';
                $args['ignore_sticky_posts']   = 1;
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                break;
            case 'featured_product':
                $args['ignore_sticky_posts']=1;
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $args['tax_query'][]    = array(
                   array(
                        'taxonomy' => 'product_visibility',
                        'field'    => 'name',
                        'terms'    => 'featured',
                    )
                );
                $query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                break;
            case 'top_rate':
                $args['meta_key']       ='_wc_average_rating';
                $args['orderby']        ='meta_value_num';
                $args['order']          ='DESC';
                $args['meta_query']     = array();
                $args['meta_query'][]   = WC()->query->get_meta_query();
                $args['tax_query'][]     = WC()->query->get_tax_query();
                break;
            case 'recent_product':
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                break;
            case 'deals':
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                $args['meta_query'][] =  array(
                    array(
                        'key'           => '_sale_price_dates_to',
                        'value'         => time(),
                        'compare'       => '>',
                        'type'          => 'numeric'
                    )
                );
                break;
            case 'random':
                $args['orderby']    = 'rand';
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                break;        
            case 'on_sale':
                $product_ids_on_sale    = wc_get_product_ids_on_sale();
                $product_ids_on_sale[]  = 0;
                $args['post__in'] = $product_ids_on_sale;
                break;
        }

        if( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
            $args['meta_query'][] =  array(
                'relation' => 'AND',
                array(
                    'key' => '_stock_status',
                    'value' => 'instock',
                    'compare' => '=',
                )
            );
        }

        $args['tax_query'][] = array(
            'relation' => 'AND',
            array(
               'taxonomy' =>   'product_visibility',
                'field'    =>   'slug',
                'terms'    =>   array('exclude-from-search', 'exclude-from-catalog'),
                'operator' =>   'NOT IN',
            )
        );

        woocommerce_reset_loop();
        
        return new WP_Query($args);
    }
}

// hooks
if ( !function_exists('greenmart_tbay_woocommerce_enqueue_styles') ) {
    function greenmart_tbay_woocommerce_enqueue_styles() {
        
        $skin           = greenmart_tbay_get_theme();
        $suffix         = (greenmart_tbay_get_config('minified_js', false)) ? '.min' : GREENMART_MIN_JS;

        // Load our main stylesheet.
          if( is_rtl() ){
          
               if ( $skin != 'default' && $skin ) {
                    $css_path =  GREENMART_STYLES_SKINS . '/'.$skin.'/woocommerce.rtl.css';
               } else {
                    $css_path =  GREENMART_STYLES . '/woocommerce.rtl.css';
               }
          }
          else{
               if ( $skin != 'default' && $skin ) {
                    $css_path =  GREENMART_STYLES_SKINS . '/'.$skin.'/woocommerce.css';
               } else {
                    $css_path =  GREENMART_STYLES . '/woocommerce.css';
               }
          }
        
        wp_enqueue_style( 'greenmart-woocommerce', $css_path , 'greenmart-woocommerce-front' , GREENMART_THEME_VERSION, 'all' );

        wp_enqueue_script( 'slick', GREENMART_SCRIPTS . '/slick' . $suffix . '.js', array( 'jquery' ), '1.0.0', true );


    }
    add_action( 'wp_enqueue_scripts', 'greenmart_tbay_woocommerce_enqueue_styles', 50 );
}


/*Call funciton WCVariation Swatches  swallow2603*/
if( class_exists( 'TA_WC_Variation_Swatches' ) ) {
    function greenmart_get_swatch_html( $html, $args ) {
        $swatch_types = TA_WCVS()->types;
        $attr         = TA_WCVS()->get_tax_attribute( $args['attribute'] );

        // Return if this is normal attribute
        if ( empty( $attr ) ) {
            return $html;
        }

        if ( ! array_key_exists( $attr->attribute_type, $swatch_types ) ) {
            return $html;
        }

        $options   = $args['options'];
        $product   = $args['product'];
        $attribute = $args['attribute'];
        $class     = "variation-selector variation-select-{$attr->attribute_type}";
        $swatches  = '';

        if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
            $attributes = $product->get_variation_attributes();
            $options    = $attributes[$attribute];
        }

        if ( array_key_exists( $attr->attribute_type, $swatch_types ) ) {
            if ( ! empty( $options ) && $product && taxonomy_exists( $attribute ) ) {
                // Get terms if this is a taxonomy - ordered. We need the names too.
                $terms = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );

                foreach ( $terms as $term ) {
                    if ( in_array( $term->slug, $options ) ) {
                        $swatches .= apply_filters( 'tawcvs_swatch_html', '', $term, $attr, $args );
                    }
                }
            }

            if ( ! empty( $swatches ) ) {
                $class .= ' hidden';

                $swatches = '<div class="tawcvs-swatches" data-attribute_name="attribute_' . esc_attr( $attribute ) . '">' . $swatches . '</div>';
                $html     = '<div class="' . esc_attr( $class ) . '">' . $html . '</div>' . $swatches;
            }
        }

        return $html;
    }

    function greenmart_swatch_html( $html, $term, $attr, $args ) {
        $selected = sanitize_title( $args['selected'] ) == $term->slug ? 'selected' : '';
        $name     = esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) );

        switch ( $attr->attribute_type ) {
            case 'color':
                $color = get_term_meta( $term->term_id, 'color', true );
                list( $r, $g, $b ) = sscanf( $color, "#%02x%02x%02x" );
                $html = sprintf(
                    '<span class="swatch swatch-color swatch-%s %s" style="background-color:%s;color:%s;" title="%s" data-value="%s">%s</span>',
                    esc_attr( $term->slug ),
                    $selected,
                    esc_attr( $color ),
                    "rgba($r,$g,$b,0.5)",
                    esc_attr( $name ),
                    esc_attr( $term->slug ),
                    $name
                );
                break;

            case 'image':
                $image = get_term_meta( $term->term_id, 'image', true );
                $image = $image ? wp_get_attachment_image_src( $image ) : '';
                $image = $image ? $image[0] : WC()->plugin_url() . '/assets/images/placeholder.png';
                $html  = sprintf(
                    '<span class="swatch swatch-image swatch-%s %s" title="%s" data-value="%s"><img src="%s" alt="%s">%s</span>',
                    esc_attr( $term->slug ),
                    $selected,
                    esc_attr( $name ),
                    esc_attr( $term->slug ),
                    esc_url( $image ),
                    esc_attr( $name ),
                    esc_attr( $name )
                );
                break;

            case 'label':
                $label = get_term_meta( $term->term_id, 'label', true );
                $label = $label ? $label : $name;
                $html  = sprintf(
                    '<span class="swatch swatch-label swatch-%s %s" title="%s" data-value="%s">%s</span>',
                    esc_attr( $term->slug ),
                    $selected,
                    esc_attr( $name ),
                    esc_attr( $term->slug ),
                    esc_html( $label )
                );
                break;
        }

        return $html;
    }
}

// cart
if ( !function_exists('greenmart_tbay_woocommerce_header_add_to_cart_fragment') ) {
    function greenmart_tbay_woocommerce_header_add_to_cart_fragment( $fragments ){
        global $woocommerce;
         ob_start(); 
         
        $fragments['#cart .mini-cart-items'] =  sprintf(_n(' <span class=mini-cart-items> %d  </span> ', ' <span class="mini-cart-items"> %d </span> ', $woocommerce->cart->cart_contents_count, 'greenmart'), $woocommerce->cart->cart_contents_count);
        $fragments['#cart .mini-cart-subtotal'] = '<span class="mini-cart-subtotal">'.trim( $woocommerce->cart->get_cart_total() ).'<i class="'. greenmart_get_icon('icon_rounded') .'"></i></span>';
        return $fragments; 
    }
    add_filter('woocommerce_add_to_cart_fragments', 'greenmart_tbay_woocommerce_header_add_to_cart_fragment' );
}

// breadcrumb for woocommerce page
if ( !function_exists('greenmart_tbay_woocommerce_breadcrumb_defaults') ) {
    function greenmart_tbay_woocommerce_breadcrumb_defaults( $args ) {
        $breadcrumb_img = greenmart_tbay_get_config('woo_breadcrumb_image');
        $breadcrumb_color = greenmart_tbay_get_config('woo_breadcrumb_color');
        $style = array();
        $img = '';
        if( $breadcrumb_color  ){
            $style[] = 'background-color:'.$breadcrumb_color;
        }
        if ( isset($breadcrumb_img['url']) && !empty($breadcrumb_img['url']) ) {
            $img = '<img src=" '.esc_url($breadcrumb_img['url']).'">';
        }
        $estyle = !empty($style)? ' style="'.implode(";", $style).'"':"";

        $args['wrap_before'] = '<section id="tbay-breadscrumb" class="tbay-breadscrumb"><div class="container">'.$img.'<div class="breadscrumb-inner"'.$estyle.'><ol class="tbay-woocommerce-breadcrumb breadcrumb" ' . ( is_single() ? 'itemprop="breadcrumb"' : '' ) . '>';
        $args['wrap_after'] = '</ol></div></div></section>';

        return $args;
    }
}

add_action( 'init', 'greenmart_woo_remove_wc_breadcrumb' );
function greenmart_woo_remove_wc_breadcrumb() {
    if( !greenmart_tbay_get_config('show_product_breadcrumbs', true) ) {
        remove_action( 'greenmart_woo_template_main_before', 'woocommerce_breadcrumb', 30, 0 );
    } else {
        add_filter( 'woocommerce_breadcrumb_defaults', 'greenmart_tbay_woocommerce_breadcrumb_defaults' );
        add_action( 'greenmart_woo_template_main_before', 'woocommerce_breadcrumb', 30, 0 );    
    }
}

// display woocommerce modes
if ( !function_exists('greenmart_tbay_woocommerce_display_modes') ) {
    function greenmart_tbay_woocommerce_display_modes(){
        if ( ! wc_get_loop_prop( 'is_paginated' ) || ! woocommerce_products_will_display() ) {
            return;
        }

        global $wp;
        $current_url    = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
        $woo_mode       = greenmart_tbay_get_config('product_display_mode', 'grid');

        $class_grid     =  ($woo_mode == 'grid') ? 'active' : '';
        $class_list     =  ($woo_mode == 'list') ? 'active' : '';
        ?>
            <div class="display-mode-warpper display-mode">
                <a href="javascript:void(0);" id="display-mode-grid" class="change-view display-mode-btn <?php echo esc_attr( $class_grid ); ?>" title="'<?php esc_html_e('Grid','greenmart'); ?>'" ><i class="ti-layout-grid2"></i></a>            
                <a href="javascript:void(0);" id="display-mode-list" class="change-view display-mode-btn list <?php echo esc_attr( $class_list ); ?>" title="'<?php esc_html_e('List','greenmart'); ?>'" ><i class="ti-view-list"></i></a>
            </div> 
        <?php
    }
    add_action( 'woocommerce_before_shop_loop', 'greenmart_tbay_woocommerce_display_modes' , 2 );
}


if ( !function_exists('greenmart_tbay_woocommerce_get_display_mode') ) {
    function greenmart_tbay_woocommerce_get_display_mode() {
        $woo_mode = greenmart_tbay_get_config('product_display_mode', 'grid');

        if( isset($_GET['display_mode']) && $_GET['display_mode'] == 'gird' ) {
            $woo_mode = 'grid';
        } else if( isset($_GET['display_mode']) && $_GET['display_mode'] == 'list' ) {
            $woo_mode = 'list';
        }

        return $woo_mode;
    }
}


if(!function_exists('greenmart_tbay_filter_before')){
    function greenmart_tbay_filter_before(){
        if ( ! wc_get_loop_prop( 'is_paginated' ) || ! woocommerce_products_will_display() ) {
            return;
        }
        echo '<div class="tbay-filter">';
    }
}
if(!function_exists('greenmart_tbay_filter_after')){
    function greenmart_tbay_filter_after(){
        if ( ! wc_get_loop_prop( 'is_paginated' ) || ! woocommerce_products_will_display() ) {
            return;
        }
        echo '</div>';
    }
}
add_action( 'woocommerce_before_shop_loop', 'greenmart_tbay_filter_before' , 1 );
add_action( 'woocommerce_before_shop_loop', 'greenmart_tbay_filter_after' , 40 );

// set display mode to cookie
if ( !function_exists('greenmart_tbay_before_woocommerce_init') ) {
    function greenmart_tbay_before_woocommerce_init() {
        if( isset($_GET['display']) && ($_GET['display']=='list' || $_GET['display']=='grid') ){  
            setcookie( 'greenmart_woo_mode', trim($_GET['display']) , time()+3600*24*100,'/' );
            $_COOKIE['greenmart_woo_mode'] = trim($_GET['display']);
        }
    }
}
add_action( 'init', 'greenmart_tbay_before_woocommerce_init' );

// Number of products per page
if ( !function_exists('greenmart_tbay_woocommerce_shop_per_page') ) {
    function greenmart_tbay_woocommerce_shop_per_page($number) {
        $value = greenmart_tbay_get_config('number_products_per_page');
        if ( is_numeric( $value ) && $value ) {
            $number = absint( $value );
        }
        return $number;
    }
}
add_filter( 'loop_shop_per_page', 'greenmart_tbay_woocommerce_shop_per_page' );

// Number of products per row
if ( !function_exists('greenmart_tbay_woocommerce_shop_columns') ) {
    function greenmart_tbay_woocommerce_shop_columns($number) {
        $value = greenmart_tbay_get_config('product_columns');
        if ( in_array( $value, array(2, 3, 4, 6) ) ) {
            $number = $value;
        }
        return $number;
    }
}
add_filter( 'loop_shop_columns', 'greenmart_tbay_woocommerce_shop_columns' );

// share box
if ( !function_exists('greenmart_tbay_woocommerce_share_box') ) {
    function greenmart_tbay_woocommerce_share_box() {
        if ( greenmart_tbay_get_config('show_product_social_share') ) {
            ?>
              <div class="tbay-woo-share">
                <div class="addthis_inline_share_toolbox"></div>
              </div>
            <?php
        }
    }
    add_action( 'woocommerce_single_product_summary', 'greenmart_tbay_woocommerce_share_box', 100 );
}


// swap effect
if ( !function_exists('greenmart_tbay_swap_images') ) {
    function greenmart_tbay_swap_images() {
        global $post, $product, $woocommerce;
        $size = 'woocommerce_thumbnail';
        $placeholder = wc_get_image_size( $size );
        $placeholder_width = $placeholder['width']; 
        $placeholder_height = $placeholder['height'];
        $post_thumbnail_id =  $product->get_image_id();

        $output='';
        $class = 'image-no-effect';
        if (has_post_thumbnail()) {
            $attachment_ids = $product->get_gallery_image_ids();
            if ($attachment_ids && isset($attachment_ids[0])) {
                $class = 'image-hover';

                $output .= greenmart_tbay_get_attachment_image_loaded($attachment_ids[0], 'woocommerce_thumbnail', array('class' => 'attachment-shop_catalog image-effect' ));
            }

            $output .= greenmart_tbay_get_attachment_image_loaded($post_thumbnail_id, 'woocommerce_thumbnail', array('class' => $class ));
        } else {

            $output .= greenmart_tbay_src_image_loaded(wc_placeholder_img_src(), array('class' => $class));
        }
        echo trim($output); 
    }
}

if ( !wp_is_mobile() && greenmart_tbay_get_global_config('show_swap_image', false) ) {
    remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
    add_action('woocommerce_before_shop_loop_item_title', 'greenmart_tbay_swap_images', 10);
}  

// layout class for woo page
if ( !function_exists('greenmart_tbay_woocommerce_content_class') ) {
    function greenmart_tbay_woocommerce_content_class( $class ) {
        $page = 'archive';
        if ( is_singular( 'product' ) ) {
            $page = 'single';
        }
        if( greenmart_tbay_get_config('product_'.$page.'_fullwidth') ) {
            return 'container-fluid';
        }
        return $class;
    }
}
add_filter( 'greenmart_tbay_woocommerce_content_class', 'greenmart_tbay_woocommerce_content_class' );

// get layout configs
if ( !function_exists('greenmart_tbay_get_woocommerce_layout_configs') ) {
    function greenmart_tbay_get_woocommerce_layout_configs() {
        $page = 'archive';
        if ( is_singular( 'product' ) ) {
            $page = 'single';
        }
        $left = greenmart_tbay_get_config('product_'.$page.'_left_sidebar');
        $right = greenmart_tbay_get_config('product_'.$page.'_right_sidebar');

        if( isset($_GET['sidebar_product_position']) ) {
            switch ( $_GET['sidebar_product_position'] ) {
                case 'left':
                    $configs['left'] = array( 'sidebar' => $left, 'class' => 'col-xs-12 col-md-12 col-lg-3'  );
                    $configs['main'] = array( 'class' => 'col-xs-12 col-md-12 col-lg-9' );
                    break;
                case 'right':
                    $configs['right'] = array( 'sidebar' => $right,  'class' => 'col-xs-12 col-md-12 col-lg-3' ); 
                    $configs['main'] = array( 'class' => 'col-xs-12 col-md-12 col-lg-9' );
                    break;
                case 'full':
                    $configs['main'] = array( 'class' => 'col-xs-12 col-md-12' );
                    break;
                case 'left-right':
                    $configs['left'] = array( 'sidebar' => $left,  'class' => 'col-xs-12 col-md-12 col-lg-3'  );
                    $configs['right'] = array( 'sidebar' => $right, 'class' => 'col-xs-12 col-md-12 col-lg-3' ); 
                    $configs['main'] = array( 'class' => 'col-xs-12 col-md-12 col-lg-6' );
                    break;
                default:
                    $configs['main'] = array( 'class' => 'col-xs-12 col-md-12' );
                    break;
            }
        } else {
            switch ( greenmart_tbay_get_config('product_'.$page.'_layout') ) {
                case 'left-main':
                    $configs['left'] = array( 'sidebar' => $left, 'class' => 'col-xs-12 col-md-12 col-lg-3'  );
                    $configs['main'] = array( 'class' => 'col-xs-12 col-md-12 col-lg-9' );
                    break;
                case 'main-right':
                    $configs['right'] = array( 'sidebar' => $right,  'class' => 'col-xs-12 col-md-12 col-lg-3' ); 
                    $configs['main'] = array( 'class' => 'col-xs-12 col-md-12 col-lg-9' );
                    break;
                case 'main':
                    $configs['main'] = array( 'class' => 'col-xs-12 col-md-12' );
                    break;
                case 'left-main-right':
                    $configs['left'] = array( 'sidebar' => $left,  'class' => 'col-xs-12 col-md-12 col-lg-3'  );
                    $configs['right'] = array( 'sidebar' => $right, 'class' => 'col-xs-12 col-md-12 col-lg-3' ); 
                    $configs['main'] = array( 'class' => 'col-xs-12 col-md-12 col-lg-6' );
                    break;
                default:
                    $configs['main'] = array( 'class' => 'col-xs-12 col-md-12' );
                    break;
            }  
        }

        return $configs; 
    }
}

if ( !function_exists( 'greenmart_tbay_product_review_tab' ) ) {
    function greenmart_tbay_product_review_tab($tabs) {
        if ( !greenmart_tbay_get_config('show_product_review_tab') && isset($tabs['reviews']) ) {
            unset( $tabs['reviews'] ); 
        }
        return $tabs;
    }
    add_filter( 'woocommerce_product_tabs', 'greenmart_tbay_product_review_tab', 100 );
}


if ( !function_exists( 'greenmart_tbay_minicart') ) {
    function greenmart_tbay_minicart() {
        $template = apply_filters( 'greenmart_tbay_minicart_version', '' );
        get_template_part( 'woocommerce/cart/mini-cart-button', $template ); 
    }
}

if ( !function_exists( 'greenmart_tbay_woocomerce_icon_wishlist' ) ) {
    // Wishlist
    add_filter( 'yith_wcwl_button_label', 'greenmart_tbay_woocomerce_icon_wishlist'  );
    function greenmart_tbay_woocomerce_icon_wishlist( $value='' ){
        return '<i class="' . greenmart_get_icon('icon_wishlist') . '"></i><span>'.esc_html__('Wishlist','greenmart').'</span>';
    }

}

if ( !function_exists( 'greenmart_tbay_woocomerce_icon_wishlist_add' ) ) {
    add_filter( 'yith-wcwl-browse-wishlist-label', 'greenmart_tbay_woocomerce_icon_wishlist_add' );
    function greenmart_tbay_woocomerce_icon_wishlist_add(){
        return '<i class="' . greenmart_get_icon('icon_wishlist') .'"></i><span>'.esc_html__('Wishlist','greenmart').'</span>';
    }
}
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

if (class_exists('YITH_WCQV_Frontend')) {
    remove_action( 'woocommerce_after_shop_loop_item', array( YITH_WCQV_Frontend(), 'yith_add_quick_view_button' ), 15 );
}



if ( !function_exists( 'greenmart_product_description_heading' ) ) {
    //remove heading tab single product
    add_filter('woocommerce_product_description_heading',
'greenmart_product_description_heading');
    function greenmart_product_description_heading() {
        return '';
    }
}


// Ajax Wishlist
if( defined( 'YITH_WCWL' ) && ! function_exists( 'greenmart_yith_wcwl_ajax_update_count' ) ){
function greenmart_yith_wcwl_ajax_update_count(){

    $wishlist_count = YITH_WCWL()->count_products();

    wp_send_json( array(
    'count' => $wishlist_count
    ) );
    }
    add_action( 'wp_ajax_yith_wcwl_update_wishlist_count', 'greenmart_yith_wcwl_ajax_update_count' );
    add_action( 'wp_ajax_nopriv_yith_wcwl_update_wishlist_count', 'greenmart_yith_wcwl_ajax_update_count' );
}

//Count all product
if ( ! function_exists( 'greenmart_total_product_count' ) ) {
    function greenmart_total_product_count() {
        $args = array( 'post_type' => 'product', 'posts_per_page' => -1 );

        $products = new WP_Query( $args );

        return $products->found_posts;
    }
}

if ( ! function_exists( 'greenmart_woocommerce_saved_sales_price' ) ) {

    add_filter( 'woocommerce_get_saved_sales_price_html', 'greenmart_woocommerce_saved_sales_price' );

    function greenmart_woocommerce_saved_sales_price( $productid ) {

        $product = wc_get_product( $productid );

        
        $onsale         = $product->is_on_sale();
        $saleprice      = $product->get_sale_price();   
        $regularprice   = $product->get_regular_price();
        $priceDiff      = (int)$regularprice - (int)$saleprice;
        $price          = '';
        $price1         = '';

        $off_content    ='';
        if($priceDiff != 0){
            $price1 = '<span class="saved">'. esc_html__('Save you ', 'greenmart') .' <span class="price">'. sprintf( get_woocommerce_price_format(), get_woocommerce_currency_symbol(), $priceDiff ) . '</span></span>';     
            $price .= '<div class="block-save-price">'.$price1.'</div>'; 
        }
        
        // Sale price
        return $price;
        
    }
}

if( ! function_exists( 'greenmart_brands_get_name' ) && class_exists( 'YITH_WCBR' ) ) {

    function greenmart_brands_get_name($product_id) {

        $terms = wp_get_post_terms($product_id,'yith_product_brand');

        $brand = '';

        if( !empty($terms) ) {

            $brand  = '<ul class="show-brand">';

            foreach ($terms as $term) {
                
                $name = $term->name;
                $url = get_term_link( $term->slug, 'yith_product_brand' );

                $brand  .= '<li><a href='. esc_url($url) .'>'. esc_html($name) .'</a></li>';

            }

            $brand  .= '</ul>';
        }

        echo  trim($brand);

    }

}

if ( !function_exists('greenmart_find_matching_product_variation') ) {
    function greenmart_find_matching_product_variation( $product, $attributes ) {

        foreach( $attributes as $key => $value ) {
            if( strpos( $key, 'attribute_' ) === 0 ) {
                continue;
            }

            unset( $attributes[ $key ] );
            $attributes[ sprintf( 'attribute_%s', $key ) ] = $value;
        }

        if( class_exists('WC_Data_Store') ) {

            $data_store = WC_Data_Store::load( 'product' );
            return $data_store->find_matching_product_variation( $product, $attributes );

        } else {

            return $product->get_matching_variation( $attributes );

        }

    }
}

if ( ! function_exists( 'greenmart_get_default_attributes' ) ) {
    function greenmart_get_default_attributes( $product ) {

        if( method_exists( $product, 'get_default_attributes' ) ) {

            return $product->get_default_attributes();

        } else {

            return $product->get_variation_default_attributes();

        }

    }
}

if ( !function_exists('greenmart_find_matching_product_variation') ) {
    function greenmart_find_matching_product_variation( $product, $attributes ) {

        foreach( $attributes as $key => $value ) {
            if( strpos( $key, 'attribute_' ) === 0 ) {
                continue;
            }

            unset( $attributes[ $key ] );
            $attributes[ sprintf( 'attribute_%s', $key ) ] = $value;
        }

        if( class_exists('WC_Data_Store') ) {

            $data_store = WC_Data_Store::load( 'product' );
            return $data_store->find_matching_product_variation( $product, $attributes );

        } else {

            return $product->get_matching_variation( $attributes );

        }

    }
}


if ( ! function_exists( 'greenmart_woo_show_product_loop_sale_flash' ) ) {
    /*Change sales woo*/
    add_filter('woocommerce_sale_flash', 'greenmart_woo_show_product_loop_sale_flash', 10, 3);
    function greenmart_woo_show_product_loop_sale_flash( $original, $post, $product ) {
        global $product;

        if( empty($product) ) {
            return $html;
        }

        $priceDiff = 0;
        $percentDiff = 0;
        $regularPrice = ''; 
        $salePrice = $percentage = $return_content = '';

        $decimals   =  wc_get_price_decimals();
        $symbol   =  get_woocommerce_currency_symbol();

        $_product_sale   = $product->is_on_sale();
        $featured        = $product->is_featured();

        $format                 =  greenmart_tbay_get_config('sale_tags', 'custom');
        $enable_label_featured  =  greenmart_tbay_get_config('enable_label_featured', false);

        $active_theme = greenmart_tbay_get_theme();

        if($active_theme != 'flower') {
            $sale_default = '- {percent-diff}%';
        } else {
            $sale_default = '<span>'. esc_html__( 'Save', 'greenmart' ) .'</span>${price-diff}';
        }


        if ($format == 'custom') {
            $format = greenmart_tbay_get_config('sale_tag_custom', $sale_default);
        }


        if( $featured && $enable_label_featured) {
            $return_content  = '<span class="featured featured-saled">'. greenmart_tbay_get_config('custom_label_featured', esc_html__('Hot', 'greenmart')) .'</span>';
        }

        if( !empty($product) && $product->is_type( 'variable' ) ){


            $default_attributes = greenmart_get_default_attributes( $product );
            $variation_id = greenmart_find_matching_product_variation( $product, $default_attributes );

            if( !empty($variation_id) ) {
                $variation      = wc_get_product($variation_id);

                $_product_sale  = $variation->is_on_sale();

                $regularPrice   = get_post_meta($variation_id, '_regular_price', true);
                $salePrice      = get_post_meta($variation_id, '_price', true);   
            } else {
                $_product_sale = false;
            }

        } elseif( !empty($product) && $product->is_type( 'grouped' ) ) {
            $_product_sale = false;
        }  else {
            $salePrice = get_post_meta($product->get_id(), '_price', true);
            $regularPrice = get_post_meta($product->get_id(), '_regular_price', true);
        } 



        if (!empty($regularPrice) && !empty($salePrice ) && $regularPrice > $salePrice ) {
            $priceDiff = $regularPrice - $salePrice;
            $percentDiff = round($priceDiff / $regularPrice * 100);
            $parsed = str_replace('{price-diff}', number_format((float)$priceDiff, $decimals, '.', ''), $format);
            $parsed = str_replace('{symbol}', $symbol, $parsed);
            $parsed = str_replace('{percent-diff}', $percentDiff, $parsed);
            $percentage = '<span class="saled">'. $parsed .'</span>';
        }

        if( !empty($_product_sale ) && $_product_sale )  {
            $percentage .= $return_content;
        } else {
            $percentage = '<span class="saled">'. esc_html__( 'Sale', 'greenmart' ) . '</span>';
            $percentage .= $return_content;
        }



        return '<span class="onsale">'. $percentage. '</span>';
    }
}

if ( ! function_exists( 'greenmart_woo_only_feature_product' ) ) {
    /*Change sales woo*/
    add_action( 'woocommerce_before_shop_loop_item_title', 'greenmart_woo_only_feature_product', 10 );
    add_action( 'woocommerce_before_single_product_summary', 'greenmart_woo_only_feature_product', 10 );
    function greenmart_woo_only_feature_product() {

        global $product;

        $_product_sale   = $product->is_on_sale();

        $featured        = $product->is_featured();

        $return_content = '';
        if( $featured && !$_product_sale ) {

            $enable_label_featured  =  greenmart_tbay_get_config('enable_label_featured', false);

            if( $featured && $enable_label_featured ) {
                $return_content  .= '<span class="featured not-sale">'. greenmart_tbay_get_config('custom_label_featured', esc_html__('Hot', 'greenmart')) .'</span>';
            }  
            echo '<span class="onsale">'. $return_content. '</span>';
        }

    }
}

/*Custom signle product*/

if ( !function_exists('greenmart_tbay_woocommerce_tabs_style_product') ) {
    function greenmart_tbay_woocommerce_tabs_style_product($tabs_layout) {

        if ( is_singular( 'product' ) ) {
          $tabs_style       = greenmart_tbay_get_config('style_single_tabs_style','default');

          if ( isset($_GET['tabs_product']) ) {
              $tabs_layout = $_GET['tabs_product'];
          } else {
              $tabs_layout = $tabs_style;
          }  

          return $tabs_layout;
        }
    }
    add_filter( 'woo_tabs_style_single_product', 'greenmart_tbay_woocommerce_tabs_style_product' );
}

/**
* Function For Multi Layouts Single Product 
*/
//-----------------------------------------------------
/**
 * Output the product tabs.
 *
 * @subpackage  Product/Tabs
 */
if ( !function_exists('woocommerce_output_product_data_tabs') ) {
    function woocommerce_output_product_data_tabs() {
      $tabs_layout   =  apply_filters( 'woo_tabs_style_single_product', 10, 2 );

      if( isset($tabs_layout) ) {

        if( $tabs_layout == 'default') {
          wc_get_template( 'single-product/tabs/tabs.php' );
        } else {
          wc_get_template( 'single-product/tabs/tabs-'.$tabs_layout.'.php' );
        }
      }
  }
}

if ( !function_exists('woocommerce_product_data_tabs_action') ) {
    function woocommerce_product_data_tabs_action() {
      $tabs_layout   =  apply_filters( 'woo_tabs_style_single_product', 10, 2 );

      if( isset($tabs_layout) ) {

        if( $tabs_layout == 'default') {
            remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
            add_action( 'woocommerce_after_single_product_summary', 'greenmart_woo_output_product_description_tabs', 5 ); 

            add_action( 'woocommerce_after_single_product_summary', 'woocommerce_product_additional_information_tab', 5 ); 

            if ( greenmart_tbay_get_config('show_product_review_tab', true) ) {
                add_action( 'woocommerce_after_single_product_summary', 'comments_template', 25 ); 
            } 

            if( class_exists( 'WeDevs_Dokan' ) ) {
                add_action( 'woocommerce_after_single_product_summary', 'dokan_seller_product_tab', 5 ); 
            }

        }
      }
    }
    add_action('woocommerce_before_single_product', 'woocommerce_product_data_tabs_action');
}







if ( ! function_exists( 'greenmart_woo_output_product_description_tabs' ) ) {
    function greenmart_woo_output_product_description_tabs() { 
        wc_get_template( 'single-product/tabs/description.php' ); 
    } 

}



if ( ! function_exists( 'greenmart_woo_subtitle_field' ) ) {
    /* Subtitle Product */
    function greenmart_woo_subtitle_field() {

        woocommerce_wp_text_input( 
            array( 
                'id'          => '_subtitle', 
                'label'       => esc_html__( 'Subtitle', 'greenmart' ), 
                'placeholder' => esc_html__( 'Subtitle....', 'greenmart' ),
                'description' => esc_html__( 'Enter the subtitle.', 'greenmart' ) 
            )
        );

    }
	add_action( 'woocommerce_product_options_general_product_data', 'greenmart_woo_subtitle_field' );
    
}

if ( ! function_exists( 'greenmart_woo_subtitle_field_save' ) ) {
    function greenmart_woo_subtitle_field_save( $post_id ){  

        $subtitle = $_POST['_subtitle'];
        if( !empty( $subtitle ) )
            update_post_meta( $post_id, '_subtitle', esc_attr( $subtitle ) );

    }
	add_action( 'woocommerce_process_product_meta', 'greenmart_woo_subtitle_field_save' );
}

if ( ! function_exists( 'greenmart_woo_get_subtitle' ) ) {
    function greenmart_woo_get_subtitle( ) {

        global $post;

        $_subtitle = get_post_meta( $post->ID, '_subtitle', true );

        if(!($_subtitle == null || $_subtitle == '')){
            echo '<div class="tbay-subtitle">'. get_post_meta( $post->ID, '_subtitle', true ) .'</div>';
        }

    }

    add_action( 'greenmart_after_title_tbay_subtitle', 'greenmart_woo_get_subtitle', 0);
}

/* ---------------------------------------------------------------------------
 * WooCommerce - Function get Query
 * --------------------------------------------------------------------------- */
 if ( ! function_exists( 'greenmart_woo_get_review_counting' ) ) {
    /* Fix ajax count cart */
    function greenmart_woo_get_review_counting(){

        global $post; 
        $output = array();

        for($i=1; $i <= 5; $i++){
             $args = array(
                'post_id'      => ( $post->ID ),
                'meta_query' => array(
                  array(
                    'key'   => 'rating',
                    'value' => $i
                  )
                ),      
                'count' => true
            );
            $output[$i] = get_comments( $args );
        }
        return $output;
    }
}
add_filter( 'woocommerce_add_to_cart_fragments', function($fragments) {

    ob_start();
    ?>

    <span class="mini-cart-items-fixed">
        <?php echo WC()->cart->get_cart_contents_count(); ?>
    </span>

    <?php $fragments['span.mini-cart-items-fixed'] = ob_get_clean();

    return $fragments;

} );

add_filter( 'woocommerce_add_to_cart_fragments', function($fragments) { 
    ob_start();
    global $woocommerce; 
    ?>

    <span class="sub-title-2">
        <?php echo esc_html__('My Cart ', 'greenmart'); ?> (<?php printf( __( '%s item', 'greenmart' ), WC()->cart->cart_contents_count );?>)
    </span>

    <?php $fragments['span.sub-title-2'] = ob_get_clean();

    return $fragments;

} );

add_filter( 'woocommerce_add_to_cart_fragments', function($fragments) {
    ob_start();
    ?>

    <span class="mini-cart-items cart-mobile">
        <?php echo sprintf( '%d', WC()->cart->cart_contents_count );?>
    </span>

    <?php $fragments['span.cart-mobile'] = ob_get_clean();

    return $fragments;

} );

 if ( ! function_exists( 'greenmart_ajax_product_remove' ) ) {
    // Remove product in the cart using ajax
    function greenmart_ajax_product_remove()
    {
        // Get mini cart
        ob_start();

        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item)
        {
            if($cart_item['product_id'] == $_POST['product_id'] && $cart_item_key == $_POST['cart_item_key'] )
            {
                WC()->cart->remove_cart_item($cart_item_key);
            }
        }

        WC()->cart->calculate_totals();
        WC()->cart->maybe_set_cart_cookies();

        woocommerce_mini_cart();

        $mini_cart = ob_get_clean();

        // Fragments and mini cart are returned
        $data = array(
            'fragments' => apply_filters( 'woocommerce_add_to_cart_fragments', array(
                    'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>'
                )
            ),
            'cart_hash' => apply_filters( 'woocommerce_add_to_cart_hash', WC()->cart->get_cart_for_session() ? md5( json_encode( WC()->cart->get_cart_for_session() ) ) : '', WC()->cart->get_cart_for_session() )
        );

        wp_send_json( $data );
		
        die();
    }

    add_action( 'wp_ajax_product_remove', 'greenmart_ajax_product_remove' );
    add_action( 'wp_ajax_nopriv_product_remove', 'greenmart_ajax_product_remove' );
}



/*Add video to product detail*/
if ( !function_exists('greenmart_tbay_woocommerce_add_video_field') ) {
  add_action( 'woocommerce_product_options_general_product_data', 'greenmart_tbay_woocommerce_add_video_field' );

  function greenmart_tbay_woocommerce_add_video_field(){

    $args = apply_filters( 'greenmart_tbay_woocommerce_simple_url_video_args', array(
        'id' => '_video_url',
        'label' => esc_html__('Featured Video URL', 'greenmart'),
        'placeholder' => esc_html__('Video URL', 'greenmart'),
        'desc_tip' => true,
        'description' => esc_html__('Enter the video url at https://vimeo.com/ or https://www.youtube.com/', 'greenmart'))
    );

    echo '<div class="options_group">';

    woocommerce_wp_text_input( $args ) ;

    echo '</div>';
  }
}

if ( !function_exists('greenmart_tbay_save_video_url') ) {
  add_action( 'woocommerce_process_product_meta', 'greenmart_tbay_save_video_url', 10, 2 );
  function greenmart_tbay_save_video_url( $post_id, $post ) {
      if ( isset( $_POST['_video_url'] ) ) {
          update_post_meta( $post_id, '_video_url', esc_attr( $_POST['_video_url'] ) );
      }
  }
}

if ( !function_exists('greenmart_tbay_VideoUrlType') ) {
  function greenmart_tbay_VideoUrlType($url) {


      $yt_rx = '/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/';
      $has_match_youtube = preg_match($yt_rx, $url, $yt_matches);


      $vm_rx = '/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/';
      $has_match_vimeo = preg_match($vm_rx, $url, $vm_matches);


      //Then we want the video id which is:
      if($has_match_youtube) {
          $video_id = $yt_matches[5]; 
          $type = 'youtube';
      }
      elseif($has_match_vimeo) {
          $video_id = $vm_matches[5];
          $type = 'vimeo';
      }
      else {
          $video_id = 0;
          $type = 'none';
      }


      $data['video_id'] = $video_id;
      $data['video_type'] = $type;

      return $data;
  }
}

if ( !function_exists('greenmart_tbay_get_video_product') ) {
  add_action( 'tbay_product_video', 'greenmart_tbay_get_video_product', 10 );
  function  greenmart_tbay_get_video_product() {
    global $post, $product;


    if( get_post_meta( $post->ID, '_video_url', true ) ) {
      $video = greenmart_tbay_VideoUrlType(get_post_meta( $post->ID, '_video_url', true ));

      if( $video['video_type'] == 'youtube' ) {
        $url  = 'https://www.youtube.com/embed/'.$video['video_id'].'?autoplay=1';
        $icon = '<i class="fa fa-youtube-play" aria-hidden="true"></i>'.esc_html__('View Video','greenmart');

      }elseif(( $video['video_type'] == 'vimeo' )) {
        $url = 'https://player.vimeo.com/video/'.$video['video_id'].'?autoplay=1';
        $icon = '<i class="fa fa-vimeo-square" aria-hidden="true"></i>'.esc_html__('View Video','greenmart');

      }

    }

    ?>

    <?php if( !empty($url) ) : ?>

      <div class="modal fade" id="productvideo">
        <div class="modal-dialog">
          <div class="modal-content tbay-modalContent">

            <div class="modal-body">
              
              <div class="close-button">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item"></iframe>
              </div>
            </div>

          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

      <button type="button" class="tbay-modalButton" data-toggle="modal" data-tbaySrc="<?php echo esc_attr($url); ?>" data-tbayWidth="640" data-tbayHeight="480" data-target="#productvideo"  data-tbayVideoFullscreen="true"><?php echo trim($icon); ?></button>

    <?php endif; ?>
  <?php
  }
}


/*product nav*/
if ( !function_exists('greenmart_render_product_nav') ) {
  function greenmart_render_product_nav($post, $position){
      if($post){
          $product = wc_get_product($post->ID);
          $img = '';
          if(has_post_thumbnail($post)){
              $img = get_the_post_thumbnail($post, 'woocommerce_gallery_thumbnail');
          }

          $img_left = ($position == 'left')? trim($img) : '';
          $img_right = ($position == 'right') ? $img:'';

          $link = get_permalink($post);
          echo "<div class='{$position} psnav'>";
          echo "<a class='img-link' href=\"{$link}\">";
           echo trim($img_left);   
          echo "</a>"; 
          echo "  <div class='product_single_nav_inner single_nav'>
                      <a href=\"{$link}\">
                          <span class='name-pr'>{$post->post_title}</span>
                      </a>
                  </div>";
          echo "<a class='img-link' href=\"{$link}\">";        
            echo trim($img_right);
          echo "</a>"; 
          echo "</div>";
      }
  }
}

if ( !function_exists('greenmart_woo_product_nav') ) {
  function greenmart_woo_product_nav(){
        if ( greenmart_tbay_get_config('show_product_nav', false) ) {
            $prev = get_previous_post();
            $next = get_next_post();

            echo '<div class="product-nav pull-right">';  
            echo '<div class="link-images visible-lg">';
            greenmart_render_product_nav($prev, 'left');
            greenmart_render_product_nav($next, 'right');
            echo '</div>';

            echo '</div>';
        }
  }
  add_action( 'woocommerce_before_single_product', 'greenmart_woo_product_nav', 1 );
}

// catalog mode

if ( !function_exists('greenmart_tbay_woocommerce_catalog_mode_active') ) {
    function greenmart_tbay_woocommerce_catalog_mode_active($active) {
        $active = greenmart_tbay_get_config('enable_woocommerce_catalog_mode', false);

        $active = (isset($_GET['catalog_mode'])) ? $_GET['catalog_mode'] : $active;

        return $active;
    }
}
add_filter( 'greenmart_catalog_mode', 'greenmart_tbay_woocommerce_catalog_mode_active' );

if ( !function_exists('greenmart_woocommerce_catalog_mode_active') ) {
    function greenmart_woocommerce_catalog_mode_active() {
        $active = apply_filters( 'greenmart_catalog_mode', 10,2 );
        if( isset($active) && $active ) {  
          define( 'GREENMART_WOOCOMMERCE_CATALOG_MODE_ACTIVED', true );
        }
    }

    add_action( 'init', 'greenmart_woocommerce_catalog_mode_active' );
}

// class catalog mode
if ( ! function_exists( 'greenmart_tbay_body_classes_woocommerce_catalog_mod' ) ) {
    function greenmart_tbay_body_classes_woocommerce_catalog_mod( $classes ) {
        $class = '';
        $active = apply_filters( 'greenmart_catalog_mode', 10,2 );
        if( isset($active) && $active ) {  
            $class = 'tbay-body-woocommerce-catalog-mod';
        }

        $classes[] = trim($class);

        return $classes;
    }
    add_filter( 'body_class', 'greenmart_tbay_body_classes_woocommerce_catalog_mod' );
}


if ( !function_exists('greenmart_woocommerce_catalog_mode') ) {
    function greenmart_woocommerce_catalog_mode() {
        $active = apply_filters( 'greenmart_catalog_mode', 10,2 );
        if( isset($active) && $active ) {  
           
            remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
            remove_action('woocommerce_add_to_cart_validation', 'avoid_add_to_cart',  10, 2 );       

            if ( defined( 'YITH_WCQV' ) && YITH_WCQV ) {
                remove_action( 'yith_wcqv_product_summary', 'woocommerce_template_single_add_to_cart', 25 );
            }
        }

    }

    add_action( 'init', 'greenmart_woocommerce_catalog_mode' );
}

// cart modal
if ( !function_exists('greenmart_woocommerce_catalog_mode_redirect_page') ) {
    function greenmart_woocommerce_catalog_mode_redirect_page() {
        $active = apply_filters( 'greenmart_catalog_mode', 10,2 );
        if( isset($active) && $active ) {  
           
            $cart     = is_page( wc_get_page_id( 'cart' ) );
            $checkout = is_page( wc_get_page_id( 'checkout' ) );

            wp_reset_query();

            if ( $cart || $checkout ) {

                wp_redirect( home_url() );
                exit;

            }
        }

    }

    add_action( 'wp', 'greenmart_woocommerce_catalog_mode_redirect_page' );
}
/*End catalog mode*/

/*Greenmart compare styles*/
if( ! function_exists( 'greenmart_compare_styles' ) ) {
    add_action( 'wp_print_styles', 'greenmart_compare_styles', 200 );
    function greenmart_compare_styles() {
        if( ! class_exists( 'YITH_Woocompare' ) ) return;
        $view_action = 'yith-woocompare-view-table';
        if ( ( ! defined('DOING_AJAX') || ! DOING_AJAX ) && ( ! isset( $_REQUEST['action'] ) || $_REQUEST['action'] != $view_action ) ) return;
        wp_enqueue_style( 'font-awesome' );
        wp_enqueue_style( 'simple-line-icons' );
        wp_enqueue_style( 'greenmart-woocommerce' );
    }
}


if ( !function_exists('greenmart_tbay_woocommerce_search_category') ) {
    function greenmart_tbay_woocommerce_search_category($active) {
        $active = greenmart_tbay_get_config('search_category', false);

        $active = (isset($_GET['search_category'])) ? $_GET['search_category'] : $active;

        return $active;
    }
} 
add_filter( 'greenmart_woo_search_category', 'greenmart_tbay_woocommerce_search_category' );

// class hide sub title product
if ( !function_exists('greenmart_tbay_woocommerce_hide_sub_title') ) {
    function greenmart_tbay_woocommerce_hide_sub_title($active) {
        $active = greenmart_tbay_get_config('enable_hide_sub_title_product', false);

        $active = (isset($_GET['hide_sub_title'])) ? $_GET['hide_sub_title'] : $active;

        return $active;
    }
}
add_filter( 'greenmart_hide_sub_title', 'greenmart_tbay_woocommerce_hide_sub_title' );

if ( ! function_exists( 'greenmart_tbay_body_classes_woocommerce_hide_sub_title' ) ) {
    function greenmart_tbay_body_classes_woocommerce_hide_sub_title( $classes ) {
        $class = '';
        $active = apply_filters( 'greenmart_hide_sub_title', 10,2 );
        if( isset($active) && $active ) {  
            $class = 'tbay-body-hide-sub-title';
        }

        $classes[] = trim($class);

        return $classes;
    }
    add_filter( 'body_class', 'greenmart_tbay_body_classes_woocommerce_hide_sub_title' );
}


/*Show Add to Cart on mobile*/
if ( !function_exists('greenmart_tbay_woocommerce_show_cart_mobile') ) {
    function greenmart_tbay_woocommerce_show_cart_mobile($active) {
        $active = greenmart_tbay_get_config('enable_add_cart_mobile', false);

        $active = (isset($_GET['add_cart_mobile'])) ? $_GET['add_cart_mobile'] : $active;

        return $active;
    }
}
add_filter( 'greenmart_show_cart_mobile', 'greenmart_tbay_woocommerce_show_cart_mobile' );


if ( ! function_exists( 'greenmart_tbay_body_classes_woocommerce_show_cart_mobile' ) ) {
    function greenmart_tbay_body_classes_woocommerce_show_cart_mobile( $classes ) {
        $class = '';
        $active = apply_filters( 'greenmart_show_cart_mobile', 10,2 );
        if( isset($active) && $active ) {  
            $class = 'tbay-show-cart-mobile';
        }

        $classes[] = trim($class);

        return $classes;
    }
    add_filter( 'body_class', 'greenmart_tbay_body_classes_woocommerce_show_cart_mobile' );
}


/*Show Add to Cart on mobile*/
if ( !function_exists('greenmart_tbay_woocommerce_disable_ajax_popup_cart') ) {
    function greenmart_tbay_woocommerce_disable_ajax_popup_cart($active) {
        $active = greenmart_tbay_get_config('disable_ajax_popup_cart', false);

        $active = (isset($_GET['disable_ajax_popup_cart'])) ? $_GET['disable_ajax_popup_cart'] : $active;

        return $active;
    }
}
add_filter( 'greenmart_disable_ajax_popup_cart', 'greenmart_tbay_woocommerce_disable_ajax_popup_cart' );


if ( ! function_exists( 'greenmart_tbay_body_classes_disable_ajax_popup_cart' ) ) {
    function greenmart_tbay_body_classes_disable_ajax_popup_cart( $classes ) {
        $class = '';
        $active = apply_filters( 'greenmart_disable_ajax_popup_cart', 10,2 );
        if( isset($active) && $active ) {  
            $class = 'tbay-disable-ajax-popup-cart';
        }

        $classes[] = trim($class);

        return $classes;
    }
    add_filter( 'body_class', 'greenmart_tbay_body_classes_disable_ajax_popup_cart' );
}


/*Disable Add To Cart Fixed on mobile*/
if ( !function_exists('greenmart_tbay_woocommerce_disable_add_cart_fixed') ) {
    function greenmart_tbay_woocommerce_disable_add_cart_fixed($active) {
        $active = greenmart_tbay_get_config('disable_add_cart_fixed', false);

        $active = (isset($_GET['disable_add_cart_fixed'])) ? $_GET['disable_add_cart_fixed'] : $active;

        return $active;
    }
}
add_filter( 'greenmart_disable_add_cart_fixed', 'greenmart_tbay_woocommerce_disable_add_cart_fixed' );

if ( ! function_exists( 'greenmart_tbay_body_classes_woocommerce_disable_add_cart_fixed' ) ) {
    function greenmart_tbay_body_classes_woocommerce_disable_add_cart_fixed( $classes ) {
        $class = '';
        $active = apply_filters( 'greenmart_disable_add_cart_fixed', 10,2 );
        if( isset($active) && $active ) {  
            $class = 'tbay-disable-cart-fixed';
        }

        $classes[] = trim($class);

        return $classes;
    }
    add_filter( 'body_class', 'greenmart_tbay_body_classes_woocommerce_disable_add_cart_fixed' );
}

/*Show Quantity on mobile*/
if ( !function_exists('greenmart_tbay_woocommerce_show_quantity_mobile') ) {
    function greenmart_tbay_woocommerce_show_quantity_mobile($active) {
        $active = greenmart_tbay_get_config('enable_quantity_mobile', false);

        $active = (isset($_GET['quantity_mobile'])) ? $_GET['quantity_mobile'] : $active;

        return $active;
    }
}
add_filter( 'greenmart_show_quantity_mobile', 'greenmart_tbay_woocommerce_show_quantity_mobile' );

if ( ! function_exists( 'greenmart_tbay_body_classes_woocommerce_show_quantity_mobile' ) ) {
    function greenmart_tbay_body_classes_woocommerce_show_quantity_mobile( $classes ) {
        $class = '';
        $active = apply_filters( 'greenmart_show_quantity_mobile', 10,2 );
        if( isset($active) && $active ) {  
            $class = 'tbay-show-quantity-mobile';
        }

        $classes[] = trim($class);

        return $classes;
    }
    add_filter( 'body_class', 'greenmart_tbay_body_classes_woocommerce_show_quantity_mobile' );
}

if ( ! function_exists( 'greenmart_woo_show_product_loop_outstock_flash' ) ) {
    /*Change Out of Stock woo*/
    add_filter( 'woocommerce_before_shop_loop_item_title', 'greenmart_woo_show_product_loop_outstock_flash' ,15 );
    function greenmart_woo_show_product_loop_outstock_flash( $html ) {
  
        global $product;

        if( !empty($product) ) {
            
            $return_content = '';
            $availability   = $product->get_availability();
            

            if ( $availability['availability'] == 'Out of stock') {
               $return_content .= '<span class="out-stock">'. esc_html__('Out of stock', 'greenmart') .'</span>';
            }

            echo trim($return_content);
        } else {
            echo trim($html);
        }

        
    }
}

/*product time countdown*/
if(!function_exists('greenmart_woo_product_single_time_countdown')){

    add_action( 'woocommerce_single_product_summary', 'greenmart_woo_product_single_time_countdown', 25 );

    function greenmart_woo_product_single_time_countdown() {

        global $product;

        $style_countdown   = greenmart_tbay_get_config('show_product_countdown',false);

        if ( isset($_GET['countdown']) ) {
            $countdown = $_GET['countdown'];
        }else {
            $countdown = $style_countdown;
        }  

        if(!$countdown || !$product->is_on_sale() ) {
          return '';
        }

        global $product;
        wp_enqueue_script( 'jquery-countdowntimer' );
        $time_sale = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
        ?>
        <?php if ( $time_sale ): ?>
          <div class="time tbay-single-time">
                <div class="tbay-countdown" data-time="timmer" data-days="<?php esc_html_e('Days','greenmart'); ?>" data-hours="<?php esc_html_e('Hours','greenmart'); ?>"  data-mins="<?php esc_html_e('Mins','greenmart'); ?>" data-secs="<?php esc_html_e('Secs','greenmart'); ?>"
                   data-date="<?php echo date('m', $time_sale).'-'.date('d', $time_sale).'-'.date('Y', $time_sale).'-'. date('H', $time_sale) . '-' . date('i', $time_sale) . '-' .  date('s', $time_sale) ; ?>">
              </div>
          </div> 
        <?php endif; ?> 
        <?php
    }
}

if ( ! function_exists( 'greenmart_tbay_get_title_mobile' ) ) {
    function greenmart_tbay_get_title_mobile( $title = '') {

        if ( is_product_category() || is_category() ) {
            $title = single_cat_title();
        }  else if ( is_search() ) {
            $title   = sprintf( esc_html__( 'Search results for "%s"', 'greenmart' ), get_search_query() );
        } else if ( is_tag() ) {
            $title   = sprintf( esc_html__( 'Posts tagged "%s"', 'greenmart' ), single_tag_title('', false) );
        }else if ( is_product_tag() ) {
            $title   = sprintf( esc_html__( 'Products tagged "%s"', 'greenmart' ), single_tag_title('', false) );
        } else if ( is_author() ) {
            global $author;
            $userdata = get_userdata($author);
            $title = esc_html__('Articles posted by ', 'greenmart') . $userdata->display_name;
        } else if ( is_404() ) {
            $title = esc_html__('Error 404', 'greenmart');
        } else if( is_shop () ) {
            $title = esc_html__('shop','greenmart');
        } else {
            $title = get_the_title();
        }

        return $title;
    }
    add_filter( 'greenmart_get_filter_title_mobile', 'greenmart_tbay_get_title_mobile' );
}

//Enqueue Ajax Scripts
function greenmart_tbay_enqueue_cart_qty_ajax() {
    $suffix         = (greenmart_tbay_get_config('minified_js', false)) ? '.min' : GREENMART_MIN_JS;
    wp_register_script( 'cart-qty-ajax-js', GREENMART_SCRIPTS . '/cart-qty-ajax' . $suffix . '.js', array( 'jquery' ), '', true );
    wp_localize_script( 'cart-qty-ajax-js', 'cart_qty_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    wp_enqueue_script( 'cart-qty-ajax-js' );

}
add_action('wp_enqueue_scripts', 'greenmart_tbay_enqueue_cart_qty_ajax');

function greenmart_tbay_ajax_qty_cart() {

    // Set item key as the hash found in input.qty's name
    $cart_item_key = $_POST['hash'];

    // Get the array of values owned by the product we're updating
    $threeball_product_values = WC()->cart->get_cart_item( $cart_item_key );

    // Get the quantity of the item in the cart
    $threeball_product_quantity = apply_filters( 'woocommerce_stock_amount_cart_item', apply_filters( 'woocommerce_stock_amount', preg_replace( "/[^0-9\.]/", '', filter_var($_POST['quantity'], FILTER_SANITIZE_NUMBER_INT)) ), $cart_item_key );

    // Update cart validation
    $passed_validation  = apply_filters( 'woocommerce_update_cart_validation', true, $cart_item_key, $threeball_product_values, $threeball_product_quantity );

    // Update the quantity of the item in the cart
    if ( $passed_validation ) {
        WC()->cart->set_quantity( $cart_item_key, $threeball_product_quantity, true );
    }

    die();

}

add_action('wp_ajax_tbay_qty_cart', 'greenmart_tbay_ajax_qty_cart');
add_action('wp_ajax_nopriv_tbay_qty_cart', 'greenmart_tbay_ajax_qty_cart');

/**
 * Remove password strength check.
 */
if ( ! function_exists( 'greenmart_tbay_remove_password_strength' ) ) {
    function greenmart_tbay_remove_password_strength() {
        $active = greenmart_tbay_get_config('disable_woocommerce_password_strength', false);

        if( isset($active) && $active ) {
            wp_dequeue_script( 'wc-password-strength-meter' );
        }
    }
    add_action( 'wp_print_scripts', 'greenmart_tbay_remove_password_strength', 10 );
}

// Quantity mode

if ( !function_exists('greenmart_tbay_woocommerce_quantity_mode_active') ) {
    function greenmart_tbay_woocommerce_quantity_mode_active($active) {
        $active = greenmart_tbay_get_config('enable_woocommerce_quantity_mode', false);

        $active = (isset($_GET['quantity_mode'])) ? $_GET['quantity_mode'] : $active;

        return $active;
    }
}
add_filter( 'greenmart_quantity_mode', 'greenmart_tbay_woocommerce_quantity_mode_active' );

// class catalog mode
if ( ! function_exists( 'greenmart_tbay_body_classes_woocommerce_quantity_mod' ) ) {
    function greenmart_tbay_body_classes_woocommerce_quantity_mod( $classes ) {
        $class = '';
        $active = apply_filters( 'greenmart_quantity_mode', 10,2 );
        if( isset($active) && $active ) {  
            $class = 'tbay-body-woocommerce-quantity-mod';
        }

        $classes[] = trim($class);

        return $classes;
    }
    add_filter( 'body_class', 'greenmart_tbay_body_classes_woocommerce_quantity_mod' );
}

if ( !function_exists('greenmart_woocommerce_quantity_mode') ) {
    function greenmart_woocommerce_quantity_mode() {
        $active = apply_filters( 'greenmart_quantity_mode', 10,2 );
        if( isset($active) && $active ) {  
            add_action( 'woocommerce_after_shop_loop_item', 'greenmart_tbay_qquantity_field_archive', 5);
        }

    }

    add_action( 'init', 'greenmart_woocommerce_quantity_mode' );
}

if ( ! function_exists( 'greenmart_tbay_qquantity_field_archive' ) ) {
    function greenmart_tbay_qquantity_field_archive( ) {

        global $product;
        if ( $product && $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() && ! $product->is_sold_individually() ) {
            woocommerce_quantity_input( array( 'min_value' => 1, 'max_value' => $product->backorders_allowed() ? '' : $product->get_stock_quantity() ) );
        }

    }
}

if ( ! function_exists( 'greenmart_class_product' ) ) {
    function greenmart_class_product( ) {
        global $product;

        $output = '';
        if( !empty($product->get_parent_id()) ) {
            $output .= ' variable-child';
        }

        echo trim($output); 
    }

}

/**
 * Display category image on category archive
 */
if ( ! function_exists( 'greenmart_woocommerce_archive_description' ) ) {
add_action( 'greenmart_archive_image', 'greenmart_woocommerce_archive_description', 2 );
    function greenmart_woocommerce_archive_description() {
        if ( is_product_category() ){
            global $wp_query;
            $cat = $wp_query->get_queried_object();
            $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
            $image = wp_get_attachment_url( $thumbnail_id );
            if ( $image ) {
                echo '<img src="' . esc_url($image) . '" alt="' . esc_attr($cat->name) . '" />';
            }
        }
    }
}


if ( ! function_exists( 'greenmart_woocommerce_sub_categories' ) ) {

    /**
     * Output the start of a product loop. By default this is a UL.
     *
     * @param bool $echo Should echo?.
     * @return string
     */
    function greenmart_woocommerce_sub_categories( $echo = true ) {
        ob_start();

        wc_set_loop_prop( 'loop', 0 );
        
        $loop_start = apply_filters( 'greenmart_woocommerce_sub_categories', ob_get_clean() );

        if ( $echo ) {
            echo trim($loop_start); // WPCS: XSS ok.
        } else {
            return $loop_start;
        }
    }
}
add_filter( 'greenmart_woocommerce_sub_categories', 'woocommerce_maybe_show_product_subcategories' );

if ( ! function_exists( 'greenmart_woocommerce_output_related_products_args' ) ) {
    // define the woocommerce_output_related_products_args callback 
    function greenmart_woocommerce_output_related_products_args( $args ) { 
        $args['posts_per_page'] = greenmart_tbay_get_config('number_product_releated', 4);
        
        return $args; 
    }; 
             
    // add the filter 
    add_filter( 'woocommerce_output_related_products_args', 'greenmart_woocommerce_output_related_products_args', 10, 1 ); 
}

if ( ! function_exists( 'greenmart_woocommerce_ywfbt_single_product' ) ) {
    // define the woocommerce_output_related_products_args callback 
    function greenmart_woocommerce_ywfbt_single_product( ) { 

        if( defined('YITH_WFBT') && YITH_WFBT ) {
            ?>

            <div class="tbay-ywfbt-wrapper">

                <div class="container">
                    <?php 
                        global $product;
                        $id = $product->get_id();
                        echo do_shortcode( '[ywfbt_form product_id="'. $id .'"]' );
                    ?>
                </div>

            </div>

            <?php

        }
    }; 
             
    // add the filter 
    add_action( 'greenmart_woo_after_single_product_summary_before', 'greenmart_woocommerce_ywfbt_single_product', 10 ); 
}

if ( ! function_exists( 'greenmart_woocommerce_single_ajax_add_to_cart' ) ) {
    add_action('wp_ajax_woocommerce_ajax_add_to_cart', 'greenmart_woocommerce_single_ajax_add_to_cart');
    add_action('wp_ajax_nopriv_woocommerce_ajax_add_to_cart', 'greenmart_woocommerce_single_ajax_add_to_cart');
            
    function greenmart_woocommerce_single_ajax_add_to_cart() {

        $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
        $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
        $variation_id = absint($_POST['variation_id']);
        $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
        $product_status = get_post_status($product_id);

        if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) {

            do_action('woocommerce_ajax_added_to_cart', $product_id);

            if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
                wc_add_to_cart_message(array($product_id => $quantity), true);
            }

            WC_AJAX :: get_refreshed_fragments();
        } else {

            $data = array(
                'error' => true,
                'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id));

            echo wp_send_json($data);
        }

        wp_die();
    }
}


if( ! function_exists( 'greenmart_woocommerce_product_thumbnails_columns' ) ) {
    function greenmart_woocommerce_product_thumbnails_columns() {

        $columns = greenmart_tbay_get_config('number_product_thumbnail', 3);

        if(isset($_GET['number_product_thumbnail']) && !empty($_GET['number_product_thumbnail']) && is_numeric($_GET['number_product_thumbnail']) ) {
            $columns = $_GET['number_product_thumbnail'];
        } else {
            $columns = greenmart_tbay_get_config('number_product_thumbnail', 3);
        }

        return $columns;
    }
    add_filter( 'woocommerce_product_thumbnails_columns', 'greenmart_woocommerce_product_thumbnails_columns', 10, 1 );
}

if (class_exists('YITH_WFBT_Frontend')) {
    remove_action( 'woocommerce_after_single_product_summary', array( YITH_WFBT_Frontend(), 'add_bought_together_form' ), 1 );
}


/*Add The WooCommerce Total Sales Count*/
if(!function_exists('greenmart_single_product_add_total_sales_count')){ 
  function greenmart_single_product_add_total_sales_count() { 
    global $product;
    if( !intval( greenmart_tbay_get_config('enable_total_sales', true) ) || $product->get_type() == 'external' ) return;

    $count = get_post_meta($product->get_id(),'total_sales', true); 

    $text =  sprintf(
        '<span class="rate-sold"><span class="count">%s</span> <span class="sold-text">%s</span></span>',
        number_format_i18n($count),
        esc_html__('sold', 'greenmart')
    );


    echo trim($text);
  }
  add_action( 'greenmart_woo_after_single_rating', 'greenmart_single_product_add_total_sales_count', 10 ); 
}

if(!function_exists('greenmart_woocommerce_buy_now')){
  function greenmart_woocommerce_buy_now(  ) { 
        global $product;
        if ( ! intval( greenmart_tbay_get_config('enable_buy_now', false) ) ) {
            return; 
        }

        if ( $product->get_type() == 'external' ) { 
            return;
        }
 
        $class = 'tbay-buy-now button';

        if( !empty($product) && $product->is_type( 'variable' ) ){
            $default_attributes = greenmart_get_default_attributes( $product );
            $variation_id = greenmart_find_matching_product_variation( $product, $default_attributes );

            if( empty($variation_id) ) {
                $class .= ' disabled';
            } 
        }
 
        echo sprintf( '<button class="'. $class .'">%s</button>', esc_html__('Buy Now', 'greenmart') );
        echo '<input type="hidden" value="0" name="greenmart_buy_now" />';
  } 
  add_action( 'woocommerce_after_add_to_cart_button', 'greenmart_woocommerce_buy_now', 10 ); 
}

/*Add To Cart Redirect*/  
if(!function_exists('greenmart_woocommerce_buy_now_redirect')){
    function greenmart_woocommerce_buy_now_redirect( $url ) {

        if ( ! isset( $_REQUEST['greenmart_buy_now'] ) || $_REQUEST['greenmart_buy_now'] == false ) {
            return $url; 
        }

        if ( empty( $_REQUEST['quantity'] ) ) {
            return $url;
        }

        if ( is_array( $_REQUEST['quantity'] ) ) {
            $quantity_set = false;
            foreach ( $_REQUEST['quantity'] as $item => $quantity ) {
                if ( $quantity <= 0 ) {
                    continue;
                }
                $quantity_set = true;
            }

            if ( ! $quantity_set ) {
                return $url;
            } 
        } 

        $redirect = greenmart_tbay_get_config('redirect_buy_now', 'cart') ;

        switch ($redirect) {
            case 'cart':
                return wc_get_cart_url();   

            case 'checkout':
                return wc_get_checkout_url();  
    
            default:
                return wc_get_cart_url(); 
        }

    }
    add_filter( 'woocommerce_add_to_cart_redirect', 'greenmart_woocommerce_buy_now_redirect', 99 );
}


// Mobile add to cart message html
if ( ! function_exists( 'greenmart_tbay_add_to_cart_message_html_mobile' ) ) {
    function greenmart_tbay_add_to_cart_message_html_mobile(  $message ) {
        if ( isset( $_REQUEST['greenmart_buy_now'] ) && $_REQUEST['greenmart_buy_now'] == true ) {
            return __return_empty_string();
        }

        $active = greenmart_tbay_get_config('disable_redirect_add_to_cart', false);

        if ( $active && wp_is_mobile() && ! intval( greenmart_tbay_get_config('enable_buy_now', false) ) ) {
            return __return_empty_string();     
        } else {
            return $message;
        }

    }
    add_filter( 'wc_add_to_cart_message_html', 'greenmart_tbay_add_to_cart_message_html_mobile' );
}

if ( ! function_exists( 'greenmart_gwp_affiliate_id' ) ) {
    function greenmart_gwp_affiliate_id(){
        return 2403;
    }
    add_filter('gwp_affiliate_id', 'greenmart_gwp_affiliate_id');
}



require get_template_directory() . '/inc/vendors/woocommerce/skins/'.greenmart_tbay_get_theme().'/functions.php';
