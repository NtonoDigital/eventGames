<?php
/**
 * The template for displaying ALC: Team Stats cell (Basketball)
 *
 * @author    Dan Fisher
 * @package   Alchemists
 * @since     1.0.0
 * @version   3.0.0
 */

if ( $stat_icon == 'icon_2' ) {
	$stat_icon = '<svg role="img" class="df-icon df-icon--apg"><use xlink:href="' . get_template_directory_uri() . '/assets/images/icons-basket.svg#assists-per-game"/></svg>';
} elseif ( $stat_icon == 'icon_3' ) {
	$stat_icon = '<svg role="img" class="df-icon df-icon--rpg"><use xlink:href="' . get_template_directory_uri() . '/assets/images/icons-basket.svg#rebounds-per-game"/></svg>';
} elseif ( $stat_icon == 'icon_custom' ) {
	// icon symbol
	$stat_icon_symbol = $stat_item['stat_icon_symbol'];

	$stat_icon = '<div class="df-icon-stack df-icon-stack--3pts"><svg role="img" class="df-icon df-icon--basketball"><use xlink:href="' . get_template_directory_uri() . '/assets/images/icons-basket.svg#basketball"></use></svg><div class="df-icon--txt">' . esc_html( $stat_icon_symbol ) . '</div></div>';
} else {
	$stat_icon = '<svg role="img" class="df-icon df-icon--ppg"><use xlink:href="' . get_template_directory_uri() . '/assets/images/icons-basket.svg#points-per-game"/></svg>';
} ?>

<li class="team-stats__item">
	<div class="team-stats__icon">
		<?php echo $stat_icon; ?>
	</div>
	<div class="team-stats__value"><?php echo esc_html( $stat_value ); ?></div>
	<div class="team-stats__label"><?php echo esc_html( $stat_label ); ?></div>
</li>
