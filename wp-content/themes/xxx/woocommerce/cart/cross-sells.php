<?php
/**
 * Cross-sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

if ( sizeof( $cross_sells ) == 0 ) {
	return;
}

$current_theme = greenmart_tbay_get_theme();

if( $current_theme != 'organic' ) {
	$woocommerce_loop['columns'] = 4;
	$columns_desktopsmall = 4;
	$columns_tablet = 4;
	$columns_mobile = 2;
} else {	
	$woocommerce_loop['columns'] = 2;
	$columns_desktopsmall = 2;
	$columns_tablet = 2;
	$columns_mobile = 2;
}


$rows = 1;


$active_theme = greenmart_tbay_get_part_theme();

if ( $cross_sells ) : ?>

	<div class="cross-sells related products widget ">
		<h3 class="widget-title"><span><?php esc_html_e( 'You may be like', 'greenmart' ) ?></h3>

		<?php  wc_get_template( 'layout-products/'.$active_theme.'/carousel-related.php' , array( 'loops'=>$cross_sells,'rows' => $rows, 'pagi_type' => 'no', 'nav_type' => 'yes','columns'=>$woocommerce_loop['columns'],'screen_desktop'=>$woocommerce_loop['columns'],'screen_desktopsmall'=>$columns_desktopsmall,'screen_tablet'=>$columns_tablet,'screen_mobile'=>$columns_mobile ) ); ?>

	</div>

<?php endif;

wp_reset_query();
