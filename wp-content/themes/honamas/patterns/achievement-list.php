<?php
/**
 * Title: Achievement List
 * Slug: honamas/achievement-list
 * Categories: honamas-sections
 */
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"backgroundColor":"honamas-off-white","layout":{"type":"constrained"}} -->
<div id="erfolge" class="wp-block-group alignfull has-honamas-off-white-background-color has-background" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
	<!-- wp:group {"align":"wide","layout":{"type":"constrained","justifyContent":"left"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:paragraph {"className":"honamas-kicker","textColor":"honamas-gold"} -->
		<p class="honamas-kicker has-honamas-gold-color has-text-color"><?php esc_html_e( 'Erfolge', 'honamas' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading -->
		<h2><?php esc_html_e( 'Die Erfolge der HONAMAS.', 'honamas' ); ?></h2>
		<!-- /wp:heading -->
		<!-- wp:list {"className":"honamas-meta","style":{"spacing":{"margin":{"top":"var:preset|spacing|60"}}}} -->
		<ul class="honamas-meta" style="margin-top:var(--wp--preset--spacing--60)">
			<li><?php esc_html_e( '2006 - Weltmeister', 'honamas' ); ?></li>
			<li><?php esc_html_e( '2008 - Olympiasieger', 'honamas' ); ?></li>
			<li><?php esc_html_e( '2011 - Europameister', 'honamas' ); ?></li>
			<li><?php esc_html_e( '2012 - Olympiasieger', 'honamas' ); ?></li>
			<li><?php esc_html_e( '2013 - Europameister', 'honamas' ); ?></li>
			<li><?php esc_html_e( '2023 - Weltmeister', 'honamas' ); ?></li>
			<li><?php esc_html_e( '2025 - Europameister', 'honamas' ); ?></li>
		</ul>
		<!-- /wp:list -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
