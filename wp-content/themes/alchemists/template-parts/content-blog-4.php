<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @author    Dan Fisher
 * @package   Alchemists
 * @since     1.1.0
 * @version   3.0.7
 */

$alchemists_data   = get_option('alchemists_data');
$categories_toggle = isset( $alchemists_data['alchemists__posts-categories'] ) ? $alchemists_data['alchemists__posts-categories'] : 1;

// get post category class
$post_class = alchemists_post_category_class();

$post_classes = array(
	'posts__item',
	'posts__item--card',
	'card',
	$post_class
);

?>

<div class="post-grid__item col-sm-6 col-md-4">
	<article <?php post_class( $post_classes ); ?>>
		<?php if( has_post_thumbnail() ) { ?>
		<figure class="posts__thumb">

			<?php if ( $categories_toggle ) : ?>
				<?php alchemists_post_category_labels(); ?>
			<?php endif; ?>

			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('alchemists_thumbnail'); ?></a>
		</figure>
		<?php } ?>

		<div class="posts__inner card__content">
			<?php if( has_post_thumbnail() ) { ?>
			<a href="<?php the_permalink(); ?>" class="posts__cta"></a>
			<?php } ?>
			<time datetime="<?php esc_attr( the_time('c') ); ?>" class="posts__date"><?php the_time( get_option('date_format') ); ?></time>
			<?php the_title( '<h2 class="posts__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
		</div>

		<footer class="posts__footer card__footer">
			<?php alchemists_entry_footer(); ?>
		</footer>

	</article><!-- #post-## -->
</div>
