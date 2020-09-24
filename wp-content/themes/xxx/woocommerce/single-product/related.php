<?php
/**
 * Related Products
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

if ( empty( $product ) || ! $product->exists() ) {
	return;
}
if ( sizeof( $related_products ) == 0 ) return;


if( isset($_GET['releated_columns']) ) { 
	$woocommerce_loop['columns'] = $_GET['releated_columns'];
} else {
	$woocommerce_loop['columns'] = greenmart_tbay_get_config('releated_product_columns', 4);
}

$columns_desktopsmall = 3;
$columns_tablet = 2;
$columns_mobile = 2;
$rows = 1;

$active_theme = greenmart_tbay_get_part_theme();

$show_product_releated = greenmart_tbay_get_config('enable_product_releated', true);

if ( $related_products && $show_product_releated) : ?> 
	<div class="related products widget ">
		<h3 class="widget-title"><span><?php esc_html_e( 'Related Products', 'greenmart' ); ?></span></h3>
		<?php wc_get_template( 'layout-products/'.$active_theme.'/carousel-related.php' , array('loops'=>$related_products,'rows' => '1', 'pagi_type' => 'no', 'nav_type' => 'yes','columns'=>$woocommerce_loop['columns'],'screen_desktop'=>$woocommerce_loop['columns'],'screen_desktopsmall'=>'3','screen_tablet'=>'2','screen_mobile'=>'2' ) ); ?>

	</div>

<?php endif;

wp_reset_postdata(); 