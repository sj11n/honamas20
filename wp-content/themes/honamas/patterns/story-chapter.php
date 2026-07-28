<?php
/**
 * Title: Story Chapter
 * Slug: honamas/story-chapter
 * Categories: honamas-sections
 */
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"backgroundColor":"honamas-white","layout":{"type":"constrained"}} -->
<div id="story" class="wp-block-group alignfull has-honamas-white-background-color has-background" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
	<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|70"}}}} -->
	<div class="wp-block-columns alignwide">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:paragraph {"className":"honamas-kicker","textColor":"honamas-red"} -->
			<p class="honamas-kicker has-honamas-red-color has-text-color"><?php esc_html_e( 'Die Gruendungsidee', 'honamas' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:heading -->
			<h2><?php esc_html_e( 'Aus einer Frage wurde ein Name.', 'honamas' ); ?></h2>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:paragraph {"fontSize":"large"} -->
			<p class="has-large-font-size"><?php esc_html_e( 'HONAMAS steht fuer eine Spieleridentitaet, die sich nicht von aussen verordnen liess. Sie entstand aus der Mannschaft und wurde 2006 sichtbar.', 'honamas' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph -->
			<p><?php esc_html_e( 'Dieser Abschnitt bleibt redaktionell editierbar und kann mit Originaltexten, Fotos und Zitaten ergaenzt werden.', 'honamas' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
