<?php
/**
 * greenmart functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage greenmart
 * @since greenmart 2.3
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since greenmart 2.3
 */
define( 'GREENMART_THEME_VERSION', '2.3' );

if ( ! isset( $content_width ) ) {
	$content_width = 660;
}

/**
 * ------------------------------------------------------------------------------------------------
 * Define constants.
 * ------------------------------------------------------------------------------------------------
 */
define( 'GREENMART_THEME_DIR', 		get_template_directory_uri() );
define( 'GREENMART_THEMEROOT', 		get_template_directory() );
define( 'GREENMART_IMAGES', 			GREENMART_THEME_DIR . '/images' );
define( 'GREENMART_SCRIPTS', 			GREENMART_THEME_DIR . '/js' );
define( 'GREENMART_SCRIPTS_SKINS', 	GREENMART_SCRIPTS . '/skins' );
define( 'GREENMART_STYLES', 			GREENMART_THEME_DIR . '/css' );
define( 'GREENMART_STYLES_SKINS', 	GREENMART_STYLES . '/skins' );

define( 'GREENMART_INC', 				'/inc' );
define( 'GREENMART_CLASSES', 			GREENMART_INC . '/classes' );
define( 'GREENMART_VENDORS', 			GREENMART_INC . '/vendors' );
define( 'GREENMART_WIDGETS', 			GREENMART_INC . '/widgets' );

define( 'GREENMART_ASSETS', 			GREENMART_THEME_DIR . '/inc/assets' );
define( 'GREENMART_ASSETS_IMAGES', 	GREENMART_ASSETS    . '/images' );

define( 'GREENMART_MIN_JS', '' );
 

if ( ! function_exists( 'greenmart_tbay_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since greenmart 2.1.6
 */
function greenmart_tbay_setup() {
 
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on greenmart, use a find and replace
	 * to change 'greenmart' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'greenmart', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style( array( 'css/editor-style.css', greenmart_fonts_url() ) );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	add_theme_support( "woocommerce" );
	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );

	$color_scheme  = greenmart_tbay_get_color_scheme();
	$default_color = trim( $color_scheme[0], '#' );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'greenmart_custom_background_args', array(
		'default-color'      => $default_color,
		'default-attachment' => 'fixed',
	) ) );
	
	greenmart_tbay_get_load_plugins();
	greenmart_tbay_private_get_load_plugins();
}
endif; // greenmart_tbay_setup
add_action( 'after_setup_theme', 'greenmart_tbay_setup' );

/*
* Remove config default media
*
*/
if(greenmart_tbay_get_global_config('config_media',false)) {
	remove_action( 'after_setup_theme', 'theme_setup_size_image' );
}



function greenmart_tbay_include_files($path) {
    $files = glob( $path );
    if ( ! empty( $files ) ) {
        foreach ( $files as $file ) {
            include $file;
        }
    }
}

/**
 * Enqueue scripts and styles.
 *
 * @since greenmart 2.1.6
 */
