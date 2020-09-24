<?php

$align = $title_position = $title_bg = $nav_type = $pagi_type = $loop_type = $auto_type = $autospeed_type = $disable_mobile = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$el_class = isset( $atts['el_class'] ) ? $atts['el_class'] : '';
if( isset($title_position) && $title_position == 'left' ) {
    $el_class .= ' title-left';

    $el_class .= (isset($title_bg) && $title_bg == 'yes') ? ' title-bg' : '';
}

if ( $producttabs == '' ) return;

if (isset($categories) && !empty($categories)) {
    $categories = explode(',', $categories);
}


$_id = greenmart_tbay_random_key();
$_count = 1;

$list_query = $this->getListQuery( $atts );

if($responsive_type == 'yes') {
    $screen_desktop          =      isset($screen_desktop) ? $screen_desktop : 4;
    $screen_desktopsmall     =      isset($screen_desktopsmall) ? $screen_desktopsmall : 3;
    $screen_tablet           =      isset($screen_tablet) ? $screen_tablet : 3;
    $screen_mobile           =      isset($screen_mobile) ? $screen_mobile : 1;
} else {
    $screen_desktop          =     	$columns;
    $screen_desktopsmall     =      $columns;
    $screen_tablet           =      $columns;
    $screen_mobile           =      $columns;  
}

$active_theme = greenmart_tbay_get_part_theme();


if ( count($list_query) > 0 ) {
?>
	<div class="widget <?php echo esc_attr($align); ?> widget-products widget-product-tabs products <?php echo esc_attr($el_class); ?>">
		<div class="tabs-container tab-heading clearfix tab-v8">
			<?php if($title!=''):?>
				<h3 class="widget-title">
            		<span><span><?php echo esc_html( $title ); ?></span></span><?php if( isset($subtitle) && $subtitle ){ ?><span class="subtitle"><?php echo esc_html($subtitle); ?></span> <?php } ?>
				</h3>
			<?php endif; ?>
			<ul class="tabs-list nav nav-tabs">
				<?php $__count=0; ?>
				<?php foreach ($list_query as $key => $li) { ?>

						<?php 
							$class_li	= ($__count==0)?' class="active"':'';
						?>
						<li <?php echo trim($class_li); ?>><a href="#<?php echo esc_attr($key.'-'.$_id); ?>" data-toggle="tab" data-title="<?php echo esc_attr($li['title']);?>"><?php echo trim( $li['title_tab'] );?></a></li>
					<?php $__count++; ?>
				<?php } ?>
			</ul> 
		</div>


		<?php if(  $layout_type == 'carousel' || $layout_type == 'carousel-special' ) { ?>

			<div class="widget-content tab-content woocommerce">
				<?php $__count=0; ?>
				<?php foreach ($list_query as $key => $li) { ?>
					<?php

						if (isset($categories) && !empty($categories) && strpos($categories, ',') !== false) {
						    $category = explode(',', $categories);
						    $category = greenmart_tbay_get_category_by_id($category);

						    $loop = greenmart_tbay_get_products( $category, $key, 1, $number ); 
						} else if( isset($categories) && !empty($categories) ) {
						    $category = get_term_by( 'id', $categories, 'product_cat' )->slug;

						    $loop = greenmart_tbay_get_products( array($category), $key, 1, $number ); 
						} else {

						    $loop = greenmart_tbay_get_products( '', $key, 1, $number ); 
						}
						
						$class_tab = 	($__count == 0 ? ' active' : '');
					?>
					<div class="tab-pane<?php echo esc_attr( $class_tab ); ?>" id="<?php echo esc_attr($key).'-'.$_id; ?>">
						<div class="grid-wrapper">
							<?php

								if ( $loop->have_posts()) {

									wc_get_template( 'layout-products/'.$active_theme.'/'. $layout_type .'.php' , array( 'loop' => $loop, 'columns' => $columns, 'rows' => $rows, 'pagi_type' => $pagi_type, 'nav_type' => $nav_type,'screen_desktop' => $screen_desktop,'screen_desktopsmall' => $screen_desktopsmall,'screen_tablet' => $screen_tablet,'screen_mobile' => $screen_mobile, 'number' => $number, 'loop_type' => $loop_type, 'auto_type' => $auto_type, 'autospeed_type' => $autospeed_type, 'disable_mobile' => $disable_mobile ) );
								}
							?>
						</div>

					</div> 
					<?php $__count++; ?>
				<?php } ?>
			</div>

		<?php } else { ?>

			<div class="widget-content tab-content woocommerce">
				<?php $__count=0; ?>
				<?php foreach ($list_query as $key => $li) { ?>
					<?php

						if (isset($categories) && !empty($categories) && strpos($categories, ',') !== false) {
						    $category = explode(',', $categories);
						    $category = greenmart_tbay_get_category_by_id($category);

						    $loop = greenmart_tbay_get_products( $category, $key, 1, $number ); 
						} else if( isset($categories) && !empty($categories) ) {
						    $category = get_term_by( 'id', $categories, 'product_cat' )->slug;

						    $loop = greenmart_tbay_get_products( array($category), $key, 1, $number ); 
						} else {

						    $loop = greenmart_tbay_get_products( '', $key, 1, $number ); 
						}
						
						$class_tab  = ($__count == 0 ? ' active' : '');
					?>
					<div class="tab-pane<?php echo esc_attr( $class_tab ); ?>" id="<?php echo esc_attr($key).'-'.$_id; ?>">
						<div class="grid-wrapper">
							<?php

								if ( $loop->have_posts()) {
									
									wc_get_template( 'layout-products/'.$active_theme.'/'. $layout_type .'.php' , array( 'loop' => $loop, 'columns' => $columns, 'screen_desktop' => $screen_desktop,'screen_desktopsmall' => $screen_desktopsmall,'screen_tablet' => $screen_tablet,'screen_mobile' => $screen_mobile, 'number' => $number ) );
								}
							?>
						</div>

					</div>
					<?php $__count++; ?>
				<?php } ?>
			</div>			

		<?php } ?>

	</div>
<?php wp_reset_postdata(); ?>
<?php } ?>

