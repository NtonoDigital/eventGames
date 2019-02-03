<?php
/**
 * The template for displaying Single Team
 *
 * @author    Dan Fisher
 * @package   Alchemists
 * @since     1.0.0
 * @version   3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Theme Options
$alchemists_data = get_option('alchemists_data');
$color_primary   = isset( $alchemists_data['color-primary'] ) ? $alchemists_data['color-primary'] : '#ffdc11';

$roster_type_get = isset( $_GET['roster_type'] ) ? $_GET['roster_type'] : '';
$roster_type     = get_field( 'gallery_roster_type' );

// to-do: add option to select number on the team page
$columns = 3;

$roster = 'gallery';
if ( $roster_type_get === 'blocks' || $roster_type === 'blocks' ) {
	$roster = 'blocks';
} elseif ( $roster_type_get === 'cards' || $roster_type === 'cards' ) {
	$roster = 'cards';
} elseif ( $roster_type_get === 'slider-card' || $roster_type === 'slider-card' ) {
	$roster = 'slider';
} elseif ( $roster_type_get === 'slider' || $roster_type === 'slider' ) {
	if ( alchemists_sp_preset( 'soccer') ) {
		$roster = 'slider-card';
	} elseif ( alchemists_sp_preset( 'football') ) {
		$roster = 'slider-carousel';
	} else {
		$roster = 'slider';
	}
}

// Gallery Roster
$gallery_roster_on   = get_field( 'gallery_roster_show' );
$gallery_roster      = get_field( 'gallery_roster' );
$gallery_roster_id   = '';

// List Roster
$list_roster_on       = get_field( 'list_roster_show' );
$list_roster          = get_field( 'list_roster' );
$list_roster_id       = '';

// Featured
$featured_player_on   = get_field( 'featured_player' );
$featured_player      = get_field( 'team_featured_player' );
$featured_player_args = array();

// Featured Player
$featured_player_args = array(
	'post_type'      => 'sp_player',
	'p'              => $featured_player,
	'posts_per_page' => 1,
);

if ( $featured_player_on ) {
	$list_roster_width = 'col-md-8';
} else {
	$list_roster_width = 'col-md-12';
}
?>


<?php // Display Gallery Roster
if ( $gallery_roster_on && $gallery_roster ) {
	$gallery_roster_id = $gallery_roster->ID;
	sp_get_template( 'player-' . $roster . '.php', array(
		'id'      => $gallery_roster_id,
		'columns' => $columns,
	) );
} ?>

<div class="row">
	<div class="<?php echo esc_attr( $list_roster_width ); ?>">
		<?php // Display List Roster
		if ( $list_roster_on && $list_roster ) {

			foreach ( $list_roster as $list_roster_item ) {
				$list_roster_id = $list_roster_item->ID;

				sp_get_template( 'player-list.php', array(
					'id'      => $list_roster_id,
					'rows'    => 11,
				) );

			}
		} ?>
	</div>

	<?php if ( $featured_player_on && $featured_player ) : ?>
	<div class="col-md-4">

		<?php
		$sp_preset_name = '';
		if ( alchemists_sp_preset( 'football') ) {
			$sp_preset_name = 'football';
		} elseif ( alchemists_sp_preset( 'soccer') ) {
			$sp_preset_name = 'soccer';
		} else {
			$sp_preset_name = 'default';
		}

		$loop = new WP_Query( $featured_player_args );
		while ( $loop->have_posts() ) : $loop->the_post();

			$player_id = $featured_player;

			$player = new SP_Player( $player_id );
			$data = $player->data( 0, false );
			unset( $data[0] );
			$data = $data[-1]; // Get Total array

			// Player Image (Alt)
			$player_image_head  = get_field('heading_player_photo');
			$player_image_size  = 'alchemists_thumbnail-player-sm';
			if( $player_image_head ) {
				$image_url = wp_get_attachment_image( $player_image_head, $player_image_size );
			} else {
				$image_url = '<img src="' . get_template_directory_uri() . '/assets/images/player-single-placeholder-189x198.png' . '" alt="" />';
			}

			// Player Team Logo
			$sp_current_teams = get_post_meta($id,'sp_current_team');
			$sp_current_team = '';
			if( !empty($sp_current_teams[0]) ) {
				$sp_current_team = $sp_current_teams[0];
			}

			// Player Name
			$title      = get_the_title( $player_id );
			$player_url = get_the_permalink( $player_id );

			// Player Number
			$player_number = get_post_meta( $player_id, 'sp_number', true );

			// Player Position(s)
			$positions = wp_get_post_terms( $player_id, 'sp_position');
			$position = false;
			if( $positions ) {
				$position = $positions[0]->name;
			}

			// Output
			include( locate_template( 'sportspress/single-team/featured-player/content-player-' . $sp_preset_name . '.php' ) );

		endwhile;

		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata(); ?>

	</div>
	<?php endif; ?>

</div>
