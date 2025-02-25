<?php

do_action( 'woocommerce_before_cart' ); ?>

<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<div class="row">
		<?php do_action( 'woocommerce_before_cart_table' ); ?>
		<div class="col-xs-12 col-md-9">
			<div class="shop_table shop_table_responsive cart woocommerce-cart-form__contents">
				<?php do_action( 'woocommerce_before_cart_contents' ); ?>
				<div class="cart_item head">
					<span class="product"><?php esc_html_e( 'Product', 'greenmart' ); ?></span>
					<span class="product-name"></span>
					<span class="price"><?php esc_html_e( 'Price', 'greenmart' ); ?></span>
					<span class="quantity"><?php esc_html_e( 'Quantity', 'greenmart' ); ?></span>
					<span class="subtotal"><?php esc_html_e( 'Total', 'greenmart' ); ?></span>
					<span class="product-remove"></span>
				</div>
				<?php
				foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
					$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
					$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

					if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
						$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
						?>
						<div class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?> clearfix">


							<span class="product-thumbnail">
								<?php
									$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

									if ( ! $product_permalink ) {
										echo trim($thumbnail);
									} else {
										printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
									}
								?>
							</span>

							<span class="product-name" data-title="<?php esc_attr_e( 'Product', 'greenmart' ); ?>">
								<?php
      						if ( ! $product_permalink ) {
      							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
      						} else {
      							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
      						}

                  do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

									// Meta data
									echo wc_get_formatted_cart_item_data( $cart_item );

      					// Backorder notification.
      						if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
      							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'greenmart' ) . '</p>', $product_id ) );
      						}
								?>
							</span>

							<span class="product-price" data-title="<?php esc_attr_e( 'Price', 'greenmart' ); ?>">
								<b><?php
									echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
								?>
								</b>
							</span>

							<span class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'greenmart' ); ?>">
								<?php
									if ( $_product->is_sold_individually() ) {
										$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
									} else {
										$product_quantity = woocommerce_quantity_input( array(
											'input_name'    => "cart[{$cart_item_key}][qty]",
											'input_value'   => $cart_item['quantity'],
											'max_value'     => $_product->get_max_purchase_quantity(),
											'min_value'     => '0',
											'product_name'  => $_product->get_name(),
										), $_product, false );
									}

									echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
								?>
							</span>

							<span class="product-subtotal price" data-title="<?php esc_attr_e( 'Total', 'greenmart' ); ?>">
								<b><?php
									echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
								?>
								</b>
							</span>

							<span class="product-remove">
								<?php
									// @codingStandardsIgnoreLine
									echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
										'<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-product_sku="%s"><i class="icon-trash icons"></i></a>',
										esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
										esc_html__( 'Remove this item', 'greenmart' ),
										esc_attr( $product_id ),
										esc_attr( $_product->get_sku() )
									), $cart_item_key );
								?>
							</span>

						</div>
						<?php
					}
				}

				?>
			</div>
			<?php do_action( 'woocommerce_cart_contents' );
				?>
			<div class="cart-bottom clearfix">
				<div class="pull-left update-cart">
					<input type="submit" class="btn btn-default update" name="update_cart" value="<?php esc_attr_e( 'Update Cart', 'greenmart' ); ?>" />

				<?php do_action( 'woocommerce_cart_actions' ); ?>
					<?php wp_nonce_field( 'woocommerce-cart' ); ?>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-md-3">
			<?php if ( wc_coupons_enabled() ) { ?>
			<div class="coupon">
				<label for="coupon_code"><?php esc_html_e( 'Coupon apply', 'greenmart' ); ?></label>
				<p><?php esc_html_e( 'Aenean fringilla eget erat aliquet bibendum.', 'greenmart' ); ?></p>
				<div class="box"><input type="text" name="coupon_code" id="coupon_code" value="" class="text" /><span class="input-group-btn"><input type="submit" class="btn btn-default" name="apply_coupon" value="<?php esc_attr_e( 'Apply', 'greenmart' ); ?>" /></span></div>
				<?php do_action('woocommerce_cart_coupon'); ?>
			</div>	
			<?php } ?>
			<div class="tb-cart-total">

				

				<?php do_action( 'woocommerce_after_cart_table' ); ?>
				<?php if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
				<span class="continue-to-shop">
					<a class="button continue" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
						<?php esc_html_e( 'continue shopping', 'greenmart' ) ?>
					</a>
				</span>
				<?php endif; ?>
			</div>
		</div>
	</div>	
	<?php do_action( 'woocommerce_after_cart_contents' ); ?>

</form>

<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>
<div class="woocommerce">
<?php
	/**
	 * Cart collaterals hook.
	 *
	 * @hooked woocommerce_cross_sell_display
	 * @hooked woocommerce_cart_totals - 10
	 */
	do_action( 'woocommerce_cart_collaterals' );
?>
</div>
<?php do_action( 'woocommerce_after_cart' ); ?>
