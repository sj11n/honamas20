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
 * Seed required reunion content on fresh WordPress installs.
 */
function honamas20_reunion_seed_content(): void {
	if ( get_option( 'honamas20_reunion_seed_version' ) === '2026-08-24-clean' ) {
		return;
	}

	update_option( 'blogname', 'HONAMAS | 20' );
	update_option( 'blogdescription', 'Die Reunion zum 20-jährigen Jubiläum des WM-Titels von 2006.' );
	update_option( 'blog_public', '0' );
	update_option( 'default_comment_status', 'closed' );
	update_option( 'default_ping_status', 'closed' );
	update_option( 'permalink_structure', '/%postname%/' );
	flush_rewrite_rules( false );

	$default_post = get_page_by_path( 'hallo-welt', OBJECT, 'post' );
	if ( $default_post instanceof WP_Post ) {
		wp_trash_post( $default_post->ID );
	}

	$sample_page = get_page_by_path( 'beispiel-seite', OBJECT, 'page' );
	if ( $sample_page instanceof WP_Post ) {
		wp_trash_post( $sample_page->ID );
	}

	$default_comments = get_comments(
		array(
			'author_email' => 'wapuu@wordpress.example',
			'status'       => 'all',
		)
	);
	foreach ( $default_comments as $comment ) {
		wp_delete_comment( $comment->comment_ID, true );
	}

	$survey_post = get_page_by_path( 'noch-30-tage-bis-amstelveen-zandvoort', OBJECT, 'post' );
	$post_data   = array(
		'post_title'     => 'Noch 30 Tage bis Amstelveen & Zandvoort',
		'post_name'      => 'noch-30-tage-bis-amstelveen-zandvoort',
		'post_status'    => 'publish',
		'post_type'      => 'post',
		'comment_status' => 'closed',
		'ping_status'    => 'closed',
		'post_excerpt'   => 'Der Countdown läuft: Bitte gebt kurz eure Infos zu Anreise, Zimmern und Trikotgrößen durch.',
		'post_content'   => '<!-- wp:paragraph --><p>Männer, der Countdown läuft: Noch 30 Tage bis Amstelveen &amp; Zandvoort.</p><!-- /wp:paragraph -->'
			. '<!-- wp:paragraph --><p>Damit Logistik, Betten und der Feinschliff für unser 20-Jähriges exakt sitzen, brauchen wir kurz ein paar Infos von euch: Anreise, Zimmer und Trikotgrößen.</p><!-- /wp:paragraph -->'
			. '<!-- wp:paragraph --><p>Bitte klickt euch kurz durch. Das dauert keine zwei Minuten:</p><!-- /wp:paragraph -->'
			. '<!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="https://forms.gle/bhXtjRmeoqyaZi468">Zur Umfrage</a></div><!-- /wp:button --></div><!-- /wp:buttons -->'
			. '<!-- wp:paragraph --><p><strong>Deadline:</strong> Freitag, 31.07. Selbe Frist wie die Steuererklärung, aber das hier macht definitiv mehr Spaß.</p><!-- /wp:paragraph -->'
			. '<!-- wp:paragraph --><p>Tickets fürs Halbfinale sind gebucht, Hotels stehen. Sobald alle Daten da sind, droppen die finalen Details im Laufe des August.</p><!-- /wp:paragraph -->'
			. '<!-- wp:paragraph --><p>Let’s go!</p><!-- /wp:paragraph -->'
			. '<!-- wp:paragraph --><p>Euer Orga-Team Bernie, Jambo und Emmel</p><!-- /wp:paragraph -->',
	);

	if ( $survey_post instanceof WP_Post ) {
		$post_data['ID'] = $survey_post->ID;
		wp_update_post( wp_slash( $post_data ) );
	} else {
		wp_insert_post( wp_slash( $post_data ) );
	}

	update_option( 'honamas20_reunion_seed_version', '2026-08-24-clean' );
}
add_action( 'admin_init', 'honamas20_reunion_seed_content' );

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
