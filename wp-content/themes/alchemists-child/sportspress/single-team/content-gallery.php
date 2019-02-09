<?php
/**
 * The template for displaying Single Team Gallery
 *
 * @author    Richard Blondet
 * @package   copa-tournament
 */

// $team_gallery_albums = get_field( 'team_gallery_albums' );
$current_post_id = get_the_ID();
$team_gallery_albums = get_posts(array(
	'numberposts'	=> -1,
    'post_type'		=> 'albums',
    'meta_query'    => array(
		array(
			'key'   => 'teams_in_gallery_albums',
            'value' => '"' . $current_post_id . '"',
            'compare' => 'LIKE'
			)
		)
	)
);
		
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
