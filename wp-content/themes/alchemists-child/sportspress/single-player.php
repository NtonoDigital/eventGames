<?php
/**
 * The template for displaying Single Player
 *
 * @author    Dan Fisher
 * @package   Alchemists
 * @since     1.0.0
 * @version   3.0.7
 */

get_header();

if ( ! isset( $player_id ) ) {
	$player_id = get_the_ID();
}

$defaults = array(
	'show_number' => get_option( 'sportspress_player_show_number', 'no' ) == 'yes' ? true : false,
	'show_name' => get_option( 'sportspress_player_show_name', 'no' ) == 'yes' ? true : false,
	'show_nationality' => get_option( 'sportspress_player_show_nationality', 'yes' ) == 'yes' ? true : false,
	'show_positions' => get_option( 'sportspress_player_show_positions', 'yes' ) == 'yes' ? true : false,
	'show_current_teams' => get_option( 'sportspress_player_show_current_teams', 'yes' ) == 'yes' ? true : false,
	'show_past_teams' => get_option( 'sportspress_player_show_past_teams', 'yes' ) == 'yes' ? true : false,
	'show_leagues' => get_option( 'sportspress_player_show_leagues', 'no' ) == 'yes' ? true : false,
	'show_seasons' => get_option( 'sportspress_player_show_seasons', 'no' ) == 'yes' ? true : false,
	'show_nationality_flags' => get_option( 'sportspress_player_show_flags', 'yes' ) == 'yes' ? true : false,
	'link_teams' => get_option( 'sportspress_link_teams', 'no' ) == 'yes' ? true : false,
	'show_age' => get_option( 'sportspress_player_show_age', 'yes' ) == 'yes' ? true : false,
	'show_player_birthday' => get_option( 'sportspress_player_show_birthday', 'no' ) == 'yes' ? true : false,
);

extract( $defaults, EXTR_SKIP );

// SportsPress Custom Text Strings
$sp_text_strings      = get_option( 'sportspress_text', array() );
$sp_text_age          = ! empty( $sp_text_strings['Age'] ) ? $sp_text_strings['Age'] : esc_html__( 'Age', 'sportspress' );
$sp_text_birthday     = ! empty( $sp_text_strings['Birthday'] ) ? $sp_text_strings['Birthday'] : esc_html__( 'Birthday', 'sportspress' );
$sp_text_team_current = ! empty( $sp_text_strings['Current Team'] ) ? $sp_text_strings['Current Team'] : esc_html__( 'Current Team', 'sportspress' );
$sp_text_teams_past   = ! empty( $sp_text_strings['Past Teams'] ) ? $sp_text_strings['Past Teams'] : esc_html__( 'Past Teams', 'sportspress' );
$sp_text_position     = ! empty( $sp_text_strings['Position'] ) ? $sp_text_strings['Position'] : esc_html__( 'Position', 'sportspress' );
$sp_text_nationality  = ! empty( $sp_text_strings['Nationality'] ) ? $sp_text_strings['Nationality'] : esc_html__( 'Nationality', 'sportspress' );

$current_player_page   = get_query_var('fpage');

$alchemists_data        = get_option('alchemists_data');
$page_heading_overlay   = isset( $alchemists_data['alchemists__player-title-overlay-on'] ) ? $alchemists_data['alchemists__player-title-overlay-on'] : '';
$player_info_layout     = isset( $alchemists_data['alchemists__player-info-layout'] ) ? $alchemists_data['alchemists__player-info-layout'] : 'horizontal';
$player_info_layout_get = isset( $_GET['player_info_layout'] ) ? $_GET['player_info_layout'] : '';
$player_metrics_enable  = isset( $alchemists_data['alchemists__player-title-metrics'] ) ? $alchemists_data['alchemists__player-title-metrics'] : 0;
$player_metrics_custom  = isset( $alchemists_data['alchemists__player-title-metrics-custom'] ) ? $alchemists_data['alchemists__player-title-metrics-custom'] : array();

