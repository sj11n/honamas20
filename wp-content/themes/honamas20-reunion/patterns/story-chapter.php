<?php
/**
 * Title: Story Chapter
 * Slug: honamas/story-chapter
 * Categories: honamas-sections
 */
?>
<!-- wp:group {"align":"full","className":"honamas-section-grid honamas-story-origin","style":{"spacing":{"padding":{"top":"var:preset|spacing|90","bottom":"var:preset|spacing|90"}}},"backgroundColor":"honamas-white","layout":{"type":"constrained"}} -->
<div id="story" class="wp-block-group alignfull honamas-section-grid honamas-story-origin has-honamas-white-background-color has-background" style="padding-top:var(--wp--preset--spacing--90);padding-bottom:var(--wp--preset--spacing--90)">
	<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|70"}}}} -->
	<div class="wp-block-columns alignwide">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:paragraph {"className":"honamas-kicker","textColor":"honamas-red"} -->
			<p class="honamas-kicker has-honamas-red-color has-text-color"><?php esc_html_e( 'Die Gründungsidee', 'honamas' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:heading -->
			<h2><?php esc_html_e( 'Aus einer Frage wurde ein Name.', 'honamas' ); ?></h2>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:paragraph {"fontSize":"large"} -->
			<p class="has-large-font-size"><?php esc_html_e( 'Anfang der 2000er-Jahre fiel Björn Emmerling auf einer Australienreise auf, dass Namen wie Kookaburras, Wallabies und Hockeyroos ohne Erklärung verstanden wurden. Seine Frage war: Warum sollte das im deutschen Hockey nicht auch funktionieren?', 'honamas' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph -->
			<p><?php esc_html_e( 'Vor der Heim-WM 2006 stellte er die Idee der Mannschaft in einem Trainingslager in Mönchengladbach vor. In der Runde im Whirlpool entstand aus der scherzhaft erwähnten „FuBaNaMa“ die Abkürzung HOckey NAtional MAnnSchaft: HONAMAS.', 'honamas' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}}} -->
			<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--50)">
				<!-- wp:button -->
				<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/die-idee/"><?php esc_html_e( 'Die Geschichte lesen', 'honamas' ); ?></a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
