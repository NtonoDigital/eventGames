<?php
/**
 * Template part for Header Primary section.
 *
 * @package Alchemists
 * @since   1.0.0
 * @version 3.0.0
 */

$alchemists_data = get_option('alchemists_data');

$logo_standard = isset( $alchemists_data['alchemists__opt-logo-standard']['url'] ) ? esc_html( $alchemists_data['alchemists__opt-logo-standard']['url'] ) : '';
$logo_retina   = isset( $alchemists_data['alchemists__opt-logo-retina']['url'] ) ? esc_html( $alchemists_data['alchemists__opt-logo-retina']['url'] ) : '';
$pushy_panel   = isset( $alchemists_data['alchemists__header-pushy-panel'] ) ? $alchemists_data['alchemists__header-pushy-panel'] : 1;
$search_form   = isset( $alchemists_data['alchemists__header-search-form'] ) ? esc_html( $alchemists_data['alchemists__header-search-form'] ) : true;
$search_form_position = isset( $alchemists_data['alchemists__header-search-form-posiiton'] ) ? $alchemists_data['alchemists__header-search-form-posiiton'] : 'header_secondary';

$default_logo_path = '';
if ( alchemists_sp_preset('soccer') ) {
	$default_logo_path = 'soccer/';
} elseif ( alchemists_sp_preset('football') ) {
	$default_logo_path = 'football/';
}

?>

