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
	if ( get_option( 'honamas20_reunion_seed_version' ) === '2026-08-24-playlist-2006' ) {
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
		'post_date'      => '2026-07-30 08:39:13',
		'post_date_gmt'  => '2026-07-30 06:39:13',
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

	$nomination_post = get_page_by_path( 'nominierung-fuer-h20', OBJECT, 'post' );
	$nomination_data = array(
		'post_title'     => 'Nominierung für H20',
		'post_name'      => 'nominierung-fuer-h20',
		'post_status'    => 'publish',
		'post_type'      => 'post',
		'post_date'      => '2026-08-21 21:49:13',
		'post_date_gmt'  => '2026-08-21 19:49:13',
		'comment_status' => 'closed',
		'ping_status'    => 'closed',
		'post_excerpt'   => 'Die Starting 21 für das Reunion-Wochenende 2026 stehen fest.',
		'post_content'   => '<!-- wp:paragraph --><p>🏑 <strong>Die Nominierung steht: Unsere Starting 21 für das Reunion-Wochenende 2026!</strong></p><!-- /wp:paragraph -->'
			. '<!-- wp:paragraph --><p>20 Jahre nach dem Weltmeistertitel von Mönchengladbach geht es für die HONAMAS von 2006 noch einmal gemeinsam auf Tour. Vom <strong>28. bis 30. August 2026</strong> treffen wir uns in <strong>Amstelveen und Zandvoort</strong> – zum WM-Halbfinale, zum Padel-Duell und vor allem für ein Wochenende voller gemeinsamer Erinnerungen.</p><!-- /wp:paragraph -->'
			. '<!-- wp:paragraph --><p>Bundes-Bernie hat lange überlegt, zahlreiche Videoanalysen ausgewertet und schließlich den Kader bekannt gegeben. Nominiert wurden:</p><!-- /wp:paragraph -->'
			. '<!-- wp:paragraph --><p><strong>15 Spieler</strong></p><!-- /wp:paragraph -->'
			. '<!-- wp:paragraph --><p>Sebastian Biederlack · Ulrich Bubolz · Philipp Crone · Sebastian Draguhn · Eike Duckwitz · Björn Emmerling · Moritz Fürste · Oliver Hentschel · Niklas Meinert · Jan-Marco Montag · Carlos Nevado · Christian Schulte · Tibor Weißenborn · Matthias Witthaus · Philipp Zeller</p><!-- /wp:paragraph -->'
			. '<!-- wp:paragraph --><p><strong>6 Staff-Mitglieder</strong></p><!-- /wp:paragraph -->'
			. '<!-- wp:paragraph --><p>Bernhard Peters · Torsten Althoff · Rainer Koll · Andreas Papenfuß · Gerhard Groß · Ulrich Forstner</p><!-- /wp:paragraph -->'
			. '<!-- wp:paragraph --><p>Damit steht sie: unsere <strong>Starting 21 für Amstelveen und Zandvoort</strong>.</p><!-- /wp:paragraph -->'
			. '<!-- wp:paragraph --><p>Leider können diesmal nicht alle dabei sein. Auf der Bank sitzen Justus Scharowsky, Timo Weß, Christopher Zeller, Bernd Schöpf, Mario Plesse, Andrew Meredith, Werner Wiedersich, Hans-Dieter Herrmann und Klaus Brosius. Ihr gehört genauso zu diesem Team und werdet an diesem Wochenende definitiv fehlen.</p><!-- /wp:paragraph -->'
			. '<!-- wp:paragraph --><p>Denn auch 20 Jahre später gilt: Ein Weltmeisterteam besteht nicht nur aus denen, die auf dem Platz stehen. Es lebt von allen, die den Weg gemeinsam gegangen sind.</p><!-- /wp:paragraph -->'
			. '<!-- wp:paragraph --><p><strong>Der Kader steht. Der Spielplan steht. Die Vorfreude steigt.</strong></p><!-- /wp:paragraph -->'
			. '<!-- wp:paragraph --><p>Noch sieben Tage bis zum Wiedersehen. 🇩🇪🏑🌊</p><!-- /wp:paragraph -->'
			. '<!-- wp:paragraph --><p>#HONAMAS20 #Reunion2026 #Weltmeister2006 #Starting21 #EinTeam</p><!-- /wp:paragraph -->'
			. '<!-- wp:image {"sizeSlug":"large","linkDestination":"none"} --><figure class="wp-block-image size-large"><img src="' . esc_url( get_theme_file_uri( 'assets/images/posts/starting-21.png' ) ) . '" alt="Nominierungsgrafik der Starting 21 für das HONAMAS Reunion-Wochenende 2026"/></figure><!-- /wp:image -->',
	);

	if ( $nomination_post instanceof WP_Post ) {
		$nomination_data['ID'] = $nomination_post->ID;
		wp_update_post( wp_slash( $nomination_data ) );
	} else {
		wp_insert_post( wp_slash( $nomination_data ) );
	}

	$playlist_page = get_page_by_path( 'playlist-2006', OBJECT, 'page' );
	$playlist_data = array(
		'post_title'     => 'Playlist 2006',
		'post_name'      => 'playlist-2006',
		'post_status'    => 'publish',
		'post_type'      => 'page',
		'comment_status' => 'closed',
		'ping_status'    => 'closed',
		'post_content'   => '<!-- wp:group {"align":"full","className":"playlist-hero","layout":{"type":"constrained"}} --><div class="wp-block-group alignfull playlist-hero">'
			. '<!-- wp:image {"align":"full","sizeSlug":"full","linkDestination":"none","className":"playlist-hero__image"} --><figure class="wp-block-image alignfull size-full playlist-hero__image"><img src="' . esc_url( get_theme_file_uri( 'assets/images/pages/playlist-2006-hero.jpeg' ) ) . '" alt="Collage aus Musik, Schlagzeug, Verstärker und HONAMAS-20-Logo"/></figure><!-- /wp:image -->'
			. '<!-- wp:group {"className":"playlist-hero__copy","layout":{"type":"constrained"}} --><div class="wp-block-group playlist-hero__copy"><!-- wp:paragraph {"className":"reunion-kicker"} --><p class="reunion-kicker">Team-Sound 2006</p><!-- /wp:paragraph --><!-- wp:heading {"level":1} --><h1>Playlist 2006</h1><!-- /wp:heading --><!-- wp:paragraph {"fontSize":"large"} --><p class="has-large-font-size">Drei Team-CDs, ein Turniersommer: Warm Up, Cool Down und Staff.</p><!-- /wp:paragraph --></div><!-- /wp:group -->'
			. '</div><!-- /wp:group -->'
			. '<!-- wp:group {"align":"wide","className":"playlist-intro","layout":{"type":"constrained","contentSize":"760px"}} --><div class="wp-block-group alignwide playlist-intro"><!-- wp:paragraph {"fontSize":"large"} --><p class="has-large-font-size">Wie zu jedem großen Turnier gab es auch zur WM 2006 eine CD mit je einem Wunschsong der Spieler und Trainer. Besonders an diesem Sommer: Es wurden gleich zwei Team-CDs zusammengestellt – eine <strong>Warm Up</strong> und eine <strong>Cool Down</strong>. Dazu kam eine eigene <strong>Staff CD</strong>, damit auch der Staff nicht vergessen wird.</p><!-- /wp:paragraph --></div><!-- /wp:group -->'
			. '<!-- wp:group {"align":"wide","className":"playlist-grid","layout":{"type":"constrained"}} --><div class="wp-block-group alignwide playlist-grid">'
			. '<!-- wp:html --><article class="playlist-card playlist-card--warm"><div class="playlist-card__head"><p>CD 01</p><h2>Warm Up</h2><span>Vor dem Spiel. Puls hoch.</span></div><iframe data-testid="embed-iframe" title="Spotify Playlist: HONAMAS 2006 Warm Up" src="https://open.spotify.com/embed/playlist/3SfxvJ01PKdsTZUg1twoFy?utm_source=generator&amp;theme=0&amp;si=dcf6ab94e9644569" width="100%" height="352" frameborder="0" allowfullscreen allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe></article><!-- /wp:html -->'
			. '<!-- wp:html --><article class="playlist-card playlist-card--cool"><div class="playlist-card__head"><p>CD 02</p><h2>Cool Down</h2><span>Nach dem Spiel. Runterkommen.</span></div><iframe data-testid="embed-iframe" title="Spotify Playlist: HONAMAS 2006 Cool Down" src="https://open.spotify.com/embed/playlist/0TFiu45hOhMlFN280kpYuV?utm_source=generator&amp;theme=0&amp;si=26e86179b1ca4c99" width="100%" height="352" frameborder="0" allowfullscreen allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe></article><!-- /wp:html -->'
			. '<!-- wp:html --><article class="playlist-card playlist-card--staff"><div class="playlist-card__head"><p>CD 03</p><h2>Staff</h2><span>Damit keiner vergessen wird.</span></div><iframe data-testid="embed-iframe" title="Spotify Playlist: HONAMAS 2006 Staff" src="https://open.spotify.com/embed/playlist/0gdmlcx0kdUpu6L7s9MsGn?utm_source=generator&amp;theme=0&amp;si=623016ff4839465c" width="100%" height="352" frameborder="0" allowfullscreen allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe></article><!-- /wp:html -->'
			. '</div><!-- /wp:group -->',
	);

	if ( $playlist_page instanceof WP_Post ) {
		$playlist_data['ID'] = $playlist_page->ID;
		wp_update_post( wp_slash( $playlist_data ) );
	} else {
		wp_insert_post( wp_slash( $playlist_data ) );
	}

	update_option( 'honamas20_reunion_seed_version', '2026-08-24-playlist-2006' );
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
