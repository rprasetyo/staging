<?php 
global $product;

$time_sale = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
?>
   <div class="product-block grid clearfix" data-product-id="<?php echo esc_attr($product->get_id()); ?>">
		<div class="product-content row">
			<div class="block-inner col-md-6">
				<figure class="image">
					<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>" class="product-image">
						<?php
							/**
							* woocommerce_before_shop_loop_item_title hook
							*
							* @hooked woocommerce_show_product_loop_sale_flash - 10
							* @hooked woocommerce_template_loop_product_thumbnail - 10
							*/
							do_action( 'woocommerce_before_shop_loop_item_title' );
							
						?>
					</a>
				</figure>

				<div class="groups-button clearfix">
				<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
			
					<div class="button-wishlist">
						<?php
						$enabled_on_loop = 'yes' == get_option( 'yith_wcwl_show_on_loop', 'no' );
							if( class_exists( 'YITH_WCWL' ) || $enabled_on_loop ) {
							echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
						}
					?>   
					</div>
						
					<?php if( class_exists( 'YITH_Woocompare' ) ) { ?>
						<?php
							$action_add = 'yith-woocompare-add-product';
							$url_args = array(
								'action' => $action_add,
								'id' => $product->get_id()
							);
						?>
						<div class="yith-compare">
							<a href="<?php echo wp_nonce_url( add_query_arg( $url_args ), $action_add ); ?>" title="<?php echo esc_html__('Compare', 'greenmart'); ?>" class="compare" data-product_id="<?php echo esc_attr($product->get_id()); ?>">
								<i class="<?php echo greenmart_get_icon('icon_compare'); ?>"></i>
							</a>
						</div>
					<?php } ?>

					<?php if (class_exists('YITH_WCQV_Frontend')) { ?>
						<div><a href="#" class="button yith-wcqv-button" title="<?php echo esc_html__('Quick view', 'greenmart'); ?>"  data-product_id="<?php echo esc_attr($product->get_id()); ?>">
							<span>
								<i class="<?php echo greenmart_get_icon('icon_quick_view'); ?>"> </i>
							</span>
						</a></div>
					<?php } ?>
				</div>
			
			</div>
			<div class="caption col-md-6">
				<h3 class="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

				<?php
					/**
					* woocommerce_after_shop_loop_item_title hook
					*
					* @hooked woocommerce_template_loop_rating - 5
					* @hooked woocommerce_template_loop_price - 10
					*/
					remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating', 5);
					add_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating', 15);
					do_action( 'woocommerce_after_shop_loop_item_title');

				?>

				<?php if ( $time_sale ): ?>
					<div class="time">
						<div class="tbay-countdown" data-time="timmer" data-days="<?php echo esc_html__('Days','greenmart'); ?>" data-hours="<?php echo esc_html__('Hours','greenmart'); ?>"  data-mins="<?php echo esc_html__('Mins','greenmart'); ?>" data-secs="<?php echo esc_html__('Secs','greenmart'); ?>"
							 data-date="<?php echo date('m', $time_sale).'-'.date('d', $time_sale).'-'.date('Y', $time_sale).'-'. date('H', $time_sale) . '-' . date('i', $time_sale) . '-' .  date('s', $time_sale) ; ?>">
						</div>
					</div> 
				<?php endif; ?> 
		
				 <div class="description"><?php echo greenmart_tbay_substring( get_the_excerpt(), 15, '...' ); ?></div>
			</div>
        </div>
		
    </div>
		
