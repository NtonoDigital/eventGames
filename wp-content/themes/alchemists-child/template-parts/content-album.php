<?php 
$sp_preset_name = 'default';

if ( alchemists_sp_preset( 'football' ) ) {
	$container_class = 'container';
	$sp_preset_name = 'football';
} elseif ( alchemists_sp_preset( 'soccer') ) {
	$sp_preset_name = 'soccer';
}

?>
<div class="site-content" id="content">

	<div class="container hidden">
		<div class="content-title">
			<a href="<?php echo wp_get_referer(); ?>" class="btn btn-xs btn-default btn-outline"><?php esc_html_e( 'Go Back to the Albums', 'alchemists' ); ?></a>
		</div>
	</div>

	<div class="row">

		<div id="primary" class="content-area">
			<main id="main" class="site-main <?php echo esc_attr( $container_class ); ?>">

				<?php
				$images = get_field('album_photos', $copa_event_album->ID );

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