$label_subtitle_on     = isset( $alchemists_data['alchemists__player-subpages-label--subtitle'] ) ? $alchemists_data['alchemists__player-subpages-label--subtitle'] : 1;
$label_subtitle        = isset( $alchemists_data['alchemists__player-subpages-label--subtitle-custom'] ) && ! empty( $alchemists_data['alchemists__player-subpages-label--subtitle-custom'] ) ? $alchemists_data['alchemists__player-subpages-label--subtitle-custom'] : esc_html__( 'Player', 'alchemists' );

$player_info_layout_class = 'horizontal';
if ( $player_info_layout === 'vertical' || $player_info_layout_get === 'vertical' ) {
	$player_info_layout_class = 'vertical';
}

// Player Header Advanced Stats (chart radar for Basketball, progress bars for Soccer)
$player_header_advanced_stats = get_field('player_page_heading_advanced_stats');

$player_subpages       = isset( $alchemists_data['alchemists__player-subpages']['enabled'] ) ? $alchemists_data['alchemists__player-subpages']['enabled'] : array( 'stats' => esc_html__( 'Statistics', 'alchemists' ), 'bio' => esc_html__( 'Biography', 'alchemists' ), 'news' => esc_html__( 'Related News', 'alchemists' ), 'gallery' => esc_html__( 'Gallery', 'alchemists' ));

$overview_label        = isset( $alchemists_data['alchemists__player-subpages-label--overview'] ) ? esc_html( $alchemists_data['alchemists__player-subpages-label--overview'] ) : esc_html__( 'Overview', 'alchemists' );
$stats_label           = isset( $alchemists_data['alchemists__player-subpages-label--stats'] ) ? esc_html( $alchemists_data['alchemists__player-subpages-label--stats'] ) : esc_html__( 'Full Statistics', 'alchemists' );
$bio_label             = isset( $alchemists_data['alchemists__player-subpages-label--bio'] ) ? esc_html( $alchemists_data['alchemists__player-subpages-label--bio'] ) : esc_html__( 'Biography', 'alchemists' );
$news_label            = isset( $alchemists_data['alchemists__player-subpages-label--news'] ) ? esc_html( $alchemists_data['alchemists__player-subpages-label--news'] ) : esc_html__( 'Related News', 'alchemists' );
$gallery_label         = isset( $alchemists_data['alchemists__player-subpages-label--gallery'] ) ? esc_html( $alchemists_data['alchemists__player-subpages-label--gallery'] ) : esc_html__( 'Gallery', 'alchemists' );

$stats_slug            = isset( $alchemists_data['alchemists__player-subpages-slug--stats'] ) ? esc_html( $alchemists_data['alchemists__player-subpages-slug--stats'] ) : 'stats';
$bio_slug              = isset( $alchemists_data['alchemists__player-subpages-slug--bio'] ) ? esc_html( $alchemists_data['alchemists__player-subpages-slug--bio'] ) : 'bio';
$news_slug             = isset( $alchemists_data['alchemists__player-subpages-slug--news'] ) ? esc_html( $alchemists_data['alchemists__player-subpages-slug--news'] ) : 'news';
$gallery_slug          = isset( $alchemists_data['alchemists__player-subpages-slug--gallery'] ) ? esc_html( $alchemists_data['alchemists__player-subpages-slug--gallery'] ) : 'gallery';

if ( $page_heading_overlay == 0 ) {
	$page_heading_overlay = 'player-heading--no-bg';
} else {
	$page_heading_overlay = 'player-heading--has-bg';
}

// Custom Page Heading Options
$page_heading_customize      = get_field('player_page_heading_customize');
$page_heading_style          = array();
$page_heading_styles_output  = array();

