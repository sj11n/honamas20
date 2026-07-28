<?php
/**
 * Title: HONAMAS Hero
 * Slug: honamas/hero
 * Categories: honamas-sections
 * Viewport Width: 1440
 */
?>
<!-- wp:cover {"dimRatio":72,"overlayColor":"honamas-black","isUserOverlayColor":true,"minHeight":88,"minHeightUnit":"vh","contentPosition":"center center","align":"full","className":"honamas-video-hero","style":{"spacing":{"padding":{"top":"var:preset|spacing|90","right":"var:preset|spacing|50","bottom":"var:preset|spacing|80","left":"var:preset|spacing|50"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-cover alignfull honamas-video-hero" style="padding-top:var(--wp--preset--spacing--90);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--80);padding-left:var(--wp--preset--spacing--50);min-height:88vh"><span aria-hidden="true" class="wp-block-cover__background has-honamas-black-background-color has-background-dim-70 has-background-dim"></span><div class="wp-block-cover__inner-container">
	<!-- wp:group {"align":"wide","className":"honamas-hero-content","layout":{"type":"constrained","contentSize":"940px","justifyContent":"left"}} -->
	<div class="wp-block-group alignwide honamas-hero-content">
		<!-- wp:paragraph {"className":"honamas-kicker","textColor":"honamas-gold"} -->
		<p class="honamas-kicker has-honamas-gold-color has-text-color"><?php esc_html_e( 'Champions since 2006', 'honamas' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"level":1} -->
		<h1><?php esc_html_e( 'HONAMAS', 'honamas' ); ?></h1>
		<!-- /wp:heading -->
		<!-- wp:paragraph {"fontSize":"large"} -->
		<p class="has-large-font-size"><?php esc_html_e( 'Eine Mannschaft gab sich einen Namen, baute eine Identität und wurde Weltmeister.', 'honamas' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:buttons -->
		<div class="wp-block-buttons">
			<!-- wp:button -->
			<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#story"><?php esc_html_e( 'Story lesen', 'honamas' ); ?></a></div>
			<!-- /wp:button -->
			<!-- wp:button {"className":"is-style-outline"} -->
			<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#film"><?php esc_html_e( 'Film ansehen', 'honamas' ); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->
</div></div>
<!-- /wp:cover -->
