<?php
/**
 * Template part for Header on mobile devices.
 *
 * @author    Dan Fisher
 * @package   Alchemists
 * @since     1.0.0
 * @version   3.0.8
 */

$alchemists_data = get_option( 'alchemists_data' );

$alc_logo_standard        = isset( $alchemists_data['alchemists__opt-logo-standard']['url'] ) ? esc_html( $alchemists_data['alchemists__opt-logo-standard']['url'] ) : '';
$alc_logo_retina          = isset( $alchemists_data['alchemists__opt-logo-retina']['url'] ) ? esc_html( $alchemists_data['alchemists__opt-logo-retina']['url'] ) : '';
$alc_logo_mobile          = isset( $alchemists_data['alchemists__opt-logo-mobile'] ) ? $alchemists_data['alchemists__opt-logo-mobile'] : 0;
$alc_logo_standard_mobile = isset( $alchemists_data['alchemists__opt-logo-mobile-standard']['url'] ) ? esc_html( $alchemists_data['alchemists__opt-logo-mobile-standard']['url'] ) : '';
$alc_logo_retina_mobile   = isset( $alchemists_data['alchemists__opt-logo-mobile-retina']['url'] ) ? esc_html( $alchemists_data['alchemists__opt-logo-mobile-retina']['url'] ) : '';
$search_form              = isset( $alchemists_data['alchemists__header-search-form'] ) ? esc_html( $alchemists_data['alchemists__header-search-form'] ) : true;

// Use Logo mobile if set
if ( $alc_logo_mobile ) {
	if ( ! empty( $alc_logo_standard_mobile ) ) {
		$alc_logo_standard = $alc_logo_standard_mobile;
	}
	if ( ! empty( $alc_logo_retina_mobile ) ) {
		$alc_logo_retina = $alc_logo_retina_mobile;
	}
}

$default_logo_path = '';
if ( alchemists_sp_preset('soccer') ) {
	$default_logo_path = 'soccer/';
} elseif ( alchemists_sp_preset('football') ) {
	$default_logo_path = 'football/';
}
?>

<div class="header-mobile clearfix" id="header-mobile">
	<div class="header-mobile__logo">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<?php if ( !empty( $alc_logo_standard ) ) : ?>
				<img src="<?php echo esc_url( $alc_logo_standard ); ?>" <?php if ( !empty( $alc_logo_retina ) ) { ?> srcset="<?php echo esc_url( $alc_logo_retina ); ?> 2x" <?php } ?> class="header-mobile__logo-img" alt="<?php bloginfo('name'); ?>">
			<?php else : ?>
				<img src="<?php echo get_template_directory_uri(); ?>/assets/images/<?php echo $default_logo_path; ?>logo.png" class="header-mobile__logo-img" srcset="<?php echo get_template_directory_uri(); ?>/assets/images/<?php echo $default_logo_path; ?>logo@2x.png 2x" alt="<?php esc_attr( bloginfo('name') ); ?>">
			<?php endif; ?>
		</a>
	</div>
	<div class="header-mobile__inner">
		<a id="header-mobile__toggle" class="burger-menu-icon"><span class="burger-menu-icon__line"></span></a>

		<?php if ( $search_form ) : ?>
			<span class="header-mobile__search-icon" id="header-mobile__search-icon"></span>
		<?php endif; ?>
	</div>
</div>