if ( $page_heading_customize ) {
	// Page Heading Background Image
	$page_heading_custom_background_img = get_field('player_page_heading_custom_background_img');

	if ( $page_heading_custom_background_img ) {
		// if background image selected display it
		$page_heading_style[] = 'background-image: url(' . $page_heading_custom_background_img . ');';
	} else {
		// if not, remove the default one
		$page_heading_style[] = 'background-image: none;';
	}

	// Page Heading Background Color
	$page_heading_custom_background_color = get_field('player_page_heading_custom_background_color');
	if ( $page_heading_custom_background_color ) {
		$page_heading_style[] = 'background-color: ' . $page_heading_custom_background_color . ';';
	}

	// Overlay
	$page_heading_add_overlay_on = get_field('player_page_heading_add_overlay_on');
	// hide pseudoelement if overlay disabled
	if ( empty( $page_heading_add_overlay_on ) ) {
		$page_heading_overlay = 'player-heading--no-bg';
	}

	$page_heading_custom_overlay_color   = get_field( 'player_page_heading_custom_overlay_color') ? get_field('player_page_heading_custom_overlay_color') : 'transparent';
	$page_heading_custom_overlay_opacity = get_field( 'player_page_heading_custom_overlay_opacity' );
	$page_heading_remove_overlay_pattern = get_field( 'player_page_heading_remove_overlay_pattern' );

	if ( $page_heading_add_overlay_on ) {
		echo '<style>';
			echo '.player-heading::after {';
				echo 'background-color: ' . $page_heading_custom_overlay_color . ';';
				echo 'opacity: ' . $page_heading_custom_overlay_opacity / 100 . ';';
				if ( $page_heading_remove_overlay_pattern ) {
					echo 'background-image: none;';
				}
			echo '}';
		echo '</style>';
	}
}

// combine all custom inline properties into one string
if ( $page_heading_style ) {
	$page_heading_styles_output[] = 'style="' . implode( ' ', $page_heading_style ). '"';
}

$countries = SP()->countries->countries;

$player = new SP_Player( $player_id );

// Player Header Thumbnail
$player_image_head  = get_post_meta( $player_id, 'heading_player_photo', true );
$player_image_size  = 'alchemists_thumbnail-player';
if( $player_image_head ) {
    $player_image = wp_get_attachment_image( $player_image_head, $player_image_size );
    $player_image_url = wp_get_attachment_image_url( $player_image_head, 'full', false );
} else {
    $player_image = '<img src="' . get_template_directory_uri() . '/assets/images/player-single-370x400.png' . '" alt="" />';
    $player_image_url = FALSE;
}

// Team thumnail
$sp_current_teams = get_post_meta($player_id,'sp_current_team');
$sp_current_team = '';
if( !empty($sp_current_teams[0]) ) {
	$sp_current_team = $sp_current_teams[0];
}


// Player Metrics
// Get Player Metrics posts
$metrics = get_posts( array(
	'post_type'      => 'sp_metric',
	'posts_per_page' => 9999
));

// New array based on Player Statistics posts
$player_metrics_custom_array = array();
if ( $player_metrics_custom ) {
	foreach ( $player_metrics_custom as $player_metric_key => $player_metric_value) {
		$player_metrics_custom_array[ get_post_field( 'post_name', $player_metrics_custom[ $player_metric_key ] ) ] = get_post_field( 'post_title', $player_metrics_custom[ $player_metric_key ] );
	}
}

$player_metrics_data = (array)get_post_meta( $player_id, 'sp_metrics', true );

$metrics_array = array();
if( $metrics ){
	foreach( $metrics as $metric ){
		$metrics_array[ $metric->post_name ] = $metric->post_title;
	}
}

$player_metrics_default = array(
	'height',
	'weight'
);

$player_metrics = array();
if ( $player_metrics_enable && $player_metrics_custom ) {
	$player_metrics = $player_metrics_custom_array;
} else {
	$player_metrics = alchemists_sp_filter_array( $metrics_array, $player_metrics_default );
}
?>

