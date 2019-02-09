<?php
/**
 * The template for displaying single Album Custom Post Type
 *
 * @author    Dan Fisher
 * @package   Alchemists
 * @since     1.0.0
 * @version   3.0.12
 */

get_header();

$alchemists_data = get_option('alchemists_data');
$page_heading_overlay  = isset( $alchemists_data['alchemists__opt-page-title-overlay-on'] ) ? $alchemists_data['alchemists__opt-page-title-overlay-on'] : '';
$breadcrumbs           = isset( $alchemists_data['alchemists__opt-page-title-breadcrumbs'] ) ? $alchemists_data['alchemists__opt-page-title-breadcrumbs'] : '';

$container_class = '';
$sp_preset_name = 'default';

if ( alchemists_sp_preset( 'football' ) ) {
	$container_class = 'container';
	$sp_preset_name = 'football';
} elseif ( alchemists_sp_preset( 'soccer') ) {
	$sp_preset_name = 'soccer';
}

if ( $page_heading_overlay == 0 ) {
	$page_heading_overlay = 'page-heading--no-bg';
} else {
	$page_heading_overlay = 'page-heading--has-bg';
}

$content_classes = array();

// Page Options
$page_heading                = get_field('page_heading');
$page_content_top_padding    = get_field('page_content_top_padding');
$page_content_bottom_padding = get_field('page_content_bottom_padding');

// Custom Page Heading Options
$page_heading_customize      = get_field('page_heading_customize');
$page_heading_style          = array();
$page_heading_styles_output  = array();

if ( $page_heading_customize ) {
	// Page Heading Background Image
	$page_heading_custom_background_img = get_field('page_heading_custom_background_img');

	if ( $page_heading_custom_background_img ) {
		// if background image selected display it
		$page_heading_style[] = 'background-image: url(' . $page_heading_custom_background_img . ');';
	} else {
		// if not, remove the default one
		$page_heading_style[] = 'background-image: none;';
	}

	// Page Heading Background Color
	$page_heading_custom_background_color = get_field('page_heading_custom_background_color');
	if ( $page_heading_custom_background_color ) {
		$page_heading_style[] = 'background-color: ' . $page_heading_custom_background_color . ';';
	}

	// Overlay
	$page_heading_add_overlay_on = get_field('page_heading_add_overlay_on');
	// hide pseudoelement if overlay disabled
	if ( empty( $page_heading_add_overlay_on ) ) {
		$page_heading_overlay = 'page-heading--no-bg';
	}

	$page_heading_custom_overlay_color = get_field('page_heading_custom_overlay_color') ? get_field('page_heading_custom_overlay_color') : 'transparent';
	$page_heading_custom_overlay_opacity = get_field( 'page_heading_custom_overlay_opacity' );
	$page_heading_remove_overlay_pattern = get_field( 'page_heading_remove_overlay_pattern' );

	if ( $page_heading_add_overlay_on ) {
		echo '<style>';
			echo '.page-heading::before {';
				echo 'background-color: ' . $page_heading_custom_overlay_color . ';';
				echo 'opacity: ' . $page_heading_custom_overlay_opacity / 100 . ';';
				if ( $page_heading_remove_overlay_pattern ) {
					echo 'background-image: none;';
				}
			echo '}';
		echo '</style>';
	}
}

// combine all custom inline properties into one string
if ( $page_heading_style ) {
	$page_heading_styles_output[] = 'style="' . implode( ' ', $page_heading_style ). '"';
}

// Page Content Options
$page_content_top_padding_class = '';
if ( $page_content_top_padding == 'none' ) {
	$content_classes[] = 'pt-0';
}

$page_content_bottom_padding_class = '';
if ( $page_content_bottom_padding == 'none' ) {
	$content_classes[] = 'pb-0';
}

?>


<?php if ( $page_heading == 'page_hero' ) :

	get_template_part( 'template-parts/page-hero-unit' );

elseif ( $page_heading == 'page_hero_posts_slider' ) :

	get_template_part( 'template-parts/page-hero-posts-slider' );

?>

<?php elseif ( $page_heading == 'page_default' || ! $page_heading ) : ?>

	<!-- Page Heading
	================================================== -->
	<div class="page-heading <?php echo esc_attr( $page_heading_overlay ); ?>" <?php echo implode( ' ', $page_heading_styles_output ); ?>>
		<div class="container">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<?php the_title( '<h1 class="page-heading__title">', '</h1>' ); ?>
					<?php
					// Breadcrumb
					if ( function_exists( 'breadcrumb_trail' ) && $breadcrumbs != 0 ) {
						breadcrumb_trail( array(
							'show_browse' => false,
						));
					}?>
				</div>
			</div>
		</div>
	</div>

<?php endif; ?>

<div class="site-content" id="content">

	<div class="container">
		<div class="content-title">
			<a href="<?php echo wp_get_referer(); ?>" class="btn btn-xs btn-default btn-outline"><?php esc_html_e( 'Go Back to the Albums', 'alchemists' ); ?></a>
		</div>
	</div>

	<div class="row">

		<div id="primary" class="content-area">
			<main id="main" class="site-main <?php echo esc_attr( $container_class ); ?>">
				<?php $teams = get_field('teams_in_gallery_albums'); var_dump( $teams ); ?>

				

				<?php
				$images = get_field('album_photos');

				if ( $images ): ?>
				<!-- Gallery Album -->
				<div class="album album--condensed container-fluid">
					<div class="row">

						<?php
						foreach ( $images as $image ) :
							include( locate_template( 'sportspress/single-team/albums/album-' . $sp_preset_name . '.php' ) );
						endforeach;
						?>

					</div>
				</div>
				<!-- Gallery Album / End -->
				<?php endif; ?>

			</main><!-- #main -->
		</div><!-- #primary -->

	</div>
</div>


<?php get_footer();
