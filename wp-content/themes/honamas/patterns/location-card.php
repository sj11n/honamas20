<?php
/**
 * Title: Location Card
 * Slug: honamas/location-card
 * Categories: honamas-reunion
 */
?>
<!-- wp:group {"style":{"border":{"width":"1px","color":"var:preset|color|honamas-line"},"spacing":{"padding":{"top":"var:preset|spacing|50","right":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group has-border-color" style="border-color:var(--wp--preset--color--honamas-line);border-width:1px;padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)">
	<!-- wp:paragraph {"className":"honamas-meta"} -->
	<p class="honamas-meta"><?php esc_html_e( 'Ort', 'honamas' ); ?></p>
	<!-- /wp:paragraph -->
	<!-- wp:heading {"level":3} -->
	<h3><?php esc_html_e( 'Location', 'honamas' ); ?></h3>
	<!-- /wp:heading -->
	<!-- wp:paragraph -->
	<p><?php esc_html_e( 'Adresse und optionale Kartenlinks bleiben redaktionell editierbar.', 'honamas' ); ?></p>
	<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