<!-- Player Heading
================================================== -->
<div class="player-heading <?php echo esc_attr( $page_heading_overlay ); ?>" <?php echo implode( ' ', $page_heading_styles_output ); ?>>
	<div class="container">

		<?php if ( alchemists_sp_preset( 'basketball' ) ) : ?>
			<?php if( !empty( $sp_current_team ) ):
				$player_team_logo = alchemists_get_thumbnail_url( $sp_current_team, '0', 'full' );
				if( !empty($player_team_logo) ): ?>
					<div class="player-info__team-logo">
						<img src="<?php echo esc_url( $player_team_logo ); ?>" alt="<?php esc_attr_e( 'Team Logo', 'alchemists' ); ?>"/>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		<?php endif; ?>

		<div class="player-info__title player-info__title--mobile">

			<?php if ( $show_number ) : ?>
				<div class="player-info__number"><?php echo esc_html( $player->number ); ?></div>
			<?php endif; ?>

			<?php if ( $show_name ) : ?>
			<h1 class="player-info__name">
				<?php echo $player->post->post_title; ?>
			</h1>
			<?php endif; ?>

		</div>

        <style>
            .copa-player__photo {
                position: relative;
            }
            .copa-player__photo .copa-download-image {
                position: absolute;
                bottom: 15px;
                right: 25px;
                z-index: 1;
                display: block;
                font-size: 1.5em;
                padding: 10px;
                background-color: #444;
                cursor: pointer;
            }
        </style>
		<div class="player-info">
			<!-- Player Photo -->
			<div class="player-info__item player-info__item--photo copa-player__photo">
				<figure class="player-info__photo">
					<?php echo wp_kses_post( $player_image ); ?>
				</figure>
                <?php if( $player_image_url !== FALSE ): ?>
                    <div class="copa-download-image">
                        <a href="<?php echo $player_image_url . '?attachment_id=' . $player_image_head . '&download_image=1'; ?>">
                            <i class="fa fa-download"></i>
                        </a>
                    </div>
                <?php endif; ?>
			</div>
			<!-- Player Photo / End -->

			<!-- Player Details -->
			<div class="player-info__item player-info__item--details player-info__item--details-<?php echo esc_attr( $player_info_layout_class ); ?>">

				<div class="player-info__title player-info__title--desktop">

					<?php if ( $show_number ) : ?>
						<div class="player-info__number"><?php echo esc_html( $player->number ); ?></div>
					<?php endif; ?>

					<?php if ( $show_name ) : ?>
					<h1 class="player-info__name">
						<?php echo $player->post->post_title; ?>
					</h1>
					<?php endif; ?>

				</div>

				<div class="player-info-details">

					<?php foreach ( $player_metrics as $player_metric_key => $player_metric_value ) : ?>
						<?php if ( ! empty( $player_metrics_data[ $player_metric_key ] ) ) : ?>
							<div class="player-info-details__item player-info-details__item--<?php echo esc_attr( $player_metric_key ); ?>">
								<h6 class="player-info-details__title"><?php echo esc_html( $player_metric_value ); ?></h6>
								<div class="player-info-details__value"><?php echo esc_html( $player_metrics_data[ $player_metric_key ] ); ?></div>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>

					<?php if ( $show_age ) : ?>
						<div class="player-info-details__item player-info-details__item--age">
							<h6 class="player-info-details__title"><?php echo esc_html( $sp_text_age ); ?></h6>
							<div class="player-info-details__value"><?php echo esc_html( alchemists_get_age( get_the_date( 'm-d-Y', $player_id ) ) ); ?></div>
						</div>
					<?php endif; ?>

					<?php if ( $show_player_birthday ) : ?>
						<div class="player-info-details__item player-info-details__item--birthday">
							<h6 class="player-info-details__title"><?php echo esc_html( $sp_text_birthday ); ?></h6>
							<div class="player-info-details__value"><?php echo esc_html( get_the_date( get_option( 'date_format'), $player_id ) ); ?></div>
						</div>
					<?php endif; ?>

					<?php
						if ( $show_current_teams ):
							echo '<div class="player-info-details__item player-info-details__item--current-team">';
							echo '<h6 class="player-info-details__title">' . $sp_text_team_current . '</h6>';
							$current_teams = $player->current_teams();
							if ( $current_teams ):
								$teams = array();
								foreach ( $current_teams as $team ):
									$team_name = sp_team_short_name( $team );
									if ( $link_teams ) {
										$team_name = '<a href="' . get_post_permalink( $team ) . '">' . $team_name . '</a>';
									}
									$teams[] = $team_name;
								endforeach;
								$team_names_string = implode( ', ', $teams );
								echo '<div class="player-info-details__value">' . $team_names_string . '</div>';
							endif;
							echo '</div>';
						endif;
					?>

					<?php
						if ( $show_past_teams ):
							echo '<div class="player-info-details__item player-info-details__item--past-team">';
							echo '<h6 class="player-info-details__title">' . $sp_text_teams_past . '</h6>';
							$past_teams = $player->past_teams();
							if ( $past_teams ):
								$teams = array();
								foreach ( $past_teams as $team ):
									$team_name = sp_team_short_name( $team );
									if ( $link_teams ) {
										$team_name = '<a href="' . get_post_permalink( $team ) . '">' . $team_name . '</a>';
									}
									$teams[] = $team_name;
								endforeach;
								$team_names_string = implode( ', ', $teams );
								echo '<div class="player-info-details__value">' . $team_names_string . '</div>';
							endif;
							echo '</div>';
						endif;
					?>

					<?php
						if ( $show_leagues ):
							echo '<div class="player-info-details__item player-info-details__item--leagues">';
							echo '<h6 class="player-info-details__title">' . esc_html__( 'Competitions', 'alchemists' ) . '</h6>';
							$leagues = $player->leagues();
							if ( $leagues && ! is_wp_error( $leagues ) ):
								$terms = array();
								foreach ( $leagues as $league ):
									$terms[] = $league->name;
								endforeach;
								$terms_leagues_string = implode( ', ', $terms );
								echo '<div class="player-info-details__value">' . $terms_leagues_string . '</div>';
							endif;
							echo '</div>';
						endif;
					?>

					<?php
						if ( $show_seasons ):
							echo '<div class="player-info-details__item player-info-details__item--seasons">';
							echo '<h6 class="player-info-details__title">' . esc_html__( 'Seasons', 'alchemists' ) . '</h6>';
							$seasons = $player->seasons();
							if ( $seasons && ! is_wp_error( $seasons ) ):
								$terms = array();
								foreach ( $seasons as $season ):
									$terms[] = $season->name;
								endforeach;
								$terms_seasons_string = implode( ', ', $terms );
								echo '<div class="player-info-details__value">' . $terms_seasons_string . '</div>';
							endif;
							echo '</div>';
						endif;
					?>

					<?php
						if ( $show_nationality ):
							echo '<div class="player-info-details__item player-info-details__item--nationality">';
							echo '<h6 class="player-info-details__title">' . $sp_text_nationality . '</h6>';

							$nationalities = $player->nationalities();
							if ( $nationalities && is_array( $nationalities ) ) {
								$values = array();
								foreach ( $nationalities as $nationality ):
									$country_name = sp_array_value( $countries, $nationality, null );
									$values[] = $country_name ? ( $show_nationality_flags ? '<img src="' . plugin_dir_url( SP_PLUGIN_FILE ) . 'assets/images/flags/' . strtolower( $nationality ) . '.png" class="player-info-details__flag" alt="' . $nationality . '"> ' : '' ) . $country_name : '&mdash;';
								endforeach;
								$country_names_string = implode( ', ', $values );
								echo '<div class="player-info-details__value">' . $country_names_string . '</div>';
							} else {
								echo '<div class="player-info-details__value">' . esc_html__( 'n/a', 'alchemists' ) . '</div>';
							}

							echo '</div>';
						endif;
					?>

					<?php
						if ( $show_positions ):
							echo '<div class="player-info-details__item player-info-details__item--position">';
							echo '<h6 class="player-info-details__title">' . $sp_text_position . '</h6>';
							$positions = $player->positions();
							if ( $positions && is_array( $positions ) ) {
								$position_names = array();
								foreach ( $positions as $position ):
									$position_names[] = $position->name;
								endforeach;
								$position_names_string = implode( ', ', $position_names );
								echo '<div class="player-info-details__value">' . $position_names_string . '</div>';
							} else {
								echo '<div class="player-info-details__value">' . esc_html__( 'n/a', 'alchemists' ) . '</div>';
							}
							echo '</div>';
						endif;
					?>
				</div>


				<?php
				// Average Player Statistics
				sp_get_template( 'player-statistics-avg.php', array(
					'data' => $player->data(0),
				) );
				?>


			</div>
			<!-- Player Details / End -->

			<?php if ( $player_header_advanced_stats || is_null( $player_header_advanced_stats ) ) :
				// Player Stats
				if ( alchemists_sp_preset( 'soccer' ) || alchemists_sp_preset( 'football' ) ) {
					// Soccer: display progress bars
					sp_get_template( 'player-statistics-bars.php', array(
						'data' => $player->data(0),
					) );
				} else {
					// Basketball: display radar
					sp_get_template( 'player-statistics-radar.php', array(
						'data' => $player->data(0),
					) );
				}
				// Player Stats / End
			endif; ?>


		</div>
	</div>
