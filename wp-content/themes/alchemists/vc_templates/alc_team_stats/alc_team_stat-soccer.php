<?php
/**
 * The template for displaying ALC: Team Stats cell (Soccer)
 *
 * @author    Dan Fisher
 * @package   Alchemists
 * @since     1.0.0
 * @version   3.0.0
 */

$stat_icon_class = "";

if ( $stat_icon == 'icon_2' ) {
	$stat_icon_class = "team-stats__icon--shots-ot";
	$stat_icon = '<img src="' . get_template_directory_uri() . '/assets/images/soccer/icon-soccer-ball.svg" class="team-stats__icon-primary" alt="">';
	$stat_icon .= '<img src="' . get_template_directory_uri() . '/assets/images/soccer/icon-soccer-gate.svg" class="team-stats__icon-secondary" alt="">';
} elseif ( $stat_icon == 'icon_3' ) {
	$stat_icon_class = "team-stats__icon--shots";
	$stat_icon = '<img src="' . get_template_directory_uri() . '/assets/images/soccer/icon-soccer-ball.svg" class="team-stats__icon-primary" alt="">';
	$stat_icon .= '<img src="' . get_template_directory_uri() . '/assets/images/soccer/icon-soccer-shots.svg" class="team-stats__icon-secondary" alt="">';
} elseif ( $stat_icon == 'icon_custom' ) {
	// icon symbol
	$stat_icon_symbol = $stat_item['stat_icon_symbol'];
	$stat_icon_class = "team-stats__icon--assists";
	$stat_icon = '<img src="' . get_template_directory_uri() . '/assets/images/soccer/icon-soccer-ball.svg" class="team-stats__icon-primary" alt="">';
	$stat_icon .= '<span class="team-stats__icon-secondary">' .  $stat_item['stat_icon_symbol'] . '</span>';
} else {
	$stat_icon = '<img src="' . get_template_directory_uri() . '/assets/images/soccer/icon-soccer-ball.svg" class="team-stats__icon-primary" alt="">';
} ?>

<li class="team-stats__item team-stats__item--clean">
	<div class="team-stats__icon team-stats__icon--circle <?php echo esc_attr( $stat_icon_class ); ?>">
		<?php echo $stat_icon; ?>
	</div>
	<div class="team-stats__value"><?php echo esc_html( $stat_value ); ?></div>
	<div class="team-stats__label"><?php echo esc_html( $stat_label ); ?></div>
</li>
