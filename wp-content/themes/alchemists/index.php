<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @author    Dan Fisher
 * @package   Alchemists
 * @since     1.0.0
 * @version   3.0.0
 */

get_header();

$alchemists_data       = get_option('alchemists_data');
$page_heading_overlay  = isset( $alchemists_data['alchemists__opt-page-title-overlay-on'] ) ? esc_html( $alchemists_data['alchemists__opt-page-title-overlay-on'] ) : '';
$breadcrumbs           = isset( $alchemists_data['alchemists__opt-page-title-breadcrumbs'] ) ? esc_html( $alchemists_data['alchemists__opt-page-title-breadcrumbs'] ) : '';
$posts_layout_get      = isset( $_GET['posts_layout'] ) ? $_GET['posts_layout'] : '';
$sidebar_position      = isset( $alchemists_data['alchemists__blog-sidebar'] ) ? esc_html( $alchemists_data['alchemists__blog-sidebar'] ) : '1';
$posts_layout          = isset( $alchemists_data['alchemists__blog-posts-style'] ) ? esc_html( $alchemists_data['alchemists__blog-posts-style'] ) : '2';
$posts_filter          = isset( $alchemists_data['alchemists__opt-blog-filter'] ) ? esc_html( $alchemists_data['alchemists__opt-blog-filter'] ) : '1';
$posts_social_counters = isset( $alchemists_data['alchemists__opt-social-counters'] ) ? esc_html( $alchemists_data['alchemists__opt-social-counters'] ) : '1';
$social_fb_position    = isset( $alchemists_data['alchemists__opt-social-counters-fb'] ) ? esc_html( $alchemists_data['alchemists__opt-social-counters-fb'] ) : '3';
$social_tw_position    = isset( $alchemists_data['alchemists__opt-social-counters-twitter'] ) ? esc_html( $alchemists_data['alchemists__opt-social-counters-twitter'] ) : '5';
$social_gplus_position = isset( $alchemists_data['alchemists__opt-social-counters-gplus'] ) ? esc_html( $alchemists_data['alchemists__opt-social-counters-gplus'] ) : '7';
$social_insta_position = isset( $alchemists_data['alchemists__opt-social-counters-instagram'] ) ? esc_html( $alchemists_data['alchemists__opt-social-counters-instagram'] ) : '0';

if ( $page_heading_overlay == 0 ) {
	$page_heading_overlay = 'page-heading--no-bg';
} else {
	$page_heading_overlay = 'page-heading--has-bg';
}

// Content
$content_width = 'col-md-8';

// Sidebar
$sidebar_width = 'col-md-4';

// Post Template
$post_template = '';

// Check for Posts Layout
if ( $posts_layout_get == '1' || $posts_layout == '1' ) {

	$posts_classes_array = array(
		'posts',
		'posts--cards',
		'post-grid',
		'post-grid--2cols',
		'post-grid--fitRows',
		'row',
	);
	$post_template = 'blog-1';

} elseif ( $posts_layout_get == '3' || $posts_layout == '3' ) {

	$posts_classes_array = array(
		'posts',
		'posts--cards',
		'posts--cards-thumb-lg',
		'post-list',
	);
	$post_template = 'blog-3';

} elseif ( $posts_layout_get == '4' || $posts_layout == '4' ) {

	$posts_classes_array = array(
		'posts',
		'posts--cards',
		'post-grid',
		'post-grid--masonry',
		'row',
	);
  $post_template = 'blog-4';

	// Apply changes only on the demo
	// if ( $posts_layout_get == '4' ) {
	// 	query_posts( array(
	// 		'posts_per_page' => 10,
	// 		'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1)
	// 	) );
	// }

	if ( $posts_layout == '4' ) {
		$content_width = 'col-md-8';
	}

} elseif ( $posts_layout_get == 5 || $posts_layout == 5 ) {

	$posts_classes_array = array(
		'posts',
		'posts--tile',
		'post-grid',
		'post-grid--fitRows',
		'row',
	);
  $post_template = 'blog-5';

	if ( $posts_layout == 5 ) {
		$content_width = 'col-md-8';
	}

} else {

	$posts_classes_array = array(
		'posts',
		'posts--cards',
		'posts--cards-thumb-left',
		'post-list',
	);
}

// Sidebar Position
if ( $sidebar_position == '2' ) {
	$content_width = 'col-md-8 col-md-push-4';
	$sidebar_width = 'col-md-4 col-md-pull-8';
} elseif ( $sidebar_position == '3' ) {
	$content_width = 'col-md-12';
}

if ( $posts_layout_get == '4' ) {
	$content_width = 'col-md-12';
}

$posts_classes = implode( " ", $posts_classes_array );


// Page Heading customization on Blog Page
$blog_page_id = false;
if ( is_home() ) {
	$blog_page_id = get_option( 'page_for_posts' );
}


$content_classes = array();

