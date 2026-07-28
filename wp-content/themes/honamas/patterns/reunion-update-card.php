<?php
/**
 * Title: Reunion Update Card
 * Slug: honamas/reunion-update-card
 * Categories: honamas-reunion
 */
?>
<!-- wp:group {"style":{"border":{"width":"1px","color":"var:preset|color|honamas-line"},"spacing":{"padding":{"top":"var:preset|spacing|50","right":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group has-border-color" style="border-color:var(--wp--preset--color--honamas-line);border-width:1px;padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)">
	<!-- wp:paragraph {"className":"honamas-meta"} -->
	<p class="honamas-meta"><?php esc_html_e( 'Aktuell', 'honamas' ); ?></p>
	<!-- /wp:paragraph -->
	<!-- wp:heading {"level":3} -->
	<h3><?php esc_html_e( 'Aktueller Stand', 'honamas' ); ?></h3>
	<!-- /wp:heading -->
	<!-- wp:paragraph -->
	<p><?php esc_html_e( 'Der neueste Hinweis für die gemeinsame Planung.', 'honamas' ); ?></p>
	<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
