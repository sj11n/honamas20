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

	add_editor_style( 'assets/css/theme.css' );
}
add_action( 'after_setup_theme', 'honamas_setup' );

/**
 * Enqueue front-end assets.
 */
function honamas_enqueue_assets(): void {
	wp_enqueue_style(
		'honamas-theme',
		get_theme_file_uri( 'assets/css/theme.css' ),
		array(),
		wp_get_theme()->get( 'Version' )
	);

	wp_enqueue_script(
		'honamas-reveal',
		get_theme_file_uri( 'assets/js/reveal.js' ),
		array(),
		wp_get_theme()->get( 'Version' ),
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);
}
add_action( 'wp_enqueue_scripts', 'honamas_enqueue_assets' );

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