</div>

<?php if ( sizeof( $player_subpages ) > 1 ) : ?>
<!-- Player Pages Filter -->
<nav class="content-filter">
	<div class="container">
		<a href="#" class="content-filter__toggle"></a>
		<ul class="content-filter__list">
			<li class="content-filter__item <?php if (!$current_player_page) { echo 'content-filter__item--active'; }; ?>">
				<a href="<?php echo esc_url( get_permalink() ); ?>" class="content-filter__link">
					<?php if ( $label_subtitle_on ) : ?>
						<small><?php echo esc_html( $label_subtitle ); ?></small>
					<?php endif; ?>
					<?php echo esc_html( $overview_label  ); ?>
				</a>
			</li>

			<?php if ( $player_subpages ): foreach ( $player_subpages as $key => $label ) {

				switch( $key ) {

					case 'stats': ?>
					<li class="content-filter__item <?php if ($current_player_page == $key) { echo 'content-filter__item--active'; }; ?>">
						<a href="<?php echo esc_url( get_permalink() ); ?><?php echo strtolower( trim( $stats_slug ) ); ?>/" class="content-filter__link">
							<?php if ( $label_subtitle_on ) : ?>
								<small><?php echo esc_html( $label_subtitle ); ?></small>
							<?php endif; ?>
							<?php echo esc_html( $stats_label ); ?>
						</a>
					</li>
					<?php break;

					case 'bio': ?>
					<li class="content-filter__item <?php if ($current_player_page == $key) { echo 'content-filter__item--active'; }; ?>">
						<a href="<?php echo esc_url( get_permalink() ); ?><?php echo strtolower( trim( $bio_slug ) ); ?>/" class="content-filter__link">
							<?php if ( $label_subtitle_on ) : ?>
								<small><?php echo esc_html( $label_subtitle ); ?></small>
							<?php endif; ?>
							<?php echo esc_html( $bio_label ); ?>
						</a>
					</li>
					<?php break;

					case 'news': ?>
					<li class="content-filter__item <?php if ($current_player_page == $key) { echo 'content-filter__item--active'; }; ?>">
						<a href="<?php echo esc_url( get_permalink() ); ?><?php echo strtolower( trim( $news_slug ) ); ?>/" class="content-filter__link">
							<?php if ( $label_subtitle_on ) : ?>
								<small><?php echo esc_html( $label_subtitle ); ?></small>
							<?php endif; ?>
							<?php echo esc_html( $news_label ); ?>
						</a>
					</li>
					<?php break;

					case 'gallery': ?>
					<li class="content-filter__item <?php if ($current_player_page == $key) { echo 'content-filter__item--active'; }; ?>">
						<a href="<?php echo esc_url( get_permalink() ); ?><?php echo strtolower( trim( $gallery_slug ) ); ?>/" class="content-filter__link">
							<?php if ( $label_subtitle_on ) : ?>
								<small><?php echo esc_html( $label_subtitle ); ?></small>
							<?php endif; ?>
							<?php echo esc_html( $gallery_label ); ?>
						</a>
					</li>
					<?php break;

				}

			}
			endif; ?>

		</ul>
	</div>
</nav>
<!-- Player Pages Filter / End -->
<?php endif; ?>


<div class="site-content" id="content">
	<?php while ( have_posts() ) : the_post();

		if (!$current_player_page) {
			get_template_part( 'sportspress/single-player/content', 'overview' );
		} else if ($current_player_page == 'stats') {
			get_template_part( 'sportspress/single-player/content', 'stats' );
		} else if ($current_player_page == 'bio') {
			get_template_part( 'sportspress/single-player/content', 'bio' );
		} else if ($current_player_page == 'news') {
			get_template_part( 'sportspress/single-player/content', 'news' );
		} else if ($current_player_page == 'gallery') {
			get_template_part( 'sportspress/single-player/content', 'gallery' );
		};

	endwhile; // end of the loop. ?>
</div>

<?php
get_footer();
