<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

<div class="row" id="customer_login">

	<div class="col-md-6 col-sm-6 col-xs-12">

<?php endif; ?>

		<h2><?php esc_html_e( 'Login', 'greenmart' ); ?></h2>

		<form method="post" class="login" role="form">

			<?php do_action( 'woocommerce_login_form_start' ); ?>

			<p class="form-group form-row form-row-wide">
				<label for="username"><?php esc_html_e( 'Username or email address', 'greenmart' ); ?> <span class="required">*</span></label>
				<input type="text" class="input-text form-control" name="username" id="username" autocomplete="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
			</p>
			<p class="form-group form-row form-row-wide">
				<label for="password"><?php esc_html_e( 'Password', 'greenmart' ); ?> <span class="required">*</span></label>
				<input class="input-text form-control" type="password" name="password" id="password" autocomplete="current-password" />
			</p>

			<?php do_action( 'woocommerce_login_form' ); ?>

			<p class="form-group form-row">
				<p for="rememberme" class="inline">
					<input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php esc_html_e( 'Remember me', 'greenmart' ); ?>
				</p>
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
				<input type="submit" class="button" name="login" value="<?php esc_html_e( 'Login', 'greenmart' ); ?>" />
			</p>
			<p class="form-group lost_password">
				<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'greenmart' ); ?></a>
			</p>

			<?php do_action( 'woocommerce_login_form_end' ); ?>

		</form>

<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

	</div>

	<div class="col-md-6 col-sm-6 col-xs-12">

		<h2><?php esc_html_e( 'Register', 'greenmart' ); ?></h2>

		<form method="post" class="register widget" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

			<?php do_action( 'woocommerce_register_form_start' ); ?>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

				<p class="form-group form-row form-row-wide">
					<label for="reg_username"><?php esc_html_e( 'Username', 'greenmart' ); ?> <span class="required">*</span></label>
					<input type="text" class="input-text form-control" name="username" id="reg_username" autocomplete="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
				</p>

			<?php endif; ?>

			<p class="form-group form-row form-row-wide">
				<label for="reg_email"><?php esc_html_e( 'Email address', 'greenmart' ); ?> <span class="required">*</span></label>
				<input type="email" class="input-text form-control" name="email" id="reg_email" autocomplete="email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" />
			</p>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

				<p class="form-group form-row form-row-wide">
					<label for="reg_password"><?php esc_html_e( 'Password', 'greenmart' ); ?> <span class="required">*</span></label>
					<input type="password" class="input-text form-control" name="password" id="reg_password" autocomplete="new-password" />
				</p>

			<?php else : ?>

				<p><?php esc_html_e( 'A password will be sent to your email address.', 'greenmart' ); ?></p>

			<?php endif; ?>

			<?php do_action( 'woocommerce_register_form' ); ?>

			<p class="form-group form-row">
				<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
				<input type="submit" class="button" name="register" value="<?php esc_html_e( 'Register', 'greenmart' ); ?>" />
			</p>

			<?php do_action( 'woocommerce_register_form_end' ); ?>

		</form>

	</div>

</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
