<?php
/**
 * Template Name: estadistica
 *
 * @author    Dan Fisher
 * @package   Alchemists
 * @since     1.0.0
 * @version   3.0.10
 */


get_header();

global $post;

$current_copa_page = get_query_var('teampage');

$alchemists_data       = get_option('alchemists_data');
$page_heading_overlay  = isset( $alchemists_data['alchemists__opt-page-title-overlay-on'] ) ? $alchemists_data['alchemists__opt-page-title-overlay-on'] : '';
$breadcrumbs           = isset( $alchemists_data['alchemists__opt-page-title-breadcrumbs'] ) ? $alchemists_data['alchemists__opt-page-title-breadcrumbs'] : '';
$label_subtitle_on     = isset( $alchemists_data['alchemists__team-subpages-label--subtitle'] ) ? $alchemists_data['alchemists__team-subpages-label--subtitle'] : 1;
$label_subtitle        = isset( $alchemists_data['alchemists__team-subpages-label--subtitle-custom'] ) && ! empty( $alchemists_data['alchemists__team-subpages-label--subtitle-custom'] ) ? $alchemists_data['alchemists__team-subpages-label--subtitle-custom'] : esc_html__( 'The Team', 'alchemists' );

if ( $page_heading_overlay == 0 ) {
	$page_heading_overlay = 'page-heading--no-bg';
} else {
	$page_heading_overlay = 'page-heading--has-bg';
}

$team_subpages         = isset( $alchemists_data['alchemists__team-subpages']['enabled'] ) ? $alchemists_data['alchemists__team-subpages']['enabled'] : array( 'roster' => esc_html__( 'Roster', 'alchemists' ), 'standings' => esc_html__( 'Standings', 'alchemists' ), 'results' => esc_html__( 'Latest Results', 'alchemists' ), 'schedule' => esc_html__( 'Schedule', 'alchemists' ), 'gallery' => esc_html__( 'Gallery', 'alchemists' ));

$estadistica_subpages = array('resultados' , 'calendario', 'rankings', 'equipos', 'jugadores', 'finales');

$overview_label        = isset( $alchemists_data['alchemists__team-subpages-label--overview'] ) ? esc_html( $alchemists_data['alchemists__team-subpages-label--overview'] ) : esc_html__( 'Overview', 'alchemists' );
$roster_label          = isset( $alchemists_data['alchemists__team-subpages-label--roster'] ) ? esc_html( $alchemists_data['alchemists__team-subpages-label--roster'] ) : esc_html__( 'Roster', 'alchemists' );
$standings_label       = isset( $alchemists_data['alchemists__team-subpages-label--standings'] ) ? esc_html( $alchemists_data['alchemists__team-subpages-label--standings'] ) : esc_html__( 'Standings', 'alchemists' );
$results_label         = isset( $alchemists_data['alchemists__team-subpages-label--results'] ) ? esc_html( $alchemists_data['alchemists__team-subpages-label--results'] ) : esc_html__( 'Latest Results', 'alchemists' );
$schedule_label        = isset( $alchemists_data['alchemists__team-subpages-label--schedule'] ) ? esc_html( $alchemists_data['alchemists__team-subpages-label--schedule'] ) : esc_html__( 'Schedule', 'alchemists' );
$gallery_label         = isset( $alchemists_data['alchemists__team-subpages-label--gallery'] ) ? esc_html( $alchemists_data['alchemists__team-subpages-label--gallery'] ) : esc_html__( 'Gallery', 'alchemists' );

$roster_slug           = isset( $alchemists_data['alchemists__team-subpages-slug--roster'] ) ? esc_html( $alchemists_data['alchemists__team-subpages-slug--roster'] ) : 'roster';
$standings_slug        = isset( $alchemists_data['alchemists__team-subpages-slug--standings'] ) ? esc_html( $alchemists_data['alchemists__team-subpages-slug--standings'] ) : 'standings';
$results_slug          = isset( $alchemists_data['alchemists__team-subpages-slug--results'] ) ? esc_html( $alchemists_data['alchemists__team-subpages-slug--results'] ) : 'results';
$schedule_slug         = isset( $alchemists_data['alchemists__team-subpages-slug--schedule'] ) ? esc_html( $alchemists_data['alchemists__team-subpages-slug--schedule'] ) : 'schedule';
$gallery_slug          = isset( $alchemists_data['alchemists__team-subpages-slug--gallery'] ) ? esc_html( $alchemists_data['alchemists__team-subpages-slug--gallery'] ) : 'gallery';

