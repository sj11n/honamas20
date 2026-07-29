<?php
/**
 * Title: HONAMAS Hero
 * Slug: honamas/hero
 * Categories: honamas-sections
 * Viewport Width: 1440
 */
$hero_video = get_page_by_path( '39-honamas', OBJECT, 'attachment' );
$hero_video_url = $hero_video ? wp_get_attachment_url( $hero_video->ID ) : '';
$cover_attributes = array(
	'dimRatio'           => 72,
	'overlayColor'       => 'honamas-black',
	'isUserOverlayColor' => true,
	'minHeight'          => 88,
	'minHeightUnit'      => 'vh',
	'contentPosition'    => 'center center',
	'align'              => 'full',
	'className'          => 'honamas-video-hero',
	'style'              => array(
		'spacing' => array(
			'padding' => array(
				'top'    => 'var:preset|spacing|90',
				'right'  => 'var:preset|spacing|50',
				'bottom' => 'var:preset|spacing|80',
				'left'   => 'var:preset|spacing|50',
			),
		),
	),
	'layout'             => array( 'type' => 'constrained' ),
);

if ( $hero_video_url ) {
	$cover_attributes['url'] = $hero_video_url;
	$cover_attributes['backgroundType'] = 'video';
}
?>
<!-- wp:cover <?php echo wp_json_encode( $cover_attributes ); ?> -->
<div class="wp-block-cover alignfull honamas-video-hero" style="padding-top:var(--wp--preset--spacing--90);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--80);padding-left:var(--wp--preset--spacing--50);min-height:88vh"><span aria-hidden="true" class="wp-block-cover__background has-honamas-black-background-color has-background-dim-70 has-background-dim"></span>
	<?php if ( $hero_video_url ) : ?>
		<video aria-hidden="true" autoplay class="wp-block-cover__video-background intrinsic-ignore" loop muted playsinline preload="metadata" src="<?php echo esc_url( $hero_video_url ); ?>"></video>
	<?php endif; ?>
	<div class="wp-block-cover__inner-container">
	<!-- wp:group {"align":"wide","className":"honamas-hero-content","layout":{"type":"constrained","contentSize":"940px","justifyContent":"left"}} -->
	<div class="wp-block-group alignwide honamas-hero-content">
		<!-- wp:paragraph {"className":"honamas-kicker","textColor":"honamas-gold"} -->
		<p class="honamas-kicker has-honamas-gold-color has-text-color"><?php esc_html_e( 'Champions since 2006', 'honamas' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"level":1} -->
		<h1><?php esc_html_e( 'HONAMAS', 'honamas' ); ?></h1>
		<!-- /wp:heading -->
		<!-- wp:paragraph {"fontSize":"large"} -->
		<p class="has-large-font-size"><?php esc_html_e( 'Wie aus einer Mannschaftsidee ein Name für den deutschen Hockeysport wurde.', 'honamas' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:buttons -->
		<div class="wp-block-buttons">
			<!-- wp:button -->
			<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/die-idee/"><?php esc_html_e( 'Die Geschichte entdecken', 'honamas' ); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->
</div></div>
<!-- /wp:cover -->
