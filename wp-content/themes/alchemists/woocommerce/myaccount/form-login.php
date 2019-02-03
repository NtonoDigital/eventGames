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
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' ); ?>

<div class="row" id="customer_login">

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

	<div class="col-md-6">

<?php else : ?>

	<div class="col-md-6 col-md-offset-3">

<?php endif; ?>

		<!-- Login Form -->
		<div class="card">
			<header class="card__header">
				<h4><?php esc_html_e( 'Login to your account', 'alchemists' ); ?></h4>
			</header>
			<div class="card__content">
				<form class="woocomerce-form woocommerce-form-login login" method="post">

					<?php do_action( 'woocommerce_login_form_start' ); ?>

					<div class="form-group">
						<label for="username"><?php esc_html_e( 'Username or email address', 'alchemists' ); ?> <span class="required">*</span></label>
						<input type="text" class="woocommerce-Input woocommerce-Input--text form-control" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
					</div>
					<div class="form-group">
						<label for="password"><?php esc_html_e( 'Password', 'alchemists' ); ?> <span class="required">*</span></label>
						<input class="woocommerce-Input woocommerce-Input--text form-control" type="password" name="password" id="password" autocomplete="current-password" />
					</div>

					<?php do_action( 'woocommerce_login_form' ); ?>

					<div class="form-group form-group--password-forgot">
						<label class="checkbox checkbox-inline">
							<input type="checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever"> <?php esc_html_e( 'Remember me', 'alchemists' ); ?>
							<span class="checkbox-indicator"></span>
						</label>
						<span class="password-reminder woocommerce-LostPassword lost_password">
							<?php esc_html_e( 'Lost your password?', 'alchemists' ); ?> <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Click Here', 'alchemists' ); ?></a>
						</span>
					</div>

					<div class="form-group form-group--sm">
						<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
						<button type="submit" class="woocommerce-Button btn btn-primary-inverse btn-lg btn-block" name="login" value="<?php esc_attr_e( 'Login', 'alchemists' ); ?>"><?php esc_attr_e( 'Login', 'alchemists' ); ?></button>
					</div>

					<?php do_action( 'woocommerce_login_form_end' ); ?>

				</form>
			</div>
		</div>
		<!-- Login Form / End -->

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

	</div>

	<div class="col-md-6">

		<!-- Register Form -->
		<div class="card">
			<header class="card__header">
				<h4><?php esc_html_e( 'Register Now', 'alchemists' ); ?></h4>
			</header>
			<div class="card__content">
				<form method="post" class="register">

					<?php do_action( 'woocommerce_register_form_start' ); ?>

					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

						<div class="form-group">
							<label for="reg_username"><?php esc_html_e( 'Username', 'alchemists' ); ?> <span class="required">*</span></label>
							<input type="text" class="woocommerce-Input woocommerce-Input--text form-control" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
						</div>

					<?php endif; ?>

					<div class="form-group">
						<label for="reg_email"><?php esc_html_e( 'Email address', 'alchemists' ); ?> <span class="required">*</span></label>
						<input type="email" class="woocommerce-Input woocommerce-Input--text form-control" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
					</div>

					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

						<div class="form-group">
							<label for="reg_password"><?php esc_html_e( 'Password', 'alchemists' ); ?> <span class="required">*</span></label>
							<input type="password" class="woocommerce-Input woocommerce-Input--text form-control" name="password" id="reg_password" autocomplete="new-password" />
						</div>

					<?php endif; ?>

					<?php do_action( 'woocommerce_register_form' ); ?>

					<div class="form-group form-group--submit">
						<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
						<button type="submit" class="woocommerce-Button button btn-default btn-lg btn-block" name="register" value="<?php esc_attr_e( 'Register', 'alchemists' ); ?>"><?php esc_attr_e( 'Register', 'alchemists' ); ?></button>
					</div>

					<?php do_action( 'woocommerce_register_form_end' ); ?>

				</form>
			</div>
		</div>
		<!-- Register Form / End -->

	</div>

<?php else : ?>

</div>

<?php endif; ?>

</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
