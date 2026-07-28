<?php
/**
 * Title: Film Section
 * Slug: honamas/film-section
 * Categories: honamas-sections
 */
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"backgroundColor":"honamas-black","textColor":"honamas-off-white","layout":{"type":"constrained"}} -->
<div id="film" class="wp-block-group alignfull has-honamas-off-white-color has-honamas-black-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
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
		<!-- wp:embed {"providerNameSlug":"youtube","responsive":true,"className":"wp-embed-aspect-16-9 wp-has-aspect-ratio"} -->
		<figure class="wp-block-embed is-provider-youtube wp-block-embed-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio"><div class="wp-block-embed__wrapper"></div></figure>
		<!-- /wp:embed -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
