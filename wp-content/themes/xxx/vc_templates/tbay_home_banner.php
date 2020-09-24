<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

?>
<div class="tbay-home-banner <?php echo esc_attr($el_class); ?>">

    <?php $img_left = wp_get_attachment_image_src($image_left,'full'); ?>
    <?php if ( !empty($img_left) && isset($img_left[0]) ): ?>
            <div class="position-img-left no-hover tbay-image-loaded">
                <?php 
                    $image_alt_left  = get_post_meta( $image_left, '_wp_attachment_image_alt', true);
                    greenmart_tbay_src_image_loaded($img_left[0], array('alt' => $image_alt_left)); 
                ?>
            </div>
    <?php endif; ?>

	<?php $img_right = wp_get_attachment_image_src($image_right,'full'); ?>
	<?php if ( !empty($img_right) && isset($img_right[0]) ): ?>
			<div class="position-img-right no-hover tbay-image-loaded">
                <?php 
                    $image_alt_right  = get_post_meta( $img_right, '_wp_attachment_image_alt', true);
                    greenmart_tbay_src_image_loaded($img_right[0], array('alt' => $image_alt_right)); 
                ?>
        	</div>
    <?php endif; ?>

</div>