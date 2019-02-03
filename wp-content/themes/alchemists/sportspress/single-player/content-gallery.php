<?php
/**
 * The template for displaying Single Player
 *
 * @author    Dan Fisher
 * @package   Alchemists
 * @since     1.0.0
 * @version   3.0.0
 */

$container_class = '';
$album_wrapper_classes = array( 'album-wrapper' );
$sp_preset_name = 'default';

if ( alchemists_sp_preset( 'football') ) {
	$container_class = 'container';
	$album_wrapper_classes[] = 'row';
	$sp_preset_name = 'football';
}
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main <?php echo esc_attr( $container_class ); ?>">

		<?php
		$images = get_field('images');

		if ( $images ): ?>

		<!-- Gallery Album -->
		<div class="<?php echo esc_attr( implode( ' ', $album_wrapper_classes ) ); ?>">
			<div class="album">

				<?php
				foreach ( $images as $image ) :
					include( locate_template( 'sportspress/single-player/gallery/gallery-' . $sp_preset_name . '.php' ) );
				endforeach;
				?>

			</div>
		</div>
		<!-- Gallery Album / End -->
		<?php endif; ?>

	</main><!-- #main -->
</div><!-- #primary -->
