<?php
/**
 * Title: Team Start Section
 * Slug: honamas/team-grid
 * Categories: honamas-sections
 */
$team_image = function_exists( 'honamas_core_render_team_start_image' )
	? honamas_core_render_team_start_image()
	: '<div class="honamas-team-start__placeholder" aria-hidden="true"></div>';
?>
<!-- wp:group {"align":"full","className":"honamas-team-start","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"backgroundColor":"honamas-white","layout":{"type":"constrained"}} -->
<div id="team" class="wp-block-group alignfull honamas-team-start has-honamas-white-background-color has-background" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
	<!-- wp:group {"align":"wide","layout":{"type":"constrained"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:paragraph {"className":"honamas-kicker","textColor":"honamas-red"} -->
		<p class="honamas-kicker has-honamas-red-color has-text-color"><?php esc_html_e( 'Die Ur-HONAMAS', 'honamas' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"margin":{"top":"var:preset|spacing|50"},"blockGap":{"left":"var:preset|spacing|70"}}}} -->
		<div class="wp-block-columns are-vertically-aligned-center" style="margin-top:var(--wp--preset--spacing--50)">
			<!-- wp:column {"width":"58%"} -->
			<div class="wp-block-column" style="flex-basis:58%">
				<?php echo wp_kses_post( $team_image ); ?>
			</div>
			<!-- /wp:column -->
			<!-- wp:column {"width":"42%"} -->
			<div class="wp-block-column" style="flex-basis:42%">
				<!-- wp:paragraph {"className":"honamas-team-start__number"} -->
				<p class="honamas-team-start__number">21</p>
				<!-- /wp:paragraph -->
				<!-- wp:heading -->
				<h2><?php esc_html_e( 'Ein Name. Ein Moment, der bleibt.', 'honamas' ); ?></h2>
				<!-- /wp:heading -->
				<!-- wp:paragraph {"fontSize":"large"} -->
				<p class="has-large-font-size"><?php esc_html_e( '2006 wurden diese Spieler in Mönchengladbach Weltmeister und legten damit den Grundstein für das, was heute als HONAMAS bekannt ist.', 'honamas' ); ?></p>
				<!-- /wp:paragraph -->
				<!-- wp:paragraph -->
				<p><?php esc_html_e( 'Jeder von ihnen hat diesen Namen mit Leben gefüllt.', 'honamas' ); ?></p>
				<!-- /wp:paragraph -->
				<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}}} -->
				<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--50)">
					<!-- wp:button -->
					<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/die-ur-honamas/"><?php esc_html_e( 'Das Team von 2006 entdecken', 'honamas' ); ?></a></div>
					<!-- /wp:button -->
				</div>
				<!-- /wp:buttons -->
			</div>
			<!-- /wp:column -->
		</div>
		<!-- /wp:columns -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
