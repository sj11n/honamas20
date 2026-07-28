<?php
/**
 * Title: HONAMAS Hero
 * Slug: honamas/hero
 * Categories: honamas-sections
 * Viewport Width: 1440
 */
?>
<!-- wp:group {"align":"full","className":"honamas-board","style":{"spacing":{"padding":{"top":"var:preset|spacing|90","bottom":"var:preset|spacing|80"}}},"backgroundColor":"honamas-black","textColor":"honamas-off-white","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull honamas-board has-honamas-off-white-color has-honamas-black-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--90);padding-bottom:var(--wp--preset--spacing--80)">
	<!-- wp:group {"align":"wide","layout":{"type":"constrained","contentSize":"940px","justifyContent":"left"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:paragraph {"className":"honamas-kicker","textColor":"honamas-gold"} -->
		<p class="honamas-kicker has-honamas-gold-color has-text-color"><?php esc_html_e( '20 Jahre Teamidentitaet', 'honamas' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"level":1} -->
		<h1><?php esc_html_e( 'HONAMAS', 'honamas' ); ?></h1>
		<!-- /wp:heading -->
		<!-- wp:paragraph {"fontSize":"large"} -->
		<p class="has-large-font-size"><?php esc_html_e( 'Eine Mannschaft gab sich einen Namen, baute eine Identitaet und wurde Weltmeister.', 'honamas' ); ?></p>
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
</div>
<!-- /wp:group -->
