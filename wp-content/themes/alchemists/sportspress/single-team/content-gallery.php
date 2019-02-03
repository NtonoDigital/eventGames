<?php
/**
 * The template for displaying Single Team
 *
 * @author    Dan Fisher
 * @package   Alchemists
 * @since     1.0.0
 * @version   3.0.0
 */

$team_gallery_albums = get_field( 'team_gallery_albums' );
$sp_preset_name = 'default';

if ( alchemists_sp_preset( 'football' ) ) {
	$sp_preset_name = 'football';
}
?>

<?php if ( $team_gallery_albums ): ?>

	<!-- Team Gallery -->
	<div class="gallery row">

		<?php
		foreach( $team_gallery_albums as $post) :
			include( locate_template( 'sportspress/single-team/gallery/gallery-' . $sp_preset_name . '.php' ) );
		endforeach;
		?>

	</div>
	<?php wp_reset_postdata(); ?>
	<!-- Team Gallery / End -->

<?php endif;
