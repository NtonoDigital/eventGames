<?php
/**
 * Timeline
 *
 * @author 		ThemeBoy
 * @package 	SportsPress_Timelines
 * @version     2.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! isset( $id ) )
	$id = get_the_ID();

// Get linear timeline from event
$event = new SP_Event( $id );
$timeline = $event->timeline( false, true );

// Return if timeline is empty
if ( empty( $timeline ) ) return;

// Get team link option
$link_teams = get_option( 'sportspress_link_teams', 'no' ) == 'yes' ? true : false;

// Get full time of event
$minutes = $event->minutes();

// Initialize spacer
$previous = 0;

// Timeline Type
$alc_event_timeline_type = 'horizontal';
?>
<div class="sp-template sp-template-timeline sp-template-event-timeline card">
	<header class="card__header">
		<h4><?php esc_html_e('Game Timeline', 'alchemists'); ?></h4>
	</header>
	<div class="card__content">

		<?php include( locate_template( 'sportspress/event/alc-event-timeline-' . $alc_event_timeline_type . '.php' ) ); ?>

	</div>
</div>
