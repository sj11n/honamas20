<?php
/**
 * Plugin Name: HONAMAS Core
 * Description: Structured content for the HONAMAS archive and the Ur-HONAMAS team.
 * Version: 0.1.0
 * Requires at least: 6.6
 * Requires PHP: 8.1
 * Text Domain: honamas-core
 *
 * @package HonamasCore
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function honamas_core_register_content_types(): void {
	register_post_type(
		'honamas_archive_item',
		array(
			'labels' => array( 'name' => __( 'Archiv', 'honamas-core' ), 'singular_name' => __( 'Archivobjekt', 'honamas-core' ) ),
			'public' => true,
			'has_archive' => 'archiv',
			'rewrite' => array( 'slug' => 'archiv', 'with_front' => false ),
			'show_in_rest' => true,
			'menu_icon' => 'dashicons-archive',
			'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
		)
	);

	register_taxonomy(
		'honamas_archive_category',
		array( 'honamas_archive_item' ),
		array(
			'labels' => array( 'name' => __( 'Archivkategorien', 'honamas-core' ), 'singular_name' => __( 'Archivkategorie', 'honamas-core' ) ),
			'public' => true,
			'show_in_rest' => true,
			'rewrite' => array( 'slug' => 'archiv/kategorie', 'with_front' => false ),
		)
	);

	register_post_type(
		'honamas_team_member',
		array(
			'labels' => array( 'name' => __( 'Ur-HONAMAS', 'honamas-core' ), 'singular_name' => __( 'Teammitglied', 'honamas-core' ) ),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array( 'slug' => 'die-ur-honamas', 'with_front' => false ),
			'show_in_rest' => true,
			'menu_icon' => 'dashicons-groups',
			'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
		)
	);
}
add_action( 'init', 'honamas_core_register_content_types' );

function honamas_core_register_meta(): void {
	$archive_fields = array( 'asset_date', 'origin', 'credit', 'rights_note', 'source_url', 'related_chapter', 'file_id' );
	foreach ( $archive_fields as $field ) {
		$is_integer = in_array( $field, array( 'file_id', 'related_chapter' ), true );
		register_post_meta(
			'honamas_archive_item',
			'honamas_' . $field,
			array(
				'single'            => true,
				'show_in_rest'      => true,
				'type'              => $is_integer ? 'integer' : 'string',
				'sanitize_callback' => $is_integer ? 'absint' : ( $field === 'source_url' ? 'esc_url_raw' : 'sanitize_text_field' ),
				'auth_callback'     => static fn() => current_user_can( 'edit_posts' ),
			)
		);
	}
	foreach ( array( 'jersey_number', 'nickname', 'position_2006', 'club_2006', 'team_quote' ) as $field ) {
		register_post_meta( 'honamas_team_member', 'honamas_' . $field, array( 'single' => true, 'show_in_rest' => true, 'type' => $field === 'jersey_number' ? 'integer' : 'string', 'sanitize_callback' => $field === 'jersey_number' ? 'absint' : 'sanitize_text_field', 'auth_callback' => static fn() => current_user_can( 'edit_posts' ) ) );
	}
}
add_action( 'init', 'honamas_core_register_meta' );

function honamas_core_seed_archive_categories(): void {
	foreach ( array( 'dokumente' => 'Dokumente', 'kleidung' => 'Kleidung', 'fotos' => 'Fotos', 'presse' => 'Presse' ) as $slug => $name ) {
		if ( ! term_exists( $slug, 'honamas_archive_category' ) ) {
			wp_insert_term( $name, 'honamas_archive_category', array( 'slug' => $slug ) );
		}
	}
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'honamas_core_seed_archive_categories' );
register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
