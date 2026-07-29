<?php
/**
 * Title: Film Section
 * Slug: honamas/film-section
 * Categories: honamas-sections
 */
$film_video = get_page_by_path( '39-honamas', OBJECT, 'attachment' );
$film_video_url = $film_video ? wp_get_attachment_url( $film_video->ID ) : '';
?>
<!-- wp:group {"align":"full","className":"honamas-film-teaser","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"backgroundColor":"honamas-black","textColor":"honamas-off-white","layout":{"type":"constrained"}} -->
<div id="film" class="wp-block-group alignfull honamas-film-teaser has-honamas-off-white-color has-honamas-black-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
	<?php if ( $film_video_url ) : ?>
		<video aria-hidden="true" autoplay class="honamas-film-teaser__video" loop muted playsinline preload="metadata" src="<?php echo esc_url( $film_video_url ); ?>"></video>
	<?php endif; ?>
	<!-- wp:group {"align":"wide","layout":{"type":"constrained","justifyContent":"left"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:paragraph {"className":"honamas-kicker","textColor":"honamas-pink-soft"} -->
		<p class="honamas-kicker has-honamas-pink-soft-color has-text-color"><?php esc_html_e( 'Film', 'honamas' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading -->
		<h2><?php esc_html_e( 'Der Weg zum Titel.', 'honamas' ); ?></h2>
		<!-- /wp:heading -->
		<!-- wp:paragraph {"fontSize":"large"} -->
		<p class="has-large-font-size"><?php esc_html_e( 'Der Film begleitet die deutsche Mannschaft durch die Heim-WM 2006 und erzählt, wie auf diesem Weg die HONAMAS entstanden.', 'honamas' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}}} -->
		<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--50)">
			<!-- wp:button -->
			<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/der-film/"><?php esc_html_e( 'Film ansehen', 'honamas' ); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