function greenmart_tbay_scripts() { 
	
	$menu_option 	= apply_filters( 'greenmart_menu_mobile_option', 10,2 );
	$suffix 		= (greenmart_tbay_get_config('minified_js', false)) ? '.min' : GREENMART_MIN_JS;

	//load font awesome
	wp_register_style( 'font-awesome', GREENMART_STYLES . '/font-awesome.css', array(), '4.5.0' );

	//load font custom icon tbay
	wp_register_style( 'font-tbay', GREENMART_STYLES . '/font-tbay-custom.css', array(), '1.0.0' );
	
	//load font simple-line-icons
	wp_register_style( 'simple-line-icons', GREENMART_STYLES . '/simple-line-icons.css', array(), '2.4.0' );
	
	//load font material-design-iconic-font
	wp_register_style( 'material-design-iconic-font', GREENMART_STYLES . '/material-design-iconic-font.min.css', array(), '2.2.0' );
	
	//load font ico-font
	wp_enqueue_style( 'icofont', GREENMART_STYLES . '/icofont.css', array(), '1.0.1' );
	
	//load font themify-icons
	wp_register_style( 'themify-icons', GREENMART_STYLES . '/themify-icons.css', array(), '4.8.1' );

	// load animate version 3.5.0
	wp_enqueue_style( 'animate', GREENMART_STYLES . '/animate.css', array(), '3.5.0' );

	$skin = greenmart_tbay_get_theme();
	// Load our main stylesheet.
	if( is_rtl() ){
		
		if ( $skin != 'default' && $skin ) {
			$css_path =  GREENMART_STYLES_SKINS . '/'.$skin.'/template.rtl.css';
		} else {
			$css_path =  GREENMART_STYLES . '/template.rtl.css';
		}
	}
	else{
		if ( $skin != 'default' && $skin ) {
			$css_path =  GREENMART_STYLES_SKINS . '/'.$skin.'/template.css';
		} else {
			$css_path =  GREENMART_STYLES . '/template.css';
		}
	}
	wp_enqueue_style( 'greenmart-template', $css_path, array('font-awesome', 'font-tbay', 'simple-line-icons', 'material-design-iconic-font', 'themify-icons'), GREENMART_THEME_VERSION );
	
	$footer_style = greenmart_tbay_print_style_footer();
	if ( !empty($footer_style) ) {
		wp_add_inline_style( 'greenmart-template', $footer_style );
	}
	$custom_style = greenmart_tbay_custom_styles();
	if ( !empty($custom_style) ) {
		wp_add_inline_style( 'greenmart-template', $custom_style );
	}
	
	
	// load Sumoselect version 1.0.0
	wp_enqueue_style('sumoselect', GREENMART_STYLES . '/sumoselect.css', array(), '1.0.0', 'all');
	// Add js Sumoselect version 3.0.2
	wp_enqueue_script('jquery-sumoselect', GREENMART_SCRIPTS . '/jquery.sumoselect' . $suffix . '.js', array(), '3.0.2', TRUE);


	// load fancybox
	wp_enqueue_style( 'jquery-fancybox', GREENMART_STYLES . '/jquery.fancybox.css', array(), '3.2.0' );
	wp_enqueue_script( 'jquery-fancybox', GREENMART_SCRIPTS . '/jquery.fancybox' . $suffix . '.js', array( 'jquery' ), '20150315', true );
	
	wp_enqueue_script( 'greenmart-skip-link-fix', GREENMART_SCRIPTS . '/greenmart-skip-link-fix' . $suffix . '.js', array(), '20141010', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_dequeue_script('revmin');
	wp_enqueue_script( 'revmin');

	/*mmenu menu*/
	if( $menu_option == 'smart_menu' ){
		wp_enqueue_script( 'jquery-mmenu', GREENMART_SCRIPTS . '/jquery.mmenu' . $suffix . '.js', array( 'jquery' ), '7.0.5', true );
	}

	wp_register_script( 'jquery-instagramfeed', GREENMART_SCRIPTS . '/jquery.instagramfeed' . $suffix . '.js', array( 'jquery' ),'1.1.3', true );
	wp_register_script( 'jquery-timeago', GREENMART_SCRIPTS . '/jquery.timeago' . $suffix . '.js', array( 'jquery' ),'1.6.7', true );

	/*Treeview menu*/
	wp_enqueue_style( 'jquery-treeview', GREENMART_STYLES . '/jquery.treeview.css', array(), '1.0.0' );
	wp_enqueue_script( 'jquery-treeview', GREENMART_SCRIPTS . '/jquery.treeview' . $suffix . '.js', array( 'jquery' ), '20150330', true );

	
	wp_enqueue_script( 'bootstrap', GREENMART_SCRIPTS . '/bootstrap' . $suffix . '.js', array( 'jquery' ), '20150330', true );
	
 
	wp_dequeue_script('wpb_composer_front_js');
	wp_enqueue_script( 'wpb_composer_front_js');
	
	wp_enqueue_script( 'owl-carousel', GREENMART_SCRIPTS . '/owl.carousel' . $suffix . '.js', array( 'jquery' ), '2.3.4', true );

	wp_enqueue_script( 'greenmart-woocommerce', GREENMART_SCRIPTS . '/woocommerce' . $suffix . '.js', array( 'jquery' ), GREENMART_THEME_VERSION, true );

	wp_enqueue_script( 'jquery-countdowntimer', GREENMART_SCRIPTS . '/jquery.countdownTimer' . $suffix . '.js', array( 'jquery' ), '1.0.0', true );

	wp_register_script( 'greenmart-script',  GREENMART_SCRIPTS . '/functions' . $suffix . '.js', array( 'jquery' ), GREENMART_THEME_VERSION, true );
	wp_localize_script( 'greenmart-script', 'greenmart_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));

	wp_register_script( 'greenmart-skins-script', GREENMART_SCRIPTS_SKINS . '/'.$skin.'/functions' . $suffix . '.js', array( 'greenmart-script' ), GREENMART_THEME_VERSION, true );

	wp_enqueue_script( 'greenmart-skins-script' );
	if ( greenmart_tbay_get_config('header_js') != "" ) {
		wp_add_inline_script( 'jquery-core', greenmart_tbay_get_config('header_js') );
	}
	
	wp_enqueue_style( 'greenmart-style', GREENMART_STYLES . '/style.css', GREENMART_THEME_VERSION, '1.0' );


	$translate = array( 
		'active_theme' => greenmart_tbay_get_config('active_theme', 'organic'), 
		'cancel' => esc_html__('cancel', 'greenmart'),
		'mobile' => (wp_is_mobile()) ? true : false,
		'search' => esc_html__('Search', 'greenmart'),
		'view_all' => esc_html__('View All', 'greenmart'),
		'instagram_private' => esc_html__('This profile is private', 'greenmart'),
		'timeago'				=> array( 
			'suffixAgo'			=> esc_html__('ago', 'greenmart'),
			'suffixFromNow'		=> esc_html__('from now', 'greenmart'),
			'inPast'			=> esc_html__('any moment now', 'greenmart'),
			'seconds'			=> esc_html__('less than a minute', 'greenmart'),
			'minute'			=> esc_html__('about a minute', 'greenmart'),
			'minutes'			=> esc_html__('%d minutes', 'greenmart'),
			'hour'				=> esc_html__('about an hour', 'greenmart'),
			'hours'				=> esc_html__('about %d hours', 'greenmart'),
			'day'				=> esc_html__('a day', 'greenmart'),
			'days'				=> esc_html__('%d days', 'greenmart'),
			'month'				=> esc_html__('about a month', 'greenmart'),
			'months'			=> esc_html__('%d months', 'greenmart'),
			'year'				=> esc_html__('about a year', 'greenmart'),
			'years'				=> esc_html__('%d years', 'greenmart'),
		)
	);

	if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		$translate['ajax_single_add_to_cart'] 	= (bool) greenmart_tbay_get_config('ajax_single_add_to_cart', false);
		$translate['ajax_update_quantity'] 	= (bool) greenmart_tbay_get_config('ajax_update_quantity', true);
	}

 

	wp_localize_script( 'greenmart-script', 'greenmart_settings', $translate );

}
add_action( 'wp_enqueue_scripts', 'greenmart_tbay_scripts', 100 );

function greenmart_tbay_footer_scripts() {
	if ( greenmart_tbay_get_config('footer_js') != "" ) {
		$footer_js = greenmart_tbay_get_config('footer_js');
		echo trim($footer_js);
	}
}
add_action('wp_footer', 'greenmart_tbay_footer_scripts');

add_action( 'admin_enqueue_scripts', 'greenmart_tbay_load_admin_styles' );
function greenmart_tbay_load_admin_styles() {
	wp_enqueue_style( 'greenmart-custom-admin', get_template_directory_uri() . '/css/admin/custom-admin.css', false, '1.0.0' );
}  


/**
 * Display descriptions in main navigation.
 *
 * @since greenmart 2.1.6
 *
 * @param string  $item_output The menu item output.
 * @param WP_Post $item        Menu item object.
 * @param int     $depth       Depth of the menu.
 * @param array   $args        wp_nav_menu() arguments.
 * @return string Menu item with possible description.
 */
function greenmart_tbay_nav_description( $item_output, $item, $depth, $args ) {
	if ( 'primary' == $args->theme_location && $item->description ) {
		$item_output = str_replace( $args->link_after . '</a>', '<div class="menu-item-description">' . $item->description . '</div>' . $args->link_after . '</a>', $item_output );
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'greenmart_tbay_nav_description', 10, 4 );

/**
 * Add a `screen-reader-text` class to the search form's submit button.
 *
 * @since greenmart 2.1.6
 *
 * @param string $html Search form HTML.
 * @return string Modified search form HTML.
 */
function greenmart_tbay_search_form_modify( $html ) {
	return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
}
add_filter( 'get_search_form', 'greenmart_tbay_search_form_modify' );

function greenmart_tbay_get_config($name, $default = '') {
	global $tbay_options;
    if ( isset($tbay_options[$name]) ) {
        return $tbay_options[$name];
    }
    return $default;
}

if ( ! function_exists( 'greenmart_time_link' ) ) :
/**
 * Gets a nicely formatted string for the published date.
 */
function greenmart_time_link() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	$time_string = sprintf( $time_string,
		get_the_date( DATE_W3C ),
		get_the_date(),
		get_the_modified_date( DATE_W3C ),
		get_the_modified_date()
	);

	// Wrap the time string in a link, and preface it with 'Posted on'.
	return sprintf(
		/* translators: %s: post date */
		__( '<span class="screen-reader-text">Posted on</span> %s', 'greenmart' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);
}
endif;

function greenmart_tbay_get_global_config($name, $default = '') {
	$options = get_option( 'greenmart_tbay_theme_options', array() );
	if ( isset($options[$name]) ) {
        return $options[$name];
    }
    return $default;
}

function greenmart_tbay_get_load_plugins() {

	$plugins[] =(array(
		'name'                     => esc_html__( 'WooCommerce', 'greenmart' ),
	    'slug'                     => 'woocommerce',
	    'required'                 => true,
	));

	$plugins[] =(array(
		'name'                     => esc_html__( 'MailChimp', 'greenmart' ),
	    'slug'                     => 'mailchimp-for-wp',
	    'required'                 =>  true
	));

	$plugins[] =(array(
		'name'                     => esc_html__( 'Contact Form 7', 'greenmart' ),
	    'slug'                     => 'contact-form-7',
	    'required'                 => true,
	));

	$plugins[] =(array(
		'name'                     => esc_html__( 'WPBakery Visual Composer', 'greenmart' ),
		'slug'                     => 'js_composer',
		'required'                 => true,
		'source'         		   => esc_url( 'https://bitbucket.org/devthembay/update-plugin/raw/master/plugins/js_composer.zip' ),
	));

	$plugins[] =(array(
		'name'                     => esc_html__( 'Tbay Framework For Themes', 'greenmart' ),
		'slug'                     => 'tbay-framework',
		'required'                 => true ,
		'source'         		   => esc_url( 'https://bitbucket.org/devthembay/update-plugin/raw/master/plugins/tbay-framework.zip' ),
	));

	$plugins[] =(array(
		'name'                     => esc_html__( 'WooCommerce Variation Swatches', 'greenmart' ),
	    'slug'                     => 'woo-variation-swatches',
	    'required'                 =>  true,
	   	'source'         		   => esc_url( 'https://downloads.wordpress.org/plugin/woo-variation-swatches.zip' ),
	));	

	$plugins[] =(array(
		'name'                     => esc_html__( 'YITH WooCommerce Quick View', 'greenmart' ),
	    'slug'                     => 'yith-woocommerce-quick-view',
	    'required'                 =>  false
	));	

	$plugins[] =(array(
		'name'                     => esc_html__( 'YITH WooCommerce Frequently Bought Together', 'greenmart' ),
	    'slug'                     => 'yith-woocommerce-frequently-bought-together',
	    'required'                 =>  false
	));
	
	$plugins[] =(array(
		'name'                     => esc_html__( 'YITH WooCommerce Wishlist', 'greenmart' ),
	    'slug'                     => 'yith-woocommerce-wishlist',
	    'required'                 =>  false
	));

	$plugins[] =(array(
		'name'                     => esc_html__( 'YITH Woocommerce Compare', 'greenmart' ),
        'slug'                     => 'yith-woocommerce-compare',
        'required'                 => false
	));

	$plugins[] =(array(
		'name'                     => esc_html__( 'Revolution Slider', 'greenmart' ),
		'slug'                     => 'revslider',
		'required'                 => true ,
		'source'         		   => esc_url( 'https://bitbucket.org/devthembay/update-plugin/raw/master/plugins/revslider.zip' ),
	));
	
	tgmpa( $plugins );
}

require get_template_directory() . '/inc/plugins/class-tgm-plugin-activation.php';
require get_template_directory() . '/inc/functions-helper.php';
require_once( get_parent_theme_file_path( GREENMART_INC . '/skins/'.greenmart_tbay_get_theme().'/functions.php') );
require get_template_directory() . '/inc/functions-frontend.php';


/**
 * Implement the Custom Header feature.
 *
 */
require get_template_directory() . '/inc/custom-header.php';
require get_template_directory() . '/inc/classes/megamenu.php';
require get_template_directory() . '/inc/classes/custommenu.php';
require get_template_directory() . '/inc/classes/mmenu.php';

/**
 * Custom template tags for this theme.
 *
 */
require get_template_directory() . '/inc/template-tags.php'; 


if ( defined( 'TBAY_FRAMEWORK_REDUX_ACTIVED' ) ) {
	greenmart_tbay_include_files( get_template_directory() . '/inc/vendors/redux-framework/*.php' );
	define( 'GREENMART_REDUX_FRAMEWORK_ACTIVED', true );
}
if( in_array( 'cmb2/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	greenmart_tbay_include_files( get_template_directory() . '/inc/vendors/cmb2/*.php' );
	define( 'GREENMART_CMB2_ACTIVED', true );
}
if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	greenmart_tbay_include_files( get_template_directory() . '/inc/vendors/woocommerce/*.php' );
	define( 'GREENMART_WOOCOMMERCE_ACTIVED', true );
}
if( in_array( 'js_composer/js_composer.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	greenmart_tbay_include_files( get_template_directory() . '/inc/vendors/visualcomposer/*.php' );
	define( 'GREENMART_VISUALCOMPOSER_ACTIVED', true );
}
if( in_array( 'tbay-framework/tbay-framework.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	greenmart_tbay_include_files( get_template_directory() . '/inc/widgets/*.php' );
	define( 'GREENMART_TBAY_FRAMEWORK_ACTIVED', true ); 
	define( 'TBAY_FRAMEWORK_WIDGETS_ACTIVED', true );
}


/**
 * Customizer additions.
 *
 */ 

require_once( get_parent_theme_file_path( GREENMART_INC . '/skins/'.greenmart_tbay_get_theme().'/customizer.php') );

require_once( get_parent_theme_file_path( GREENMART_INC . '/skins/'.greenmart_tbay_get_theme().'/custom-styles.php') );