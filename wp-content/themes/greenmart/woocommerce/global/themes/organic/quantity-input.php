<?php
if ( $max_value && $min_value === $max_value ) {
	?>
	<div class="quantity hidden">
		<input type="hidden" id="<?php echo esc_attr( $input_id ); ?>" class="qty" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $min_value ); ?>" />
	</div>
	<?php
} else {
		/* translators: %s: Quantity. */
	$labelledby = ! empty( $args['product_name'] ) ? sprintf( esc_html__( '%s quantity', 'greenmart' ), strip_tags( $args['product_name'] ) ) : '';
	?>
	<div class="box-quantity">
		<span class="title-qty"><?php echo esc_html__( 'Quantity', 'greenmart' ) ?></span>
		<div class="quantity">
			<input class="minus" type="button" value="-">
			<input 
			type="number" 
			class="input-text qty text" 
			data-step="<?php echo esc_attr( $step ); ?>" 
			data-min="<?php echo esc_attr( $min_value ); ?>" 
			data-max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>" 
			name="<?php echo esc_attr( $input_name ); ?>" 
			value="<?php echo esc_attr( $input_value ); ?>" 
			title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'greenmart' ) ?>" 
			size="4" pattern="<?php echo esc_attr( $pattern ); ?>" 
			data-inputmode="<?php echo esc_attr( $inputmode ); ?>"
			aria-labelledby="<?php echo esc_attr( $labelledby ); ?>" />
			<input class="plus" type="button" value="+">
		</div>
	</div>
	<?php
}
