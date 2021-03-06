<?php
/**
 * The template for displaying Single Team
 *
 * @author    Dan Fisher
 * @package   Alchemists
 * @since     1.0.0
 * @version   3.0.0
 */
?>
<style>
    .copa-download-image {
        display: inline-block;
        font-size: 1.5em;
        padding: 10px;
        background-color: #444;
        cursor: pointer;
    }
</style>
<div class="album__item col-xs-6 col-sm-4">
	<div class="album__item-holder">
		<a href="<?php echo esc_url( $image['url'] ); ?>" class="album__item-link mp_gallery">
			<figure class="album__thumb">
				<img src="<?php echo esc_url( $image['sizes']['large'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>">
			</figure>
			<div class="album__item-desc">
				<?php if ( $image['title'] ) : ?>
				<h4 class="album__item-title"><?php echo esc_html( $image['title'] ); ?></h4>
				<?php endif; ?>
				<?php if ( $image['caption'] ) : ?>
				<div class="album__item-date"><?php echo esc_html( $image['caption'] ); ?></div>
				<?php endif; ?>
				<span class="album__item-btn-fab btn-fab btn-fab--clean"></span>
				<div class="album__item-download">
					<div class="copa-download-image">
                        <div onclick="window.open('<?php echo esc_url( $image['sizes']['full'] ) . '?attachment_id=' . $image['ID'] . '&download_image=1'; ?>', '_blank'); return false;">
                            <i class="fa fa-download"></i>
                        </div>
                    </div>
				</div>
			</div>
		</a>
	</div>
</div>