<div class="header__primary">
	<div class="container">
		<div class="header__primary-inner">

			<!-- Header Logo -->
			<div class="header-logo">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<?php if ( !empty( $logo_standard ) ) : ?>
						<img src="<?php echo esc_url( $logo_standard ); ?>" <?php if ( !empty( $logo_retina ) ) { ?> srcset="<?php echo esc_url( $logo_retina ); ?> 2x" <?php } ?> class="header-logo__img" alt="<?php bloginfo('name'); ?>">
					<?php else : ?>
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/<?php echo $default_logo_path; ?>logo.png" class="header-logo__img" srcset="<?php echo get_template_directory_uri(); ?>/assets/images/<?php echo $default_logo_path; ?>logo@2x.png 2x" alt="<?php esc_attr( bloginfo('name') ); ?>">
					<?php endif; ?>
				</a>
			</div>
			<!-- Header Logo / End -->

			<!-- Main Navigation -->
			<nav class="main-nav clearfix">
				<?php // Primary navigation
				if ( has_nav_menu('primary') ) {
					wp_nav_menu(
						array(
							'theme_location'  => 'primary',
							'container'       => false,
							'menu_class'      => 'main-nav__list',
							'echo'            => true,
							'fallback_cb'     => 'wp_page_menu',
							'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							'depth'           => 0,
							'walker'          => new Alchemists_Nav_Menu()
						)
					);
				} ?>

				<?php if ( isset ( $alchemists_data['alchemists__header-primary-social'] ) && $alchemists_data['alchemists__header-primary-social'] == 1 ) :

					// Get all social media links
					$social_media = $alchemists_data['alchemists__header-primary-social-links'];
				?>

					<!-- Social Links -->
					<ul class="social-links social-links--inline social-links--main-nav">
						<?php foreach ( array_filter( $social_media ) as $key => $value) {

							echo '<li class="social-links__item">';

								switch($key) {

									case esc_html__( 'Facebook URL', 'alchemists') :
										echo '<a href="' . esc_url( $social_media[ esc_html__( 'Facebook URL', 'alchemists') ] ) . '" class="social-links__link" data-toggle="tooltip" data-placement="bottom" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a>';
									break;

									case esc_html__( 'Twitter URL', 'alchemists'):
										echo '<a href="' . esc_url( $social_media[ esc_html__( 'Twitter URL', 'alchemists') ] ) . '" class="social-links__link" data-toggle="tooltip" data-placement="bottom" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a>';
									break;

									case esc_html__( 'LinkedIn URL', 'alchemists'):
										echo '<a href="' . esc_url( $social_media[ esc_html__( 'LinkedIn URL', 'alchemists') ] ) . '" class="social-links__link" data-toggle="tooltip" data-placement="bottom" title="LinkedIn" target="_blank"><i class="fa fa-linkedin"></i></a>';
									break;

									case esc_html__( 'Google+ URL', 'alchemists'):
										echo '<a href="' . esc_url( $social_media[ esc_html__( 'Google+ URL', 'alchemists') ] ) . '" class="social-links__link" data-toggle="tooltip" data-placement="bottom" title="Google+" target="_blank"><i class="fa fa-google-plus"></i></a>';
									break;

									case esc_html__( 'Instagram URL', 'alchemists'):
										echo '<a href="' . esc_url( $social_media[ esc_html__( 'Instagram URL', 'alchemists') ] ) . '" class="social-links__link" data-toggle="tooltip" data-placement="bottom" title="Instagram" target="_blank"><i class="fa fa-instagram"></i></a>';
									break;

									case esc_html__( 'Github URL', 'alchemists'):
										echo '<a href="' . esc_url( $social_media[ esc_html__( 'Github URL', 'alchemists') ] ) . '" class="social-links__link" data-toggle="tooltip" data-placement="bottom" title="Github" target="_blank"><i class="fa fa-github"></i></a>';
									break;

									case esc_html__( 'VK URL', 'alchemists'):
										echo '<a href="' . esc_url( $social_media[ esc_html__( 'VK URL', 'alchemists') ] ) . '" class="social-links__link" data-toggle="tooltip" data-placement="bottom" title="VKontakte" target="_blank"><i class="fa fa-vk"></i></a>';
									break;

									case esc_html__( 'YouTube URL', 'alchemists'):
										echo '<a href="' . esc_url( $social_media[ esc_html__( 'YouTube URL', 'alchemists') ] ) . '" class="social-links__link" data-toggle="tooltip" data-placement="bottom" title="YouTube" target="_blank"><i class="fa fa-youtube"></i></a>';
									break;

									case esc_html__( 'Pinterest URL', 'alchemists'):
										echo '<a href="' . esc_url( $social_media[ esc_html__( 'Pinterest URL', 'alchemists') ] ) . '" class="social-links__link" data-toggle="tooltip" data-placement="bottom" title="Pinterest" target="_blank"><i class="fa fa-pinterest"></i></a>';
									break;

									case esc_html__( 'Tumblr URL', 'alchemists'):
										echo '<a href="' . esc_url( $social_media[ esc_html__( 'Tumblr URL', 'alchemists') ] ) . '" class="social-links__link" data-toggle="tooltip" data-placement="bottom" title="Tumblr" target="_blank"><i class="fa fa-tumblr"></i></a>';
									break;

									case esc_html__( 'Dribbble URL', 'alchemists'):
										echo '<a href="' . esc_url( $social_media[ esc_html__( 'Dribbble URL', 'alchemists') ] ) . '" class="social-links__link" data-toggle="tooltip" data-placement="bottom" title="Dribbble" target="_blank"><i class="fa fa-dribbble"></i></a>';
									break;

									case esc_html__( 'Vimeo URL', 'alchemists'):
										echo '<a href="' . esc_url( $social_media[ esc_html__( 'Vimeo URL', 'alchemists') ] ) . '" class="social-links__link" data-toggle="tooltip" data-placement="bottom" title="Vimeo" target="_blank"><i class="fa fa-vimeo"></i></a>';
									break;

									case esc_html__( 'Flickr URL', 'alchemists'):
										echo '<a href="' . esc_url( $social_media[ esc_html__( 'Flickr URL', 'alchemists') ] ) . '" class="social-links__link" data-toggle="tooltip" data-placement="bottom" title="Flickr" target="_blank"><i class="fa fa-flickr"></i></a>';
									break;

									case esc_html__( 'Yelp URL', 'alchemists'):
										echo '<a href="' . esc_url( $social_media[ esc_html__( 'Yelp URL', 'alchemists') ] ) . '" class="social-links__link" data-toggle="tooltip" data-placement="bottom" title="Yelp" target="_blank"><i class="fa fa-yelp"></i></a>';
									break;

									case esc_html__( 'Email', 'alchemists'):
										echo '<a href="mailto:' . sanitize_email( $social_media[ esc_html__( 'Email', 'alchemists') ] ) . '" class="social-links__link" data-toggle="tooltip" data-placement="bottom" title="Email" target="_blank"><i class="fa fa-envelope"></i></a>';
									break;

									case esc_html__( 'RSS', 'alchemists'):
										echo '<a href="' . esc_url( $social_media[ esc_html__( 'RSS', 'alchemists') ] ) . '" class="social-links__link" data-toggle="tooltip" data-placement="bottom" title="RSS" target="_blank"><i class="fa fa-rss"></i></a>';
									break;
								}

							echo '</li>';
						} ?>
					</ul>
					<!-- Social Links / End -->
				<?php endif; ?>

				<?php if ( $search_form && $search_form_position == 'header_primary') : ?>
				<!-- Header Search Form -->
				<?php get_template_part('template-parts/header-searchform'); ?>
				<!-- Header Search Form / End -->
				<?php endif; ?>


				<?php if ( $pushy_panel == 1 ) : ?>
				<!-- Pushy Panel Toggle -->
				<a href="#" class="pushy-panel__toggle">
					<span class="pushy-panel__line"></span>
				</a>
				<!-- Pushy Panel Toggle / Eng -->
				<?php endif; ?>

			</nav>
			<!-- Main Navigation / End -->
		</div>
	</div>
</div>
