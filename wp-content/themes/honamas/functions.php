<?php
/**
 * HONAMAS theme setup.
 *
 * @package Honamas
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register theme support and editor features.
 */
function honamas_setup(): void {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array( 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );

	add_editor_style( 'assets/css/site.css' );
}
add_action( 'after_setup_theme', 'honamas_setup' );

/**
 * Enqueue front-end assets.
 *
 * site.css and site.js carry the HONAMAS design on every page. The previous theme.css is only
 * loaded where the archive templates still rely on its classes.
 */
function honamas_enqueue_assets(): void {
	wp_enqueue_style(
		'honamas-site',
		get_theme_file_uri( 'assets/css/site.css' ),
		array(),
		(string) filemtime( get_theme_file_path( 'assets/css/site.css' ) )
	);

	if ( is_post_type_archive( 'honamas_archive_item' ) || is_singular( 'honamas_archive_item' ) ) {
		wp_enqueue_style(
			'honamas-archive',
			get_theme_file_uri( 'assets/css/theme.css' ),
			array( 'honamas-site' ),
			(string) filemtime( get_theme_file_path( 'assets/css/theme.css' ) )
		);
	}

	wp_enqueue_script(
		'honamas-site',
		get_theme_file_uri( 'assets/js/site.js' ),
		array(),
		(string) filemtime( get_theme_file_path( 'assets/js/site.js' ) ),
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);
}
add_action( 'wp_enqueue_scripts', 'honamas_enqueue_assets' );

/**
 * Mark the document as scripted before first paint, so entrance animations never hide content without JS,
 * and preload the display weight of the local font.
 */
function honamas_head_early(): void {
	echo "<script>document.documentElement.classList.add('js')</script>\n";
	printf(
		'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
		esc_url( get_theme_file_uri( 'assets/fonts/montserrat-latin-800-normal.woff2' ) )
	);
}
add_action( 'wp_head', 'honamas_head_early', 1 );

/**
 * Register HONAMAS pattern categories.
 */
function honamas_register_pattern_categories(): void {
	register_block_pattern_category(
		'honamas-sections',
		array( 'label' => __( 'HONAMAS Sections', 'honamas' ) )
	);

	register_block_pattern_category(
		'honamas-reunion',
		array( 'label' => __( 'HONAMAS Reunion', 'honamas' ) )
	);
}
add_action( 'init', 'honamas_register_pattern_categories' );

/**
 * Keep every non-production environment out of search indexes.
 *
 * Staging counts as non-production either by WP_ENVIRONMENT_TYPE or by host name.
 */
function honamas_is_non_production(): bool {
	$host = isset( $_SERVER['HTTP_HOST'] ) ? strtolower( sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) ) : '';

	return 'production' !== wp_get_environment_type() || str_starts_with( $host, 'staging.' );
}

function honamas_noindex_non_production( array $robots ): array {
	if ( honamas_is_non_production() ) {
		$robots['noindex']  = true;
		$robots['nofollow'] = true;
		unset( $robots['index'], $robots['follow'] );
	}

	return $robots;
}
add_filter( 'wp_robots', 'honamas_noindex_non_production' );

function honamas_disallow_non_production_robots( string $output ): string {
	return honamas_is_non_production() ? "User-agent: *\nDisallow: /\n" : $output;
}
add_filter( 'robots_txt', 'honamas_disallow_non_production_robots', 99 );

add_filter(
	'wp_sitemaps_enabled',
	static fn( bool $enabled ): bool => honamas_is_non_production() ? false : $enabled
);
