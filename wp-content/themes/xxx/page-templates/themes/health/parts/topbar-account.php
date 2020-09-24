<?php if( !(defined('GREENMART_WOOCOMMERCE_CATALOG_MODE_ACTIVED') && GREENMART_WOOCOMMERCE_CATALOG_MODE_ACTIVED) && has_nav_menu( 'nav-account' )) : ?>

	<div class="tbay-login">

		<?php if (is_user_logged_in() ) { ?>
			<div class="click-icon-wrapper">
				<button class="account-button btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><i class="icon-user icons"></i><?php esc_html_e('My Account', 'greenmart'); ?>
					<span class="caret"></span>
				</button>
				<div class="account-menu dropdown-menu  click-icon-content">
				<?php if ( has_nav_menu( 'nav-account' ) ) { ?>
					<?php
					$args = array(
						'theme_location'  => 'nav-account',
						'container_class' => '',
						'menu_class'      => 'menu-topbar'
					);
					wp_nav_menu($args);
					?>
				<?php } ?>
				</div>
			</div>
		<?php } elseif( !(defined('GREENMART_WOOCOMMERCE_CATALOG_MODE_ACTIVED') && GREENMART_WOOCOMMERCE_CATALOG_MODE_ACTIVED) && defined('GREENMART_WOOCOMMERCE_ACTIVED') && GREENMART_WOOCOMMERCE_ACTIVED && !empty(get_option('woocommerce_myaccount_page_id')) ) { ?> 
			<div class="click-icon-wrapper"> 
				<a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" class="account-button" title="<?php esc_html_e('Login','greenmart'); ?>"><i class="icon-user-follow icons"></i><?php esc_html_e('Login','greenmart'); ?></a>  
			</div>        	
		<?php } ?> 

	</div>
	
<?php endif; ?> 