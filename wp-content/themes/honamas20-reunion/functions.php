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
		'honamas20-reunion-countdown',
		get_theme_file_uri( 'assets/js/reunion-countdown.js' ),
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);
	wp_enqueue_script(
		'honamas20-reunion-schedule',
		get_theme_file_uri( 'assets/js/reunion-schedule.js' ),
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'honamas_enqueue_assets' );

/**
 * Keep the directly shared reunion microsite out of search indexes.
 */
function honamas20_reunion_robots( array $robots ): array {
	$robots['noindex']   = true;
	$robots['nofollow']  = true;
	$robots['noarchive'] = true;
	$robots['nosnippet'] = true;
	return $robots;
}
add_filter( 'wp_robots', 'honamas20_reunion_robots' );
add_filter( 'wp_sitemaps_enabled', '__return_false' );

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
