<?php
/**
 * Event Venue
 *
 * @author 		ThemeBoy
 * @package 	SportsPress/Templates
 * @version   1.9
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( get_option( 'sportspress_event_show_venue', 'yes' ) === 'no' ) return;

if ( ! isset( $id ) )
	$id = get_the_ID();

$venues = get_the_terms( $id, 'sp_venue' );

if ( ! $venues )
	return;

$show_maps = get_option( 'sportspress_event_show_maps', 'yes' ) == 'yes' ? true : false;
$link_venues = get_option( 'sportspress_link_venues', 'no' ) == 'yes' ? true : false;

foreach( $venues as $venue ):
	$t_id = $venue->term_id;
	$meta = get_option( "taxonomy_$t_id" );

	$name = $venue->name;
	if ( $link_venues )
		$name = '<a href="' . get_term_link( $t_id, 'sp_venue' ) . '">' . $name . '</a>';

	$address = sp_array_value( $meta, 'sp_address', '' );
	$latitude = sp_array_value( $meta, 'sp_latitude', 0 );
	$longitude = sp_array_value( $meta, 'sp_longitude', 0 );
	?>
	<div class="card sp-template sp-template-event-venue">
		<div class="card__header">
			<h4 class="sp-table-caption"><?php esc_html_e( 'Venue', 'sportspress' ); ?></h4>
		</div>
		<div class="card__content">

			<h6 class="mb-10"><?php echo $name; ?></h6>

			<?php if ( $show_maps && $latitude != null && $longitude != null ): ?>
				<?php sp_get_template( 'venue-map.php', array( 'meta' => $meta ) ); ?>
				<?php if ( $address != null ) { ?>
					<?php echo $address; ?>
				<?php } ?>
			<?php endif; ?>

		</div>
	</div>
	<?php
endforeach;
?>
