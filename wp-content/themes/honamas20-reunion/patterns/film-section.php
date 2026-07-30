<?php
/**
 * Title: Film Section
 * Slug: honamas/film-section
 * Categories: honamas-sections
 */
$youtube_video_id = '8ia99ri8mek';
?>
<!-- wp:group {"align":"full","className":"honamas-film-teaser","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"backgroundColor":"honamas-black","textColor":"honamas-off-white","layout":{"type":"constrained"}} -->
<div id="film" class="wp-block-group alignfull honamas-film-teaser has-honamas-off-white-color has-honamas-black-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
	<div aria-hidden="true" class="honamas-film-teaser__video">
		<iframe allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen="false" frameborder="0" src="https://www.youtube-nocookie.com/embed/<?php echo esc_attr( $youtube_video_id ); ?>?autoplay=1&amp;mute=1&amp;controls=0&amp;disablekb=1&amp;fs=0&amp;loop=1&amp;modestbranding=1&amp;playlist=<?php echo esc_attr( $youtube_video_id ); ?>&amp;playsinline=1&amp;rel=0" tabindex="-1" title=""></iframe>
	</div>
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