$content_classes = array();

// Page Options
$page_heading                = get_field('page_heading');
$page_content_top_padding    = get_field('page_content_top_padding');
$page_content_bottom_padding = get_field('page_content_bottom_padding');

// Custom Page Heading Options
$page_heading_customize      = get_field('page_heading_customize');
$page_heading_style          = array();
$page_heading_styles_output  = array();

if ( $page_heading_customize ) {
	// Page Heading Background Image
	$page_heading_custom_background_img = get_field('page_heading_custom_background_img');

	if ( $page_heading_custom_background_img ) {
		// if background image selected display it
		$page_heading_style[] = 'background-image: url(' . $page_heading_custom_background_img . ');';
	} else {
		// if not, remove the default one
		$page_heading_style[] = 'background-image: none;';
	}

	// Page Heading Background Color
	$page_heading_custom_background_color = get_field('page_heading_custom_background_color');
	if ( $page_heading_custom_background_color ) {
		$page_heading_style[] = 'background-color: ' . $page_heading_custom_background_color . ';';
	}

	// Overlay
	$page_heading_add_overlay_on = get_field('page_heading_add_overlay_on');
	// hide pseudoelement if overlay disabled
	if ( empty( $page_heading_add_overlay_on ) ) {
		$page_heading_overlay = 'page-heading--no-bg';
	}

	$page_heading_custom_overlay_color = get_field('page_heading_custom_overlay_color') ? get_field('page_heading_custom_overlay_color') : 'transparent';
	$page_heading_custom_overlay_opacity = get_field( 'page_heading_custom_overlay_opacity' );
	$page_heading_remove_overlay_pattern = get_field( 'page_heading_remove_overlay_pattern' );

	if ( $page_heading_add_overlay_on ) {
		echo '<style>';
			echo '.page-heading::before {';
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

// Page Content Options
$page_content_top_padding_class = '';
if ( $page_content_top_padding == 'none' ) {
	$content_classes[] = 'pt-0';
}

$page_content_bottom_padding_class = '';
if ( $page_content_bottom_padding == 'none' ) {
	$content_classes[] = 'pb-0';
}

if ( ! isset( $id ) ) {
	$id = get_the_ID();
}

$data = array();

$terms = get_the_terms( $id, 'sp_league' );

?>

<!-- Page Heading
================================================== -->
<div class="page-heading <?php echo esc_attr( $page_heading_overlay ); ?>" <?php echo implode( ' ', $page_heading_styles_output ); ?>>
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<?php the_title( '<h1 class="page-heading__title">', '</h1>' ); ?>
				<?php
				// Breadcrumb
				if ( function_exists( 'breadcrumb_trail' ) && $breadcrumbs != 0 ) {
					breadcrumb_trail( array(
						'show_browse' => false,
						// 'show_title'  => false
					));
				}?>
			</div>
		</div>
	</div>
</div>

<!-- get page child -->
	<?php
	
	//get slug
	global $wp;
	$slug = add_query_arg( array(), $wp->request );
	//echo $slug;
	// get the page name
	$parent_title = get_the_title($post->post_parent);
 	$parent_name = 'estadistica';
	// display page name
	//echo $parent_title;
	?>
<!-- get page child End -->

<?php if ( sizeof( $estadistica_subpages ) > 1 ) : ?>

<!-- Team Pages Filter -->
<nav class="content-filter">
	<div class="container">
		<a href="#" class="content-filter__toggle"></a>
		<ul class="content-filter__list">

			<!--<li class="content-filter__item <?php if (!$current_copa_page) { echo 'content-filter__item--active'; }; ?>">
				<a href="<?php echo esc_url( get_permalink() ); ?>" class="content-filter__link">
				<?php if ( $label_subtitle_on ) : ?>
					<small><?php echo esc_html( $label_subtitle ); ?></small>
				<?php endif; ?>
				<?php echo esc_html( $overview_label  ); ?></a>-->
			</li>
			<li class="content-filter__item <?php if ($slug == 'estadistica/resultados') { echo 'content-filter__item--active'; }; ?>">
						<a href="<?php echo esc_url( get_permalink() ); ?><?php echo ('resultados'); ?>/" class="content-filter__link">
							<?php if ( $label_subtitle_on ) : ?>
								<small><?php echo esc_html('Torneos'); ?></small>
							<?php endif; ?>
							<?php echo esc_html( 'Resultados' ); ?>
						</a>
					</li>
			<li class="content-filter__item <?php if ($slug == 'estadistica/calendario') { echo 'content-filter__item--active'; }; ?>">
						<a href="<?php echo esc_url( get_permalink() ); ?><?php echo ('calendario'); ?>/" class="content-filter__link">
							<?php if ( $label_subtitle_on ) : ?>
								<small><?php echo esc_html('Torneos'); ?></small>
							<?php endif; ?>
							<?php echo esc_html( 'Calendarios' ); ?>
						</a>
					</li>
			<li class="content-filter__item <?php if ($slug == 'estadistica/clasificacion') { echo 'content-filter__item--active'; }; ?>">
						<a href="<?php echo esc_url( get_permalink() ); ?><?php echo ('clasificacion'); ?>/" class="content-filter__link">
							<?php if ( $label_subtitle_on ) : ?>
								<small><?php echo esc_html('Torneos'); ?></small>
							<?php endif; ?>
							<?php echo esc_html( 'Clasificación' ); ?>
						</a>
					</li>
			<li class="content-filter__item <?php if ($slug == 'estadistica/rankings') { echo 'content-filter__item--active'; }; ?>">
						<a href="<?php echo esc_url( get_permalink() ); ?><?php echo ('rankings'); ?>/" class="content-filter__link">
							<?php if ( $label_subtitle_on ) : ?>
								<small><?php echo esc_html('Torneos'); ?></small>
							<?php endif; ?>
							<?php echo esc_html( 'rankings' ); ?>
						</a>
			</li>
			<li class="content-filter__item <?php if ($slug == 'estadistica/equipos') { echo 'content-filter__item--active'; }; ?>">
						<a href="<?php echo esc_url( get_permalink() ); ?><?php echo ('equipo'); ?>/" class="content-filter__link">
							<?php if ( $label_subtitle_on ) : ?>
								<small><?php echo esc_html('Torneos'); ?></small>
							<?php endif; ?>
							<?php echo esc_html( 'Equipos' ); ?>
						</a>
			</li>
			<li class="content-filter__item <?php if ($slug ==  'estadistica/jugadores') { echo 'content-filter__item--active'; }; ?>">
						<a href="<?php echo esc_url( get_permalink() ); ?><?php echo ('jugadores'); ?>/" class="content-filter__link">
							<?php if ( $label_subtitle_on ) : ?>
								<small><?php echo esc_html('Torneos'); ?></small>
							<?php endif; ?>
							<?php echo esc_html( 'Jugadores' ); ?>
						</a>
			</li>
			<li class="content-filter__item <?php if ($slug == 'estadistica/finales') { echo 'content-filter__item--active'; }; ?>">
						<a href="<?php echo esc_url( get_permalink() ); ?><?php echo ('finales'); ?>/" class="content-filter__link">
							<?php if ( $label_subtitle_on ) : ?>
								<small><?php echo esc_html('Torneos'); ?></small>
							<?php endif; ?>
							<?php echo esc_html( 'finales' ); ?>
						</a>
			</li>


			
		</ul>
	</div>
</nav>
<!-- Team Pages Filter / End -->
<?php endif; ?>


<div class="site-content <?php echo implode( ' ', $content_classes ); ?>" id="content">
	<div class="container">
		<div class="row">

			<div id="primary" class="content-area col-md-12">
				<main id="main" class="site-main">
					<!-- content -->
							<?php the_content(); ?>
					<!-- contente end -->

				</main>
			</div>
		</div>
	</div>

</div>

<?php
get_footer();