// Page Options
$page_heading                = get_field('page_heading', $blog_page_id);
$page_content_top_padding    = get_field('page_content_top_padding', $blog_page_id);
$page_content_bottom_padding = get_field('page_content_bottom_padding', $blog_page_id);

// Custom Page Heading Options
$page_heading_customize      = get_field('page_heading_customize', $blog_page_id);
$page_heading_style          = array();
$page_heading_styles_output  = array();

if ( $page_heading_customize ) {
	// Page Heading Background Image
	$page_heading_custom_background_img = get_field('page_heading_custom_background_img', $blog_page_id);

	if ( $page_heading_custom_background_img ) {
		// if background image selected display it
		$page_heading_style[] = 'background-image: url(' . $page_heading_custom_background_img . ');';
	} else {
		// if not, remove the default one
		$page_heading_style[] = 'background-image: none;';
	}

	// Page Heading Background Color
	$page_heading_custom_background_color = get_field('page_heading_custom_background_color', $blog_page_id);
	if ( $page_heading_custom_background_color ) {
		$page_heading_style[] = 'background-color: ' . $page_heading_custom_background_color . ';';
	}

	// Overlay
	$page_heading_add_overlay_on = get_field('page_heading_add_overlay_on', $blog_page_id);
	// hide pseudoelement if overlay disabled
	if ( empty( $page_heading_add_overlay_on ) ) {
		$page_heading_overlay = 'page-heading--no-bg';
	}

	$page_heading_custom_overlay_color = get_field('page_heading_custom_overlay_color', $blog_page_id) ? get_field('page_heading_custom_overlay_color', $blog_page_id) : 'transparent';
	$page_heading_custom_overlay_opacity = get_field( 'page_heading_custom_overlay_opacity', $blog_page_id );
	$page_heading_remove_overlay_pattern = get_field( 'page_heading_remove_overlay_pattern', $blog_page_id );

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

<?php if ( $page_heading == 'page_hero' ) { ?>

<?php get_template_part( 'template-parts/page-hero-unit'); ?>

<?php } elseif ( $page_heading == 'page_hero_posts_slider' ) { ?>

<?php get_template_part( 'template-parts/page-hero-posts-slider'); ?>

<?php } elseif ( $page_heading == 'page_default' || !$page_heading ) { ?>

<!-- Page Heading
================================================== -->
<div class="page-heading <?php echo esc_attr( $page_heading_overlay ); ?>" <?php echo implode( ' ', $page_heading_styles_output ); ?>>
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<h1 class="page-heading__title">
					<?php
					if ( is_home() && ! is_front_page() ) {
						single_post_title();
					} ?>
				</h1>
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

<?php } ?>

<?php // Posts Filter
if ( $posts_filter == 1 ) {
	get_template_part( 'template-parts/post', 'filter' );
} ?>

<div class="site-content" id="content">
	<div class="container">
		<div class="row">

			<div id="primary" class="content-area <?php echo esc_attr( $content_width ); ?>">
				<main id="main" class="site-main">

				<?php
				if ( have_posts() ) :

					$counter = 1; ?>

					<div class="<?php echo esc_attr( $posts_classes ); ?>">

					<?php /* Start the Loop */
					while ( have_posts() ) : the_post();

						get_template_part( 'template-parts/content', $post_template );

						if ( ( $posts_layout_get == '4' && $counter == '2' ) || ( $posts_social_counters == '1' && $posts_layout == '4' && $counter == $social_fb_position ) ) {

							get_template_part( 'template-parts/social-counters/social-fb' );

						}

						if ( ( $posts_layout_get == '4' && $counter == '4' ) || ( $posts_social_counters == '1' && $posts_layout == '4' && $counter == $social_tw_position ) ) {

							get_template_part( 'template-parts/social-counters/social-twitter' );

						}

						if ( ( $posts_layout_get == '4' && $counter == '8' ) || ( $posts_social_counters == '1' && $posts_layout == '4' && $counter == $social_gplus_position ) ) {

							get_template_part( 'template-parts/social-counters/social-gplus' );

						}

						if ( ( $posts_layout_get == '4' && $counter == '0' ) || ( $posts_social_counters == '1' && $posts_layout == '4' && $counter == $social_insta_position ) ) {

							get_template_part( 'template-parts/social-counters/social-instagram' );

						}

						$counter++;

					endwhile; ?>

					</div><!-- .posts -->

					<?php alchemists_pagination(); ?>

				<?php else :

					get_template_part( 'template-parts/content', 'none' );

				endif; ?>

				</main><!-- #main -->
			</div><!-- #primary -->

			<?php if ( $posts_layout_get != '4' ) {
				if ( $sidebar_position != '3' ) { ?>
					<aside id="secondary" class="sidebar widget-area <?php echo esc_attr( $sidebar_width ); ?>">
						<?php get_sidebar(); ?>
					</aside><!-- #secondary -->
			<?php }
			} ?>

		</div>
	</div>
</div>

<?php
get_footer();
