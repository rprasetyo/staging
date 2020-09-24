<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage greenmart
 * @since greenmart 2.1.6
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>	
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php $tbay_header = apply_filters( 'greenmart_tbay_get_header_layout', greenmart_tbay_get_config('header_type') );
		if ( empty($tbay_header) ) {
			$tbay_header = 'v1';
		}
		$active_theme = greenmart_tbay_get_theme();
	?>
<div id="wrapper-container" class="wrapper-container <?php echo esc_attr($tbay_header); ?>">

	<?php greenmart_tbay_get_page_templates_parts('offcanvas-menu'); ?>
	<?php greenmart_tbay_get_page_templates_parts('offcanvas-smartmenu'); ?>

	<?php greenmart_tbay_get_page_templates_parts('device/topbar-mobile'); ?>
	
	<?php 
		if( greenmart_tbay_get_config('mobile_footer_icon',true) ) {
			greenmart_tbay_get_page_templates_parts('device/footer-mobile');
		}
	 ?>

	<?php greenmart_tbay_get_page_templates_parts('topbar-mobile'); ?>

	
	<?php 
	
		if( $active_theme != 'organic') { 
			get_template_part( 'headers/themes/'.$active_theme.'/'.$tbay_header );
		} else {
			get_template_part( 'headers/'.$tbay_header );
		}

	?>

	<div id="tbay-main-content">
