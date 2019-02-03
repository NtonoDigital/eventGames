<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @author    Dan Fisher
 * @package   Alchemists
 * @since     3.0.0
 * @version   3.0.9
 */

$alchemists_data = get_option('alchemists_data');
$post_author_box = isset( $alchemists_data['alchemists__opt-single-post-author'] ) ? esc_html( $alchemists_data['alchemists__opt-single-post-author'] ) : 1;
$post_layout_get = isset( $_GET['single_post'] ) ? $_GET['single_post'] : '';
$post_nav        = isset( $alchemists_data['alchemists__opt-single-post-navigation'] ) ? esc_html( $alchemists_data['alchemists__opt-single-post-navigation'] ) : 1;
$post_nav_layout = isset( $alchemists_data['alchemists__opt-single-post-navigation-type'] ) ? esc_html( $alchemists_data['alchemists__opt-single-post-navigation-type'] ) : 'card-n';
$post_sidebar    = isset( $alchemists_data['alchemists__single-post-sidebar'] ) ? esc_html( $alchemists_data['alchemists__single-post-sidebar'] ) : 1;

// Post Navigation
if ( $post_nav_layout == 'card-sm' ) {
	$post_nav_layout = 'navigation';
} else if ( $post_nav_layout == 'card-n' ) {
	$post_nav_layout = 'navigation-2';
} else {
	$post_nav_layout = 'navigation-2';
}

// Content
$content_width = 'col-md-8';

// Sidebar
$sidebar_width = 'col-md-4';

// Sidebar Width (position)
if ( $post_sidebar == 2 ) {
	$content_width = 'col-md-8 col-md-push-4';
	$sidebar_width = 'col-md-4 col-md-pull-8';
} elseif ( $post_sidebar == 3 ) {
	$content_width = 'col-md-12';
}
?>

<div class="site-content" id="content">
	<div class="container">
		<div class="row">

			<div id="primary" class="content-area <?php echo wp_kses_post( $content_width ); ?>">

				<?php
				while ( have_posts() ) : the_post();

					// set post views
					if ( function_exists( 'alchemists_setPostViews' ) ) {
						alchemists_setPostViews( get_the_ID() );
					}

					get_template_part( 'template-parts/content', 'single-4' );

					if ( $post_layout_get != '2' ) {

						if ( $post_author_box != 0 ) {
							// Post Author
							get_template_part( 'template-parts/post/post', 'author' );
						}
					}

					if ( $post_nav != 0 ) {
						// Post Navigation
						get_template_part( 'template-parts/post/post', $post_nav_layout );
					}

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile; // End of the loop.
				?>

			</div><!-- #primary -->


			<?php if ( $post_sidebar != 3 ) : ?>
			<aside id="secondary" class="sidebar widget-area <?php echo esc_attr( $sidebar_width ); ?>">
				<?php get_sidebar(); ?>
			</aside><!-- #secondary -->
			<?php endif; ?>

		</div>
	</div>
</div>
