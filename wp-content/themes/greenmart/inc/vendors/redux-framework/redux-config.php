<?php
/**
 * ReduxFramework Sample Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 */

if (!class_exists('greenmart_Redux_Framework_Config')) {

    class greenmart_Redux_Framework_Config
    {
        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;
 
        public function __construct()
        {
            if (!class_exists('ReduxFramework')) {
                return;
            }

            add_action('init', array($this, 'initSettings'), 10);
        }

        public function initSettings()
        {
            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        public function setSections()
        {
            global $wp_registered_sidebars;
            $sidebars = array();

            if ( !empty($wp_registered_sidebars) ) {
                foreach ($wp_registered_sidebars as $sidebar) {
                    $sidebars[$sidebar['id']] = $sidebar['name'];
                }
            }
            $columns = array( '1' => esc_html__('1 Column', 'greenmart'),
                '2' => esc_html__('2 Columns', 'greenmart'),
                '3' => esc_html__('3 Columns', 'greenmart'),
                '4' => esc_html__('4 Columns', 'greenmart'),
                '5' => esc_html__('5 Columns', 'greenmart'),
                '6' => esc_html__('6 Columns', 'greenmart')
            );
            
            // General Settings Tab
            $this->sections[] = array(
                'icon' => 'el-icon-cogs',
                'title' => esc_html__('General', 'greenmart'),
                'fields' => array(
                    array(
                        'id'        => 'active_theme',
                        'type'      => 'image_select', 
                        'compiler'  => true,
                        'class'     => 'image-large active_skins',
                        'title'     => esc_html__('Activated Skin', 'greenmart'),
                        'subtitle'  => '<em>'.esc_html__('Choose a skin for your website.', 'greenmart').'</em>',
                        'options'   => greenmart_tbay_get_themes(),
                        'default'   => 'organic'
                    ),
                    array(
                        'id'        => 'preload',
                        'type'      => 'switch',
                        'title'     => esc_html__('Preload Website', 'greenmart'),
                        'default'   => false
                    ),
                    array(
                        'id' => 'select_preloader',
                        'type' => 'image_select',
                        'class'     => 'image-preloader',
                        'compiler' => true,
                        'title' => esc_html__('Select Preloader', 'greenmart'),
                        'subtitle' => esc_html__('Choose a Preloader for your website.', 'greenmart'),
                        'required'  => array('preload','=',true),
                        'options' => array(
                            'loader1' => array(
                                'title' => 'Loader 1',
                                'img'   => GREENMART_ASSETS_IMAGES . '/preloader/loader1.png'
                            ),         
                            'loader2' => array(
                                'title' => 'Loader 2',
                                'img'   => GREENMART_ASSETS_IMAGES . '/preloader/loader2.png'
                            ),              
                            'loader3' => array(
                                'title' => 'Loader 3',
                                'img'   => GREENMART_ASSETS_IMAGES . '/preloader/loader3.png'
                            ),         
                            'loader4' => array(
                                'title' => 'Loader 4',
                                'img'   => GREENMART_ASSETS_IMAGES . '/preloader/loader4.png'
                            ),          
                            'loader5' => array(
                                'title' => 'Loader 5',
                                'img'   => GREENMART_ASSETS_IMAGES . '/preloader/loader5.png'
                            ),         
                            'loader6' => array(
                                'title' => 'Loader 6',
                                'img'   => GREENMART_ASSETS_IMAGES . '/preloader/loader6.png'
                            ),       
                            'custom_image' => array(
                                'title' => 'Custom image',
                                'img'   => GREENMART_ASSETS_IMAGES . '/preloader/custom_image.png'
                            ),                        
                        ),
                        'default' => 'loader1'
                    ),
                    array(
                        'id' => 'media-preloader',
                        'type' => 'media',
                        'required' => array('select_preloader','=', 'custom_image'),
                        'title' => esc_html__('Upload preloader image', 'greenmart'),
                        'subtitle' => esc_html__('Image File (.gif)', 'greenmart'),
                        'desc' =>   sprintf( wp_kses( __('You can download some the Gif images <a target="_blank" href="%1$s">here</a>.', 'greenmart' ),  array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://loading.io/' ), 
                    ),
                    array(
                        'id'            => 'config_media',
                        'type'          => 'switch',
                        'title'         => esc_html__('Enable Config Image Size', 'greenmart'),
                        'subtitle'      => esc_html__('Config Image Size in WooCommerce and Media Setting', 'greenmart'),
                        'default'       => false
                    ),         
                    array(
                        'id'            => 'enable_lazyloadimage',
                        'type'          => 'switch',
                        'title'         => esc_html__('Enable LazyLoadImage', 'greenmart'),
                        'default'       => true
                    ),           
                    
                )
            );
            // Header
            $this->sections[] = array(
                'icon' => 'el el-website',
                'title' => esc_html__('Header', 'greenmart'),
            );            

            // Header
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Header Config', 'greenmart'),
                'fields' => array(
                    array(
                        'id' => 'header_type',
                        'type' => 'select',
                        'title' => esc_html__('Header Layout Type', 'greenmart'),
                        'subtitle' => esc_html__('Choose a header for your website.', 'greenmart'),
                       'options' => greenmart_tbay_get_header_layouts(),
                        'default' => 'v1'
                    ),
                    array(
                        'id' => 'media-logo',
                        'type' => 'media',
                        'title' => esc_html__('Logo Upload', 'greenmart'),
                        'desc' => esc_html__('', 'greenmart'),
                        'subtitle' => esc_html__('Upload a .png or .gif image that will be your logo.', 'greenmart'),
                    ),
                    array(
                        'id'        => 'logo_img_width',
                        'type'      => 'slider',
                        'title'     => esc_html__('Logo image maximum width (px)', 'greenmart'),
                        'desc'      => esc_html__('Set maximum width for logo image in the header. In pixels', 'greenmart'),
                        "default"   => 160,
                        "min"       => 100,
                        "step"      => 1,
                        "max"       => 600,
                    ),
                    array(
                        'id'             => 'logo_padding',
                        'type'           => 'spacing',
                        'mode'           => 'padding',
                        'units'          => array('px'),
                        'units_extended' => 'false',
                        'title'          => esc_html__('Logo image padding', 'greenmart'),
                        'desc'           => esc_html__('Add some spacing around your logo image', 'greenmart'),
                        'default'            => array(
                            'padding-top'     => '0px',
                            'padding-right'   => '0px',
                            'padding-bottom'  => '0px',
                            'padding-left'    => '0px',
                            'units'          => 'px',
                        ),
                    ),        
                    array(
                        'id'        => 'logo_tablet_img_width',
                        'type'      => 'slider',
                        'title'     => esc_html__('Tablet Logo image maximum width (px)', 'greenmart'),
                        'desc'      => esc_html__('Set maximum width for logo image in the header. In pixels', 'greenmart'),
                        "default"   => 100,
                        "min"       => 100,
                        "step"      => 1,
                        "max"       => 600,
                    ),            
                    array(
                        'id'             => 'logo_tablet_padding',
                        'type'           => 'spacing',
                        'mode'           => 'padding',
                        'units'          => array('px'),
                        'units_extended' => 'false',
                        'title'          => esc_html__('Tablet logo image padding', 'greenmart'),
                        'desc'           => esc_html__('Add some spacing around your logo image', 'greenmart'),
                        'default'            => array(
                            'padding-top'     => '0px',
                            'padding-right'   => '0px',
                            'padding-bottom'  => '0px',
                            'padding-left'    => '0px',
                            'units'          => 'px',
                        ),
                    ),
                    array(
                        'id' => 'keep_header',
                        'type' => 'switch',
                        'title' => esc_html__('Keep Header', 'greenmart'),
                        'default' => false
                    ),
					
                    array(
                        'id' => 'header_login',
                        'type' => 'switch',
                        'title' => esc_html__('Header Login', 'greenmart'),
                        'default' => 1
                    ),					
                )
            );
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Search Form', 'greenmart'),
                'fields' => array(
                    array(
                        'id'=>'show_searchform',
                        'type' => 'switch',
                        'title' => esc_html__('Show Search Form', 'greenmart'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'greenmart'),
                        'off' => esc_html__('No', 'greenmart'),
                    ),
                    array(
                        'id'=>'search_type',
                        'type' => 'button_set',
                        'title' => esc_html__('Search Content Type', 'greenmart'),
                        'required' => array('show_searchform','equals',true),
                        'options' => array('all' => esc_html__('All', 'greenmart'), 'post' => esc_html__('Post', 'greenmart'), 'product' => esc_html__('Product', 'greenmart')),
                        'default' => 'product'
                    ),
                    array(
                        'id'=>'search_category',
                        'type' => 'switch',
                        'title' => esc_html__('Show Categories', 'greenmart'),
                        'required' => array('search_type', 'equals', array('post', 'product')),
                        'default' => false,
                        'on' => esc_html__('Yes', 'greenmart'),
                        'off' => esc_html__('No', 'greenmart'),
                    ),
                    array(
                        'id' => 'autocomplete_search',
                        'type' => 'switch',
                        'title' => esc_html__('Autocomplete search?', 'greenmart'),
                        'required' => array('show_searchform','equals',true),
                        'default' => 1
                    ),
                    array(
                        'id' => 'show_search_product_image',
                        'type' => 'switch',
                        'title' => esc_html__('Show Search Result Image', 'greenmart'),
                        'required' => array('autocomplete_search', '=', '1'),
                        'default' => 1
                    ),
                    array(
                        'id' => 'show_search_product_price',
                        'type' => 'switch',
                        'title' => esc_html__('Show Search Result Price', 'greenmart'),
                        'required' => array(array('autocomplete_search', '=', '1'), array('search_type', '=', 'product')),
                        'default' => true
                    ),
                    array(
                        'id' => 'search_max_number_results',
                        'title' => esc_html__('Max number of results show', 'greenmart'),
                        'required' => array('autocomplete_search', '=', '1'),
                        'default' => 5,
                        'min'   => '2',
                        'step'  => '1',
                        'max'   => '10',
                        'type'  => 'slider'
                    ),  
                )
            );


            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Table Reservation', 'greenmart'),
                'fields' => array(
                    array(
                        'id' => 'enable_reserve_table',
                        'type' => 'switch',
                        'required' => array( 
                            array('active_theme','=','restaurant'), 
                            array('header_type','=','v1') 
                        ),
                        'title' => esc_html__('Reserve Table', 'greenmart'),
                        'subtitle' => esc_html__('Enable/disable Reserve Table button (Only header 1)', 'greenmart'),
                        'default' => 1
                    ),
                    array(
                        'id'       => 'rtb_title',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Title of reserve table', 'greenmart' ),
                        'required' => array('enable_reserve_table','=', true),
                    ), 
                    array(
                        'id'       => 'rtb_descreption',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Descreption of reserve table', 'greenmart' ),
                        'required' => array('enable_reserve_table','=', true),
                    ),  
                    array(
                        'id'       => 'rtb_button',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Button reserve table', 'greenmart' ),
                        'required' => array('enable_reserve_table','=', true),
                        'default'  => esc_html__( 'Reserve table', 'greenmart' ),
                    ), 
                )
            );


            // Footer
            $this->sections[] = array(
                'icon' => 'el el-website',
                'title' => esc_html__('Footer', 'greenmart'),
                'fields' => array(
                    array(
                        'id' => 'footer_type',
                        'type' => 'select',
                        'title' => esc_html__('Footer Layout Type', 'greenmart'),
                        'subtitle' => esc_html__('Choose a footer for your website.', 'greenmart'),
                        'options' => greenmart_tbay_get_footer_layouts(),
 						'default' => 'footer-1'
                    ),
                    array(
                        'id' => 'copyright_text',
                        'type' => 'editor',
                        'title' => esc_html__('Copyright Text', 'greenmart'),
                        'default' => 'Powered by Redux Framework.',
                        'required' => array('footer_type','=','')
                    ),
                    array(
                        'id' => 'back_to_top',
                        'type' => 'switch',
                        'title' => esc_html__('Back To Top Button', 'greenmart'),
                        'subtitle' => esc_html__('Toggle whether or not to enable a back to top button on your pages.', 'greenmart'),
                        'default' => true,
                    ),
                    array(
                        'id' => 'category_fixed',
                        'type' => 'switch',
                        'title' => esc_html__('Show Menu Category Fixed', 'greenmart'),
                        'subtitle' => esc_html__('Toggle whether or not to show "Menu Category Fixed" on your pages.', 'greenmart'),
                        'default' => true,
                        'required' => array('active_theme','=','restaurant')
                    ),
                )
            );

            // Blog settings
            $this->sections[] = array(
                'icon' => 'el el-pencil',
                'title' => esc_html__('Blog', 'greenmart'),
                'fields' => array(
                    array(
                        'id' => 'show_blog_breadcrumbs',
                        'type' => 'switch',
                        'title' => esc_html__('Breadcrumbs', 'greenmart'),
                        'default' => 1
                    ),
                    array (
                        'title' => esc_html__('Breadcrumbs Background Color', 'greenmart'),
                        'subtitle' => '<em>'.esc_html__('The breadcrumbs background color of the site.', 'greenmart').'</em>',
                        'id' => 'blog_breadcrumb_color',
                        'type' => 'color',
                        'transparent' => false,
                    ),
                    array(
                        'id' => 'blog_breadcrumb_image',
                        'type' => 'media',
                        'title' => esc_html__('Breadcrumbs Background', 'greenmart'),
                        'subtitle' => esc_html__('Upload a .jpg or .png image that will be your breadcrumbs.', 'greenmart'),
                    ),
                )
            );
            // Archive Blogs settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Blog & Post Archives', 'greenmart'),
                'fields' => array(
                    array(
                        'id' => 'blog_archive_layout',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Layout', 'greenmart'),
                        'subtitle' => esc_html__('Select the variation you want to apply on your store.', 'greenmart'),
                        'options' => array(
                            'main' => array(
                                'title' => 'Main Only',
                                'alt' => 'Main Only',
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen1.png'
                            ),
                            'left-main' => array(
                                'title' => 'Left - Main Sidebar',
                                'alt' => 'Left - Main Sidebar',
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen2.png'
                            ),
                            'main-right' => array(
                                'title' => 'Main - Right Sidebar',
                                'alt' => 'Main - Right Sidebar',
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen3.png'
                            ),
                            'left-main-right' => array(
                                'title' => 'Left - Main - Right Sidebar',
                                'alt' => 'Left - Main - Right Sidebar',
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen4.png'
                            ),
                        ),
                        'default' => 'main-right'
                    ),
                    array(
                        'id' => 'blog_archive_fullwidth',
                        'type' => 'switch',
                        'title' => esc_html__('Is Full Width?', 'greenmart'),
                        'default' => false
                    ),
                    array(
                        'id' => 'blog_archive_left_sidebar',
                        'type' => 'select',
                        'title' => esc_html__('Archive Left Sidebar', 'greenmart'),
                        'subtitle' => esc_html__('Choose a sidebar for left sidebar.', 'greenmart'),
                        'options' => $sidebars,
						'default' => 'blog-left-sidebar'
                    ),
                    array(
                        'id' => 'blog_archive_right_sidebar',
                        'type' => 'select',
                        'title' => esc_html__('Archive Right Sidebar', 'greenmart'),
                        'subtitle' => esc_html__('Choose a sidebar for right sidebar.', 'greenmart'),
                       'options' => $sidebars,
                        'default' => 'blog-right-sidebar'
                        
                    ),
                    array(
                        'id' => 'blog_columns',
                        'type' => 'select',
                        'title' => esc_html__('Blog Columns', 'greenmart'),
                        'options' => $columns,
                        'default' => 1
                    ),

                )
            );
            // Single Blogs settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Blog', 'greenmart'),
                'fields' => array(
                    
                    array(
                        'id' => 'blog_single_layout',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Archive Blog Layout', 'greenmart'),
                        'subtitle' => esc_html__('Select the variation you want to apply on your store.', 'greenmart'),
                        'options' => array(
                            'main' => array(
                                'title' => 'Main Only',
                                'alt' => 'Main Only',
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen1.png'
                            ),
                            'left-main' => array(
                                'title' => 'Left - Main Sidebar',
                                'alt' => 'Left - Main Sidebar',
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen2.png'
                            ),
                            'main-right' => array(
                                'title' => 'Main - Right Sidebar',
                                'alt' => 'Main - Right Sidebar',
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen3.png'
                            ),
                            'left-main-right' => array(
                                'title' => 'Left - Main - Right Sidebar',
                                'alt' => 'Left - Main - Right Sidebar',
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen4.png'
                            ),
                        ),
                        'default' => 'main-right'
                    ),
                    array(
                        'id' => 'blog_single_fullwidth',
                        'type' => 'switch',
                        'title' => esc_html__('Is Full Width?', 'greenmart'),
                        'default' => false
                    ),
                    array(
                        'id' => 'blog_single_left_sidebar',
                        'type' => 'select',
                        'title' => esc_html__('Single Blog Left Sidebar', 'greenmart'),
                        'subtitle' => esc_html__('Choose a sidebar for left sidebar.', 'greenmart'),
                         'options'   => $sidebars,
                        'default'   => 'blog-left-sidebar'
                    ),
                    array(
                        'id' => 'blog_single_right_sidebar',
                        'type' => 'select',
                        'title' => esc_html__('Single Blog Right Sidebar', 'greenmart'),
                        'subtitle' => esc_html__('Choose a sidebar for right sidebar.', 'greenmart'),
                        'options'   => $sidebars,
                        'default'   => 'blog-right-sidebar'
                    ),
                    array(
                        'id' => 'show_blog_social_share',
                        'type' => 'switch',
                        'title' => esc_html__('Show Social Share', 'greenmart'),
                        'default' => 1
                    ),
                    array(
                        'id' => 'show_blog_releated',
                        'type' => 'switch',
                        'title' => esc_html__('Show Releated Posts', 'greenmart'),
                        'default' => 1
                    ),
                    array(
                        'id' => 'number_blog_releated',
                        'type' => 'text',
                        'title' => esc_html__('Number of related posts to show', 'greenmart'),
                        'required' => array('show_blog_releated', '=', '1'),
                        'default' => 2,
                        'min' => '1',
                        'step' => '1',
                        'max' => '20',
                        'type' => 'slider'
                    ),
                    array(
                        'id' => 'releated_blog_columns',
                        'type' => 'select',
                        'title' => esc_html__('Releated Blogs Columns', 'greenmart'),
                        'required' => array('show_blog_releated', '=', '1'),
                        'options' => $columns,
                        'default' => 2
                    ),

                )
            );
            // Woocommerce
            $this->sections[] = array( 
                'icon' => 'el el-shopping-cart',
                'title' => esc_html__('Woocommerce', 'greenmart'),
                'fields' => array(
                     array(
                        'title'    => esc_html__('Sale Tag Settings', 'greenmart'),
                        'subtitle' => '<em>'.esc_html__('Predefined Format', 'greenmart').'</em>',
                        'id'       => 'sale_tags',
                        'type'     => 'radio',
                        'options'  => array(
                            'Sale!' => esc_html__('Sale!' ,'greenmart'),
                            'Save {percent-diff}%' => esc_html__('Save {percent-diff}%' ,'greenmart'),
                            'Save ${price-diff}' => esc_html__('Save ${price-diff}' ,'greenmart'),
                            'custom' => esc_html__('Custom tag (use field below)' ,'greenmart')
                        ),
                        'default' => 'custom'
                    ),
                    array(
                        'id'        => 'sale_tag_custom',
                        'type'      => 'text',
                        'title'     => esc_html__( 'Custom Format', 'greenmart' ),
                        'desc'      => esc_html__('{price-diff} inserts the dollar amount off.', 'greenmart'). '</br>'.
                                       esc_html__('{percent-diff} inserts the percent reduction (rounded).', 'greenmart'). '</br>'.
                                       esc_html__('{symbol} inserts the Default currency symbol.', 'greenmart'),
                        'required'  => array('sale_tags','=', 'custom'),
                        'default'   => '- {percent-diff}%'
                    ), 
                    array(
                        'id' => 'enable_label_featured',
                        'type' => 'switch',
                        'title' => esc_html__('Label featured', 'greenmart'),
                        'subtitle' => esc_html__('Enable/Disable label featured', 'greenmart'),
                        'default' => true
                    ),   
                    array(
                        'id'        => 'custom_label_featured',
                        'type'      => 'text',
                        'title'     => esc_html__( 'Custom Label featured', 'greenmart' ),
                        'required'  => array('enable_label_featured','=', true),
                        'default'   => esc_html__('Hot', 'greenmart')
                    ), 
                    array(
                        'id'   => 'opt-divide',
                        'class' => 'big-divide',
                        'type' => 'divide'
                    ),        
                    array(
                        'id' => 'enable_woocommerce_catalog_mode',
                        'type' => 'switch',
                        'title' => esc_html__('Enable WooCommerce Catalog Mode', 'greenmart'),
                        'default' => false
                    ),
                    array(
                        'id' => 'ajax_update_quantity',
                        'type' => 'switch',
                        'title' => esc_html__('Enable/Disable Ajax update quantity', 'greenmart'),
                        'subtitle' => esc_html__('Enable/Disable Ajax update quantity (Only Cart Page)', 'greenmart'),
                        'default' => true
                    ),    
                    array(
                        'id' => 'ajax_single_add_to_cart',
                        'type' => 'switch',
                        'title' => esc_html__('Enable/Disable Ajax add to cart', 'greenmart'),
                        'subtitle' => esc_html__('Enable/Disable Ajax add to cart in Single Product Page', 'greenmart'),
                        'default' => true
                    ),  
                    array(
                        'id' => 'enable_woocommerce_quantity_mode',
                        'type' => 'switch',
                        'title' => esc_html__('Enable WooCommerce Quantity Mode', 'greenmart'),
                        'subtitle' => esc_html__('Enable/Disable show quantity on Home Page and Shop Page', 'greenmart'),
                        'default' => false
                    ),
                    array(
                        'id' => 'disable_woocommerce_password_strength',
                        'type' => 'switch',
                        'title' => esc_html__('Disable the Password Strength Meter', 'greenmart'),
                        'subtitle' => esc_html__('Disable the Password Strength Meter in WooCommerce', 'greenmart'),
                        'default' => false
                    ),  
                   array(
                        'id' => 'disable_ajax_popup_cart',
                        'type' => 'switch',
                        'title' => esc_html__('Disable Ajax poup cart when click add to cart', 'greenmart'),
                        'default' => false
                    ),     		
                    array(
                        'id' => 'enable_hide_sub_title_product',
                        'type' => 'switch',
                        'title' => esc_html__('Hide sub title product', 'greenmart'),
                        'default' => false
                    ),    
                    array(
                        'id' => 'show_product_breadcrumbs',
                        'type' => 'switch',
                        'title' => esc_html__('Breadcrumbs', 'greenmart'),
                        'default' => 1
                    ),
                    array (
                        'title' => esc_html__('Breadcrumbs Background Color', 'greenmart'),
                        'subtitle' => '<em>'.esc_html__('The breadcrumbs background color of the site.', 'greenmart').'</em>',
                        'id' => 'woo_breadcrumb_color',
                        'type' => 'color',
                        'transparent' => false,
                    ),
                    array(
                        'id' => 'woo_breadcrumb_image',
                        'type' => 'media',
                        'title' => esc_html__('Breadcrumbs Background', 'greenmart'),
                        'subtitle' => esc_html__('Upload a .jpg or .png image that will be your breadcrumbs.', 'greenmart'),
                    ),
                )
            );
            // Archive settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Product Archives', 'greenmart'),
                'fields' => array(
                    array(
                        'id' => 'product_archive_layout',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Archive Product Layout', 'greenmart'),
                        'subtitle' => esc_html__('Select the layout you want to apply on your archive product page.', 'greenmart'),
                        'options' => array(
                            'main' => array(
                                'title' => 'Main Content',
                                'alt' => 'Main Content',
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen1.png'
                            ),
                            'left-main' => array(
                                'title' => 'Left Sidebar - Main Content',
                                'alt' => 'Left Sidebar - Main Content',
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen2.png'
                            ),
                            'main-right' => array(
                                'title' => 'Main Content - Right Sidebar',
                                'alt' => 'Main Content - Right Sidebar',
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen3.png'
                            ),
                            'left-main-right' => array(
                                'title' => 'Left Sidebar - Main Content - Right Sidebar',
                                'alt' => 'Left Sidebar - Main Content - Right Sidebar',
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen4.png'
                            ),
                        ),
                        'default' => 'left-main'
                    ),
                    array(
                        'id' => 'enable_category_image',
                        'type' => 'switch',
                        'title' => esc_html__('Enable/Disable image category', 'greenmart'),
                        'subtitle' => esc_html__('Enable/Disable image category', 'greenmart'),
                        'default' => false
                    ),   
                    array(
                        'id' => 'enable_category_title',
                        'type' => 'switch',
                        'title' => esc_html__('Enable/Disable title category', 'greenmart'),
                        'subtitle' => esc_html__('Enable/Disable title category', 'greenmart'),
                        'default' => false
                    ),                     
                    array(
                        'id' => 'enable_category_description',
                        'type' => 'switch',
                        'title' => esc_html__('Enable/Disable description category', 'greenmart'),
                        'subtitle' => esc_html__('Enable/Disable description category', 'greenmart'),
                        'default' => false
                    ),                        
                    array(
                        'id' => 'show_top_archive_product',
                        'type' => 'switch',
                        'title' => esc_html__('Show widget Top Archive product', 'greenmart'),
                        'default' => true
                    ),                 
                    array(
                        'id' => 'product_archive_fullwidth',
                        'type' => 'switch',
                        'title' => esc_html__('Is Full Width?', 'greenmart'),
                        'default' => false
                    ),
                    array(
                        'id' => 'product_archive_left_sidebar',
                        'type' => 'select',
                        'title' => esc_html__('Archive Left Sidebar', 'greenmart'),
                        'subtitle' => esc_html__('Choose a sidebar for left sidebar.', 'greenmart'),
                        'options' => $sidebars,
                        'default' => 'product-left-sidebar'
                    ),
                    array(
                        'id' => 'product_archive_right_sidebar',
                        'type' => 'select',
                        'title' => esc_html__('Archive Right Sidebar', 'greenmart'),
                        'subtitle' => esc_html__('Choose a sidebar for right sidebar.', 'greenmart'),
                       'options' => $sidebars,
                        'default' => 'product-right-sidebar'
                    ),
                    array(
                        'id' => 'product_display_mode',
                        'type' => 'button_set',
                        'title' => esc_html__('Display Mode', 'greenmart'),
                        'subtitle' => esc_html__('Choose a default layout archive product.', 'greenmart'),
                        'options' => array('grid' => esc_html__('Grid', 'greenmart'), 'list' => esc_html__('List', 'greenmart')),
                        'default' => 'grid'
                    ),
                    array(
                        'id' => 'number_products_per_page',
                        'type' => 'text',
                        'title' => esc_html__('Number of Products Per Page', 'greenmart'),
                        'default' => 9,
                        'min' => '1',
                        'step' => '1',
                        'max' => '100',
                        'type' => 'slider'
                    ),
                    array(
                        'id' => 'product_columns',
                        'type' => 'select',
                        'title' => esc_html__('Product Columns', 'greenmart'),
                        'options' => $columns,
                        'default' => 3
                    ),
                    array(
                        'id' => 'show_swap_image',
                        'type' => 'switch',
                        'title' => esc_html__('Show Second Image (Hover)', 'greenmart'),
                        'default' => 1
                    ),
                )
            );
            // Product Page
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Single Product', 'greenmart'),
                'fields' => array(
                    array(
                        'id' => 'product_single_layout',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Single Product Layout', 'greenmart'),
                        'subtitle' => esc_html__('Select the layout you want to apply on your Single Product Page.', 'greenmart'),
                        'options' => array(
                            'main' => array(
                                'title' => 'Main Only',
                                'alt' => 'Main Only',
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen1.png'
                            ),
                            'left-main' => array(
                                'title' => 'Left - Main Sidebar',
                                'alt' => 'Left - Main Sidebar',
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen2.png'
                            ),
                            'main-right' => array(
                                'title' => 'Main - Right Sidebar',
                                'alt' => 'Main - Right Sidebar',
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen3.png'
                            ),
                            'left-main-right' => array(
                                'title' => 'Left - Main - Right Sidebar',
                                'alt' => 'Left - Main - Right Sidebar',
                                'img' => get_template_directory_uri() . '/inc/assets/images/screen4.png'
                            ),
                        ),
                        'default' => 'main-right'
                    ),
                    array(
                        'id' => 'product_single_fullwidth',
                        'type' => 'switch',
                        'title' => esc_html__('Is Full Width?', 'greenmart'),
                        'default' => false
                    ),
                    array(
                        'id' => 'product_single_left_sidebar',
                        'type' => 'select',
                        'title' => esc_html__('Single Product Left Sidebar', 'greenmart'),
                        'subtitle' => esc_html__('Choose a sidebar for left sidebar.', 'greenmart'),
                         'options' => $sidebars,
                        'default' => 'product-left-sidebar'
                    ),
                    array(
                        'id' => 'product_single_right_sidebar',
                        'type' => 'select',
                        'title' => esc_html__('Single Product Right Sidebar', 'greenmart'),
                        'subtitle' => esc_html__('Choose a sidebar for right sidebar.', 'greenmart'),
                        'options' => $sidebars,
                        'default' => 'product-right-sidebar'
                    ),
					array(
                        'id' => 'style_single_product',
                        'type' => 'select',
                        'title' => esc_html__('Style Single Product Thumbnail', 'greenmart'),
                        'subtitle' => esc_html__('Choose a style single product thumbnail.', 'greenmart'),
                        'options' => array(
                                'horizontal'  => 'Thumbnail Horizontal',
                                'vertical'    => 'Thumbnail Vertical'
                        ),
                        'default' => 'horizontal'
                    ),
                    array(
                        'id' => 'enable_total_sales',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Total Sales', 'greenmart'),
                        'default' => true
                    ),                     
                    array(
                        'id' => 'enable_buy_now',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Buy Now', 'greenmart'),
                        'default' => false
                    ),    
                    array( 
                        'id' => 'redirect_buy_now',
                        'required' => array('enable_buy_now','=',true),
                        'type' => 'button_set',
                        'title' => esc_html__('Redirect to page after Buy Now', 'greenmart'),
                        'options' => array( 
                                'cart'          => 'Page Cart',
                                'checkout'      => 'Page CheckOut',
                        ),
                        'default' => 'cart'
                    ),
                    array( 
                        'id'   => 'opt-divide',
                        'class' => 'big-divide',
                        'type' => 'divide'
                    ),   
                    array(
                        'id' => 'show_product_countdown',
                        'type' => 'switch',
                        'title' => esc_html__('Show Products Countdown', 'greenmart'),
                        'default' => true
                    ), 
                    array(
                        'id' => 'show_product_nav',
                        'type' => 'switch',
                        'title' => esc_html__('Show Product navigator', 'greenmart'),
                        'default' => 1
                    ),                    
                    array(
                        'id' => 'show_product_social_share',
                        'type' => 'switch',
                        'title' => esc_html__('Show Social Share', 'greenmart'),
                        'default' => 1
                    ),
                    array(
                        'id' => 'style_single_tabs_style',
                        'type' => 'select',
                        'title' => esc_html__('Style Product Tabs', 'greenmart'),
                        'subtitle' => esc_html__('Choose a style tabs.', 'greenmart'),
                        'options' => array(
                                'default'          => 'Default',
                                'tbhorizontal'     => 'Horizontal',
                                'tbvertical'       => 'Vertical',
                                'accordion'        => 'Accordion '
                        ),
                        'default' => 'default'
                    ),    
                    array(
                        'id' => 'show_product_review_tab',
                        'type' => 'switch',
                        'title' => esc_html__('Show Product Review Tab', 'greenmart'),
                        'default' => 1
                    ),
                    array(
                        'id' => 'show_product_releated',
                        'type' => 'switch',
                        'title' => esc_html__('Show Products Releated', 'greenmart'),
                        'default' => 1
                    ),
                    array(
                        'id' => 'show_product_upsells',
                        'type' => 'switch',
                        'title' => esc_html__('Show Products upsells', 'greenmart'),
                        'default' => 1
                    ),
					array(
                        'id' => 'number_product_thumbnail',
                        'title' => esc_html__('Number Images Thumbnail to show', 'greenmart'),
                        'default' => 4,
                        'min'   => '2',
                        'step'  => '1',
                        'max'   => '5',
                        'type'  => 'slider'
                    ),  
                    array(
                        'id' => 'number_product_releated',
                        'title' => esc_html__('Number of related products to show', 'greenmart'),
                        'default' => 3,
                        'min' => '1',
                        'step' => '1',
                        'max' => '20',
                        'type' => 'slider'
                    ),
                    array(
                        'id' => 'releated_product_columns',
                        'type' => 'select',
                        'title' => esc_html__('Releated Products Columns', 'greenmart'),
                        'options' => $columns,
                        'default' => 3
                    ),

                )
            );

            
            // Mobile
            $this->sections[] = array(
                'icon' => 'el el-photo',
                'title' => esc_html__('Mobile', 'greenmart'),
            );


             // Mobile Header settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Header Mobile', 'greenmart'),
                'fields' => array(
                    array(
                        'id' => 'mobile-logo',
                        'type' => 'media',
                        'title' => esc_html__('Mobile Logo', 'greenmart'),
                        'desc' => esc_html__('', 'greenmart'),
                        'subtitle' => esc_html__('Upload a .png or .gif image that will be mobile logo', 'greenmart'),
                    ),
                    array(
                        'id'        => 'logo_img_width_mobile',
                        'type'      => 'slider',
                        'title'     => esc_html__('Mobile Logo image maximum width (px)', 'greenmart'),
                        'desc'      => esc_html__('Set maximum width for logo image in the header. In pixels', 'greenmart'),
                        "default"   => 200,
                        "min"       => 50,
                        "step"      => 1,
                        "max"       => 600,
                    ),
                    array(
                        'id'             => 'logo_mobile_padding',
                        'type'           => 'spacing',
                        'mode'           => 'padding',
                        'units'          => array('px'),
                        'units_extended' => 'false',
                        'title'          => esc_html__('Mobile Logo image padding', 'greenmart'),
                        'desc'           => esc_html__('Add some spacing around your logo image', 'greenmart'),
                        'default'            => array(
                            'padding-top'     => '0px',
                            'padding-right'   => '0px',
                            'padding-bottom'  => '0px',
                            'padding-left'    => '0px',
                            'units'          => 'px',
                        ),
                    ),
                    array(
                        'id'        => 'logo_all_page',
                        'type'      => 'switch',
                        'title'     => esc_html__('Logo all page', 'greenmart'),
                        'desc'      => esc_html__('Shown logo on all pages', 'greenmart'),
                        'default'   => false
                    ),
                )
            );

            // Footer
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Footer mobile', 'greenmart'),
                'fields' => array(
                    array(
                        'id' => 'mobile_footer',
                        'type' => 'switch',
                        'title' => esc_html__('Show Desktop Footer', 'greenmart'),
                        'default' => false
                    ),                    
                    array(
                        'id' => 'mobile_footer_icon',
                        'type' => 'switch',
                        'title' => esc_html__('Show Mobile Footer Icons', 'greenmart'),
                        'default' => true
                    ),
                )
            );


            // Menu mobile social settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Menu mobile', 'greenmart'),
                'fields' => array(
                    array(
                        'id'       => 'menu_mobile_type',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Menu Mobile Type', 'greenmart' ),
                        'options'  => array(
                            'smart_menu' => 'Smart Menu',
                            'treeview'   => 'Treeview Menu'
                        ),
                        'default'  => 'treeview'
                    ),
                     array(
                        'id' => 'menu_mobile_themes',
                        'type' => 'button_set', 
                        'title' => esc_html__('Menu mobile theme', 'greenmart'),
                        'required' => array('menu_mobile_type','=','smart_menu'),
                        'options' => array( 
                            'theme-light'       => esc_html__('Light', 'greenmart'),
                            'theme-dark'        => esc_html__('Dark', 'greenmart'),
                        ),
                        'default' => 'theme-light'
                    ),
                    array(
                        'id' => 'enable_menu_mobile_effects',
                        'type' => 'switch',
                        'title' => esc_html__('Menu mobile effects ', 'greenmart'),
                        'required' => array('menu_mobile_type','=','smart_menu'),
                        'default' => false
                    ),                    
                    array(
                        'id' => 'menu_mobile_effects_panels',
                        'type' => 'select', 
                        'title' => esc_html__('Panels effect', 'greenmart'),
                        'required' => array('enable_menu_mobile_effects','=', true),
                        'options' => array( 
                            'fx-panels-none'            => esc_html__('No effect', 'greenmart'),
                            'fx-panels-slide-0'         => esc_html__('Slide 0', 'greenmart'),
                            'no-effect'                 => esc_html__('Slide 30', 'greenmart'),
                            'fx-panels-slide-100'       => esc_html__('Slide 100', 'greenmart'),
                            'fx-panels-slide-up'        => esc_html__('Slide uo', 'greenmart'),
                            'fx-panels-zoom'            => esc_html__('Zoom', 'greenmart'),
                        ),
                        'default' => 'no-effect'
                    ),                    
                    array(
                        'id' => 'menu_mobile_effects_listitems',
                        'type' => 'select', 
                        'title' => esc_html__('List items effect', 'greenmart'),
                        'required' => array('enable_menu_mobile_effects','=', true),
                        'options' => array( 
                            'no-effect'                          => esc_html__('No effect', 'greenmart'),
                            'fx-listitems-drop'         => esc_html__('Drop', 'greenmart'),
                            'fx-listitems-fade'         => esc_html__('Fade', 'greenmart'),
                            'fx-listitems-slide'        => esc_html__('slide', 'greenmart'),
                        ),
                        'default' => 'no-effect'
                    ),
                    array(
                        'id'       => 'menu_mobile_title',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Menu mobile Title', 'greenmart' ),
                        'default'  => esc_html__( 'Menu', 'greenmart' ),
                    ), 
                    array(
                        'id' => 'enable_menu_mobile_search',
                        'type' => 'switch',
                        'title' => esc_html__('Search menu item', 'greenmart'),
                        'required' => array('menu_mobile_type','=','smart_menu'),
                        'default' => false
                    ),                                     
                    array(
                        'id'       => 'menu_mobile_search_items',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Search item menu placeholder', 'greenmart' ),
                        'required' => array('enable_menu_mobile_search','=', true),
                        'default'  => esc_html__( 'Search in menu...', 'greenmart' ),
                    ),                    
                    array(
                        'id'       => 'menu_mobile_no_esults',
                        'type'     => 'text',
                        'title'    => esc_html__( '“No results” text', 'greenmart' ),
                        'required' => array('enable_menu_mobile_search','=', true),
                        'default'  => esc_html__( 'No results found.', 'greenmart' ),
                    ),                    
                    array(
                        'id'       => 'menu_mobile_search_splash',
                        'type'     => 'textarea',
                        'title'    => esc_html__( 'Search text splash', 'greenmart' ),
                        'required' => array('enable_menu_mobile_search','=', true),
                        'default'  => esc_html__( 'What are you looking for? </br> Start typing to search the menu.', 'greenmart' ),
                    ),
                    array(
                        'id' => 'enable_menu_mobile_counters',
                        'type' => 'switch',
                        'title' => esc_html__('Menu mobile counters', 'greenmart'),
                        'required' => array('menu_mobile_type','=','smart_menu'),
                        'default' => false
                    ),                     
                    array(
                        'id' => 'enable_menu_social',
                        'type' => 'switch',
                        'title' => esc_html__('Menu mobile social', 'greenmart'),
                        'required' => array('menu_mobile_type','=','smart_menu'),
                        'default' => false
                    ), 

                    array(
                        'id'          => 'menu_social_slides',
                        'type'        => 'slides',
                        'title'       => esc_html__( 'Menu mobile social slides', 'greenmart' ),
                        'desc'        => esc_html__( 'This social will store all slides values into a multidimensional array to use into a foreach loop.', 'greenmart' ),
                        'class' => 'remove-upload-slides',
                        'show' => array(
                            'title' => true,
                            'description' => false,
                            'url' => true,
                        ),
                        'required' => array('enable_menu_social','=', true),
                        'placeholder'   => array(
                            'title'      => esc_html__( 'Enter icon name', 'greenmart' ),
                            'url'       => esc_html__( 'Link icon', 'greenmart' ),
                        ),
                    ),
                    array(
                        'id'   => 'opt-divide',
                        'class' => 'big-divide',
                        'type' => 'divide'
                    ),

                    array(
                        'id'       => 'menu_mobile_one_select',
                        'type'     => 'select',
                        'data'     => 'menus',
                        'title'    => esc_html__( 'Main menu', 'greenmart' ),
                        'subtitle' => '<em>'.esc_html__('Tab 1 menu option', 'greenmart').'</em>',
                        'desc'     => esc_html__( 'Select the menu you want to display.', 'greenmart' ),
                    ),
                    array(
                        'id'       => 'menu_mobile_tab_one',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Tab 1 title', 'greenmart' ),
                        'required' => array('enable_menu_second','=', true),
                        'default'  => esc_html__( 'Menu', 'greenmart' ),
                    ), 
                    array(
                        'id'       => 'menu_mobile_tab_one_icon',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Tab 1 icon', 'greenmart' ),
                        'required' => array('enable_menu_second','=', true),
                        'desc'     => esc_html__( 'Enter icon name of font: awesome, simplelineicons', 'greenmart' ),
                        'default'  => 'icon-menu icons',
                    ), 
                    array(
                        'id' => 'enable_menu_second',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Tab 2', 'greenmart'),
                        'required' => array('menu_mobile_type','=','smart_menu'),
                        'default' => false
                    ),    

                    array(
                        'id'       => 'menu_mobile_tab_scond',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Tab 2 title', 'greenmart' ),
                        'required' => array('enable_menu_second','=', true),
                        'default'  => esc_html__( 'Categories', 'greenmart' ),
                    ), 

                    array(
                        'id'       => 'menu_mobile_second_select',
                        'type'     => 'select',
                        'data'     => 'menus',
                        'title'    => esc_html__( 'Tab 2 menu option', 'greenmart' ),
                        'required' => array('enable_menu_second','=', true),
                        'desc'     => esc_html__( 'Select the menu you want to display.', 'greenmart' ),
                    ),
                    array(
                        'id'       => 'menu_mobile_tab_second_icon',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Tab 2 icon', 'greenmart' ),
                        'required' => array('enable_menu_second','=', true),
                        'desc'     => esc_html__( 'Enter icon name of font: awesome, simplelineicons', 'greenmart' ),
                        'default'  => 'icon-grid icons',
                    ), 
                )
            );

            // Mobile Header settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Woocommerce mobile', 'greenmart'),
                'fields' => array(
                    array(
                        'id' => 'enable_add_cart_mobile',
                        'type' => 'switch',
                        'title' => esc_html__('Show Add to Cart on Mobile (Home Page and Shop Page)', 'greenmart'),
                        'default' => false
                    ),                      
                    array(
                        'id' => 'disable_add_cart_fixed',
                        'type' => 'switch',
                        'title' => esc_html__('Disable Add to cart fixed on mobile (Single Product page)', 'greenmart'),
                        'default' => false
                    ),                      
                    array(
                        'id' => 'disable_redirect_add_to_cart',
                        'type' => 'switch',
                        'title' => esc_html__('Disable redirect add to cart to page cart on mobile (Single Product Page)', 'greenmart'),
                        'default' => true
                    ),  
                    array(
                        'id' => 'enable_quantity_mobile',
                        'type' => 'switch',
                        'title' => esc_html__('Show Quantity on Mobile (Single Product Page)', 'greenmart'),
                        'default' => false
                    ),              
                )
            );

            // Style
            $this->sections[] = array(
                'icon' => 'el el-icon-css',
                'title' => esc_html__('Style', 'greenmart'),
                'fields' => array(
                    array (
                        'title' => esc_html__('Main Theme Color', 'greenmart'),
                        'subtitle' => '<em>'.esc_html__('The main color of the site.', 'greenmart').'</em>',
                        'id' => 'main_color',
                        'type' => 'color',
                        'transparent' => false,
                        'default' => '',
                    ),
                )
            );
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Typography', 'greenmart'),
                'fields' => array(
                    array(
                        'id' => 'show_typography', 
                        'type' => 'switch',
                        'title' => esc_html__('Typography', 'greenmart'),
                        'default' => false
                    ),
                    array(
                        'title'    => esc_html__('Font Source', 'greenmart'),
                        'subtitle' => '<em>'.esc_html__('Choose the Font Source', 'greenmart').'</em>',
                        'id'       => 'font_source',
                        'type'     => 'radio',
                        'required' => array('show_typography','=', true),
                        'options'  => array(
                            '1' => 'Standard + Google Webfonts',
                            '2' => 'Google Custom',
                            '3' => 'Custom Fonts'
                        ),
                        'default' => '1'
                    ),
                    array(
                        'id'=>'font_google_code',
                        'type' => 'text',
                        'title' => esc_html__('Google Code', 'greenmart'), 
                        'subtitle' => '<em>'.esc_html__('Paste the provided Google Code', 'greenmart').'</em>',
                        'default' => 'https://fonts.googleapis.com/css?family=Yantramanav|Poppins:400,700',
                        'required' => array('font_source','=','2')
                    ),

                    array (
                        'id' => 'main_custom_font_info',
                        'icon' => true,
                        'type' => 'info',
                        'raw' => '<h3 style="margin: 0;">'. sprintf(
                                                                    '%1$s <a href="%2$s">%3$s</a>',
                                                                    esc_html__( 'Video guide custom font in ', 'greenmart' ),
                                                                    esc_url( 'https://www.youtube.com/watch?v=ljXAxueAQUc' ),
                                                                    esc_html__( 'here', 'greenmart' )
                                ) .'</h3>',
                        'required' => array('font_source','=','3')
                    ),

                    array (
                        'id' => 'main_font_info',
                        'icon' => true,
                        'type' => 'info',
                        'raw' => '<h3 style="margin: 0;"> '.esc_html__('Main Font', 'greenmart').'</h3>',
                        'required' => array('show_typography','=', true),
                    ),
                    // Standard + Google Webfonts
                    array (
                        'title' => esc_html__('Font Face', 'greenmart'),
                        'subtitle' => '<em>'.esc_html__('Pick the Main Font for your site.', 'greenmart').'</em>',
                        'id' => 'main_font',
                        'type' => 'typography',
                        'line-height' => false,
                        'text-align' => false,
                        'font-style' => false,
                        'font-weight' => false,
                        'all_styles'=> true,
                        'font-size' => false,
                        'color' => false,
                        'default' => array (
                            'font-family' => 'Roboto',
                            'subsets' => '',
                        ),
                        'required' => array('font_source','=','1')
                    ),
                    
                    // Google Custom                        
                    array (
                        'title' => esc_html__('Google Font Face', 'greenmart'),
                        'subtitle' => '<em>'.esc_html__('Enter your Google Font Name for the theme\'s Main Typography', 'greenmart').'</em>',
                        'desc' => esc_html__('e.g.: open sans', 'greenmart'),
                        'id' => 'main_google_font_face',
                        'type' => 'text',
                        'default' => 'Roboto',
                        'required' => array('font_source','=','2')
                    ),

                    // main Custom fonts                      
                    array (
                        'title' => esc_html__('Main custom Font Face', 'greenmart'),
                        'subtitle' => '<em>'.esc_html__('Enter your Custom Font Name for the theme\'s Main Typography', 'greenmart').'</em>',
                        'desc' => esc_html__('e.g.: &#39;Open Sans&#39;, sans-serif', 'greenmart'),
                        'id' => 'main_custom_font_face',
                        'type' => 'text',
                        'default' => '',
                        'required' => array('font_source','=','3')
                    ),

                    array (
                        'id' => 'secondary_font_info',
                        'icon' => true,
                        'type' => 'info',
                        'raw' => '<h3 style="margin: 0;"> '.esc_html__(' Secondary Font', 'greenmart').'</h3>',
                        'required' => array('show_typography','=', true),
                    ),
                    
                    // Standard + Google Webfonts
                    array (
                        'title' => esc_html__('Font Face', 'greenmart'),
                        'subtitle' => '<em>'.esc_html__('Pick the Secondary Font for your site.', 'greenmart').'</em>',
                        'id' => 'secondary_font',
                        'type' => 'typography',
                        'line-height' => false,
                        'text-align' => false,
                        'font-style' => false,
                        'font-weight' => false,
                        'all_styles'=> true,
                        'font-size' => false,
                        'color' => false,
                        'default' => array (
                            'font-family' => 'Pontano Sans',
                            'subsets' => '',
                        ),
                        'required' => array('font_source','=','1')
                        
                    ),
                    
                    // Google Custom                        
                    array (
                        'title' => esc_html__('Google Font Face', 'greenmart'),
                        'subtitle' => '<em>'.esc_html__('Enter your Google Font Name for the theme\'s Secondary Typography', 'greenmart').'</em>',
                        'desc' => esc_html__('e.g.: open sans', 'greenmart'),
                        'id' => 'secondary_google_font_face',
                        'type' => 'text',
                        'default' => 'Roboto',
                        'required' => array('font_source','=','2')
                    ),

                    // Main Custom fonts                        
                    array (
                        'title' => esc_html__('Main Custom Font Face', 'greenmart'),
                        'subtitle' => '<em>'. esc_html__('Enter your Custom Font Name for the theme\'s Secondary Typography', 'greenmart').'</em>',
                        'desc' => esc_html__('e.g.: &#39;Open Sans&#39;, sans-serif', 'greenmart'),
                        'id' => 'secondary_custom_font_face',
                        'type' => 'text',
                        'default' => '',
                        'required' => array('font_source','=','3')
                    ),
                )
            );
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Top Bar', 'greenmart'),
                'fields' => array(
                    array(
                        'id'=>'topbar_bg',
                        'type' => 'background',
                        'title' => esc_html__('Background', 'greenmart'),
                        'default' => array(
                            'background-color' => ''
                        )
                    ),
                    array(
                        'title' => esc_html__('Text Color', 'greenmart'),
                        'id' => 'topbar_text_color',
                        'type' => 'color',
                        'transparent' => false,
                        'default' => '',
                    ),
                    array(
                        'title' => esc_html__('Link Color', 'greenmart'),
                        'id' => 'topbar_link_color',
                        'type' => 'color',
                        'transparent' => false,
                        'default' => '',
                    ),
                )
            );
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Header', 'greenmart'),
                'fields' => array(
                    array(
                        'id'=>'header_bg',
                        'type' => 'background',
                        'title' => esc_html__('Background', 'greenmart'),
                        'default' => array(
                            'background-color' => ''
                        )
                    ),
                    array(
                        'title' => esc_html__('Text Color', 'greenmart'),
                        'id' => 'header_text_color',
                        'type' => 'color',
                        'transparent' => false,
                        'default' => '',
                    ),
                    array(
                        'title' => esc_html__('Link Color', 'greenmart'),
                        'id' => 'header_link_color',
                        'type' => 'color',
                        'transparent' => false,
                        'default' => '',
                    ),
                    array(
                        'title' => esc_html__('Link Color Active', 'greenmart'),
                        'id' => 'header_link_color_active',
                        'type' => 'color',
                        'transparent' => false,
                        'default' => '',
                    ),
                )
            );
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Main Menu', 'greenmart'),
                'fields' => array(
                    array(
                        'title' => esc_html__('Link Color', 'greenmart'),
                        'id' => 'main_menu_link_color',
                        'type' => 'color',
                        'transparent' => false,
                        'default' => '',
                    ),
                    array(
                        'title' => esc_html__('Link Color Active', 'greenmart'),
                        'id' => 'main_menu_link_color_active',
                        'type' => 'color',
                        'transparent' => false,
                        'default' => '',
                    ),
                )
            );
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Footer', 'greenmart'),
                'fields' => array(
                    array(
                        'id'=>'footer_bg',
                        'type' => 'background',
                        'title' => esc_html__('Background', 'greenmart'),
                        'default' => array(
                            'background-color' => ''
                        )
                    ),
                    array(
                        'title' => esc_html__('Heading Color', 'greenmart'),
                        'id' => 'footer_heading_color',
                        'type' => 'color',
                        'transparent' => false,
                        'default' => '',
                    ),
                    array(
                        'title' => esc_html__('Text Color', 'greenmart'),
                        'id' => 'footer_text_color',
                        'type' => 'color',
                        'transparent' => false,
                        'default' => '',
                    ),
                    array(
                        'title' => esc_html__('Link Color', 'greenmart'),
                        'id' => 'footer_link_color',
                        'type' => 'color',
                        'transparent' => false,
                        'default' => '',
                    ),
                    array(
                        'title' => esc_html__('Link Color Hover', 'greenmart'),
                        'id' => 'footer_link_color_hover',
                        'type' => 'color',
                        'transparent' => false,
                        'default' => '',
                    ),
                )
            );
            
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Copyright', 'greenmart'),
                'fields' => array(
                    array(
                        'id'=>'copyright_bg',
                        'type' => 'background',
                        'title' => esc_html__('Background', 'greenmart'),
                        'default' => array(
                            'background-color' => ''
                        )
                    ),
                    array(
                        'title' => esc_html__('Text Color', 'greenmart'),
                        'id' => 'copyright_text_color',
                        'type' => 'color',
                        'transparent' => false,
                        'default' => '',
                    ),
                    array(
                        'title' => esc_html__('Link Color', 'greenmart'),
                        'id' => 'copyright_link_color',
                        'type' => 'color',
                        'transparent' => false,
                        'default' => '',
                    ),
                    array(
                        'title' => esc_html__('Link Color Hover', 'greenmart'),
                        'id' => 'copyright_link_color_hover',
                        'type' => 'color',
                        'transparent' => false,
                        'default' => '',
                    ),
                )
            );

            // Social Media
            $this->sections[] = array(
                'icon' => 'el el-file',
                'title' => esc_html__('Social Share', 'greenmart'),
                'fields' => array(
                    array(
                        'id' => 'enable_code_share',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Code Share', 'greenmart'),
                        'default' => true
                    ),
                    array(
                        'id'        =>'code_share',
                        'type'      => 'textarea',
                        'title'     => esc_html__('Addthis your code', 'greenmart'), 
                        'subtitle'  => esc_html__('Addthis your code', 'greenmart'),
                        'desc'      => esc_html__('You get your code share in https://www.addthis.com', 'greenmart'),
                        'validate'  => 'html_custom',
                        'default'   => '<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-59f2a47d2f1aaba2"></script>'
                    ),
                )
            );

            // Performance
            $this->sections[] = array(
                'icon' => 'el-icon-cog',
                'title' => esc_html__('Performance', 'greenmart'),
            );   
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Performance', 'greenmart'),
                'fields' => array(
                    array (
                        'id'       => 'minified_js',
                        'type'     => 'switch',
                        'title'    => esc_html__('Include minified JS', 'greenmart'),
                        'subtitle' => esc_html__('Minified version of functions.js and device.js file will be loaded', 'greenmart'),
                        'default' => true
                    ),
                )
            );

            // Custom Code
            $this->sections[] = array(
                'icon' => 'el-icon-css',
                'title' => esc_html__('Custom CSS/JS', 'greenmart'),
            );            

            // Css Custom Code
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Custom CSS', 'greenmart'),
                'fields' => array(
                    array (
                        'title' => esc_html__('Global Custom CSS', 'greenmart'),
                        'id' => 'custom_css',
                        'type' => 'ace_editor',
                        'mode' => 'css',
                    ),
                    array (
                        'title' => esc_html__('Custom CSS for desktop (Larger than 1024px)', 'greenmart'),
                        'id' => 'css_desktop',
                        'type' => 'ace_editor',
                        'mode' => 'css',
                    ),
                    array (
                        'title' => esc_html__('Custom CSS for tablet ( Screen area 768px to 1023px)', 'greenmart'),
                        'id' => 'css_tablet',
                        'type' => 'ace_editor',
                        'mode' => 'css',
                    ),
                    array (
                        'title' => esc_html__('Custom CSS for mobile landscape (Screen area 481px to 767px)', 'greenmart'),
                        'id' => 'css_wide_mobile',
                        'type' => 'ace_editor',
                        'mode' => 'css',
                    ),
                    array (
                        'title' => esc_html__('Custom CSS for mobile (Screen smaller 480px)', 'greenmart'),
                        'id' => 'css_mobile',
                        'type' => 'ace_editor',
                        'mode' => 'css',
                    ),
                )
            );

            // Js Custom Code
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Custom Js', 'greenmart'),
                'fields' => array(
                    array (
                        'title' => esc_html__('Header JavaScript Code', 'greenmart'),
                        'subtitle' => '<em>'.esc_html__('Paste your custom JS code here. The code will be added to the header of your site.', 'greenmart').'<em>',
                        'id' => 'header_js',
                        'type' => 'ace_editor',
                        'mode' => 'javascript',
                    ),
                    
                    array (
                        'title' => esc_html__('Footer JavaScript Code', 'greenmart'),
                        'subtitle' => '<em>'.esc_html__('Here is the place to paste your Google Analytics code or any other JS code you might want to add to be loaded in the footer of your website.', 'greenmart').'<em>',
                        'id' => 'footer_js',
                        'type' => 'ace_editor',
                        'mode' => 'javascript',
                    ),
                )
            );

            $this->sections[] = array(
                'title' => esc_html__('Import / Export', 'greenmart'),
                'desc' => esc_html__('Import and Export your Redux Framework settings from file, text or URL.', 'greenmart'),
                'icon' => 'el-icon-refresh',
                'fields' => array(
                    array(
                        'id' => 'opt-import-export',
                        'type' => 'import_export',
                        'title' => 'Import Export',
                        'subtitle' => 'Save and restore your Redux options',
                        'full_width' => false,
                    ),
                ),
            );

            $this->sections[] = array(
                'type' => 'divide',
            );
        }
        /**
         * All the possible arguments for Redux.
         * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
         * */
        public function setArguments()
        {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name' => 'greenmart_tbay_theme_options',
                // This is where your data is stored in the database and also becomes your global variable name.
                'display_name' => $theme->get('Name'),
                // Name that appears at the top of your panel
                'display_version' => $theme->get('Version'),
                // Version that appears at the top of your panel
                'menu_type' => 'menu',
                //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu' => true,
                // Show the sections below the admin menu item or not
                'menu_title' => esc_html__('Greenmart Options', 'greenmart'),
                'page_title' => esc_html__('Greenmart Options', 'greenmart'),

                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => '',
                // Set it you want google fonts to update weekly. A google_api_key value is required.
                'google_update_weekly' => false,
                // Must be defined to add google fonts to the typography module
                'async_typography' => true,
                // Use a asynchronous font on the front end or font string
                //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                'admin_bar' => true,
                // Show the panel pages on the admin bar
                'admin_bar_icon' => 'dashicons-portfolio',
                // Choose an icon for the admin bar menu
                'admin_bar_priority' => 50,
                // Choose an priority for the admin bar menu
                'global_variable' => 'tbay_options',
                // Set a different name for your global variable other than the opt_name
                'dev_mode' => false,
				'forced_dev_mode_off' => false,
                // Show the time the page took to load, etc
                'update_notice' => true,
                // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
                'customizer' => true,
                // Enable basic customizer support
                //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                // OPTIONAL -> Give you extra features
                'page_priority' => null,
                // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent' => 'themes.php',
                // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions' => 'manage_options',
                // Permissions needed to access the options panel.
                'menu_icon' => '',
                // Specify a custom URL to an icon
                'last_tab' => '',
                // Force your panel to always open to a specific tab (by id)
                'page_icon' => 'icon-themes',
                // Icon displayed in the admin panel next to your menu_title
                'page_slug' => '_options',
                // Page slug used to denote the panel
                'save_defaults' => true,
                // On load save the defaults to DB before user clicks save or not
                'default_show' => false,
                // If true, shows the default value next to each field that is not the default value.
                'default_mark' => '',
                // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,
                // Shows the Import/Export panel when not used as a field.

                // CAREFUL -> These options are for advanced use only
                'transient_time' => 60 * MINUTE_IN_SECONDS,
                'output' => true,
                // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag' => true,
                // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database' => '',
                // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info' => false,
                // REMOVE

                // HINTS
                'hints' => array(
                    'icon' => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color' => 'lightgray',
                    'icon_size' => 'normal',
                    'tip_style' => array(
                        'color' => 'light',
                        'shadow' => true,
                        'rounded' => false,
                        'style' => '',
                    ),
                    'tip_position' => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect' => array(
                        'show' => array(
                            'effect' => 'slide',
                            'duration' => '500',
                            'event' => 'mouseover',
                        ),
                        'hide' => array(
                            'effect' => 'slide',
                            'duration' => '500',
                            'event' => 'click mouseleave',
                        ),
                    ),
                )
            );
            
            $this->args['intro_text'] = '';

            // Add content after the form.
            $this->args['footer_text'] = '';
            return $this->args;
        }
    }

    global $reduxConfig;
    $reduxConfig = new greenmart_Redux_Framework_Config();
}