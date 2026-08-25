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
	wp_enqueue_script(
		'honamas20-reunion-menu',
		get_theme_file_uri( 'assets/js/reunion-menu.js' ),
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);
	wp_enqueue_script(
		'honamas20-reunion-playlist',
		get_theme_file_uri( 'assets/js/reunion-playlist.js' ),
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);
	wp_enqueue_script(
		'honamas20-reunion-song',
		get_theme_file_uri( 'assets/js/reunion-song.js' ),
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
 * Resolve the reunion song from the media library.
 */
function honamas20_reunion_get_song_audio_url(): string {
	$attachments = get_posts(
		array(
			'post_type'      => 'attachment',
			'post_status'    => 'inherit',
			'post_mime_type' => 'audio',
			'posts_per_page' => 50,
			'orderby'        => 'date',
			'order'          => 'DESC',
		)
	);

	foreach ( $attachments as $attachment ) {
		$url      = wp_get_attachment_url( $attachment->ID );
		$haystack = strtolower( $attachment->post_title . ' ' . $attachment->post_name . ' ' . ( $url ?: '' ) );

		if ( $url && ( str_contains( $haystack, 'einer-von-uns' ) || str_contains( $haystack, 'honamas-20_06' ) || str_contains( $haystack, 'honamas 20' ) ) ) {
			return $url;
		}
	}

	return '';
}

/**
 * Render the song player with the current media-library audio file.
 */
function honamas20_reunion_song_player_shortcode(): string {
	$song_audio_url = honamas20_reunion_get_song_audio_url();

	if ( ! $song_audio_url ) {
		return '<section class="song-player song-player--missing"><div class="song-player__meta"><p class="reunion-kicker">Einer von uns (HONAMAS 20|06)</p><h2>Der Song ist vorbereitet.</h2><p>Die Audiodatei wird eingeblendet, sobald sie in der Mediathek liegt.</p></div></section>';
	}

	return '<section class="song-player" data-song-player><div class="song-player__meta"><p class="reunion-kicker">Einer von uns (HONAMAS 20|06)</p><h2>Ein Lied für das geilste Team der Welt.</h2><p>Direkt abspielen oder für unterwegs herunterladen.</p></div><div class="song-player__controls"><audio data-song-audio preload="metadata" src="' . esc_url( $song_audio_url ) . '"></audio><button class="song-player__play" type="button" data-song-play><span data-song-play-label>Play</span></button><a class="song-player__download" href="' . esc_url( $song_audio_url ) . '" download>Download</a></div></section>';
}
add_shortcode( 'honamas20_song_player', 'honamas20_reunion_song_player_shortcode' );

/**
 * Seed required reunion content on fresh WordPress installs.
 */
function honamas20_reunion_seed_content(): void {
	if ( get_option( 'honamas20_reunion_seed_version' ) === '2026-08-25-song-page-media-audio-title' ) {
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
			. '<!-- wp:html --><article class="playlist-card playlist-card--warm"><div class="playlist-card__head"><p>CD 01</p><h2>Warm Up</h2><span>Vor dem Spiel. Puls hoch.</span></div><a class="playlist-card__spotify" href="https://open.spotify.com/playlist/3SfxvJ01PKdsTZUg1twoFy?si=dcf6ab94e9644569" target="_blank" rel="noopener"><span class="playlist-card__spotify-mark" aria-hidden="true">Spotify</span><strong>Warm Up auf Spotify hören</strong><small>Playlist öffnen</small></a></article><!-- /wp:html -->'
			. '<!-- wp:html --><article class="playlist-card playlist-card--cool"><div class="playlist-card__head"><p>CD 02</p><h2>Cool Down</h2><span>Nach dem Spiel. Runterkommen.</span></div><a class="playlist-card__spotify" href="https://open.spotify.com/playlist/0TFiu45hOhMlFN280kpYuV?si=26e86179b1ca4c99" target="_blank" rel="noopener"><span class="playlist-card__spotify-mark" aria-hidden="true">Spotify</span><strong>Cool Down auf Spotify hören</strong><small>Playlist öffnen</small></a></article><!-- /wp:html -->'
			. '<!-- wp:html --><article class="playlist-card playlist-card--staff"><div class="playlist-card__head"><p>CD 03</p><h2>Staff</h2><span>Damit keiner vergessen wird.</span></div><a class="playlist-card__spotify" href="https://open.spotify.com/playlist/0gdmlcx0kdUpu6L7s9MsGn?si=623016ff4839465c" target="_blank" rel="noopener"><span class="playlist-card__spotify-mark" aria-hidden="true">Spotify</span><strong>Staff auf Spotify hören</strong><small>Playlist öffnen</small></a></article><!-- /wp:html -->'
			. '</div><!-- /wp:group -->'
			. '<!-- wp:group {"align":"wide","className":"playlist-youtube","layout":{"type":"constrained"}} --><div class="wp-block-group alignwide playlist-youtube"><!-- wp:group {"className":"playlist-youtube__intro","layout":{"type":"constrained","contentSize":"780px"}} --><div class="wp-block-group playlist-youtube__intro"><!-- wp:paragraph {"className":"reunion-kicker"} --><p class="reunion-kicker">YouTube Tracks</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Die Songs einzeln hören.</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Oben führen die CD-Karten direkt zu den Spotify-Playlists. Hier findest du die einzelnen Tracks der drei CDs zusätzlich als YouTube-Links.</p><!-- /wp:paragraph --></div><!-- /wp:group --><!-- wp:html --><div data-playlist-youtube></div><!-- /wp:html --></div><!-- /wp:group -->',
	);

	if ( $playlist_page instanceof WP_Post ) {
		$playlist_data['ID'] = $playlist_page->ID;
		wp_update_post( wp_slash( $playlist_data ) );
	} else {
		wp_insert_post( wp_slash( $playlist_data ) );
	}

	$song_page = get_page_by_path( 'song', OBJECT, 'page' );
	$song_data = array(
		'post_title'     => 'Einer von uns',
		'post_name'      => 'song',
		'post_status'    => 'publish',
		'post_type'      => 'page',
		'comment_status' => 'closed',
		'ping_status'    => 'closed',
		'post_content'   => '<!-- wp:group {"align":"full","className":"song-hero","layout":{"type":"constrained"}} --><div class="wp-block-group alignfull song-hero">'
			. '<!-- wp:image {"align":"full","sizeSlug":"full","linkDestination":"none","className":"song-hero__image"} --><figure class="wp-block-image alignfull size-full song-hero__image"><img src="' . esc_url( get_theme_file_uri( 'assets/images/song/einer-von-uns-hero.png' ) ) . '" alt="Covermotiv zum Song Einer von uns mit HONAMAS-20-Logo und Vinylplatte"/></figure><!-- /wp:image -->'
			. '<!-- wp:group {"className":"song-hero__copy","layout":{"type":"constrained"}} --><div class="wp-block-group song-hero__copy"><!-- wp:paragraph {"className":"reunion-kicker"} --><p class="reunion-kicker">HONAMAS 20|06</p><!-- /wp:paragraph --><!-- wp:heading {"level":1} --><h1>Einer von uns</h1><!-- /wp:heading --><!-- wp:paragraph {"fontSize":"large"} --><p class="has-large-font-size">Der Song zum Reunion-Wochenende.</p><!-- /wp:paragraph --></div><!-- /wp:group -->'
			. '</div><!-- /wp:group -->'
			. '<!-- wp:group {"align":"wide","className":"song-player-section","layout":{"type":"constrained"}} --><div class="wp-block-group alignwide song-player-section">'
			. '<!-- wp:shortcode -->[honamas20_song_player]<!-- /wp:shortcode -->'
			. '</div><!-- /wp:group -->'
			. '<!-- wp:group {"align":"wide","className":"song-lyrics","layout":{"type":"constrained","contentSize":"880px"}} --><div class="wp-block-group alignwide song-lyrics">'
			. '<!-- wp:paragraph {"className":"reunion-kicker"} --><p class="reunion-kicker">Lyrics</p><!-- /wp:paragraph -->'
			. '<!-- wp:heading --><h2>Einer von uns</h2><!-- /wp:heading -->'
			. '<!-- wp:html --><div class="song-lyrics__grid">'
			. '<section><p>Verse 1</p><div>Freitagabend, Amstelveen, wir steh’n wieder hier<br>Zwanzig Jahre später, beim dritten kalten Bier<br>Bubi hält die Bälle, wie im Siebenmeter-Krimi<br>Christian hält uns zusammen – unsere Seele, unser Schüti<br>Der General steht sicher, Jambo gibt den Ton<br>Zello dreht auf, Wesa kennt die Position<br>Und Hupe räumt ab, damit hinten nichts passiert<br>Damals wie heute – jeder für den andern alles riskiert!</div></section>'
			. '<section><p>Pre-Chorus</p><div>Wir war’n die Adler, die niemand kommen sah<br>Wir schrieben uns die Regeln selbst – und dann war’n wir da!</div></section>'
			. '<section><p>Chorus</p><div>HONAMAS – Wir sind dieses Team!<br>Achtzehn Freunde mit derselben DNA im Gen<br>Zwanzig Jahre her, dass wir die Welt bewegt<br>Ein Gefühl, das niemals, niemals mehr vergeht<br>Vom ersten Logo bis zum Titel in der Hand<br>Wir sind HONAMAS – die Besten im Land!</div></section>'
			. '<section><p>Verse 2</p><div>Emmel baut auf, als Herz im Mittelfeld<br>Buddy wird laut, so wie es uns gefällt<br>Tibs ist am Start, Meini lenkt den Lauf<br>Scharo bleibt cool und setzt noch einen drauf<br>Dragon grinst rüber, bereit für den Schlag<br>Carlito tanzt rein, weil er die Lücke mag<br>Witti hat den Blick, liest jedes Detail<br>Und Zells trifft die Kiste – und wir feiern: „Wie geil!“</div></section>'
			. '<section><p>Pre-Chorus</p><div>Kein Plan mehr nötig, kein Taktik-Papier<br>Einer ruft „Jetzt!“ – und wir wissen: Wir sind hier!</div></section>'
			. '<section><p>Chorus</p><div>HONAMAS – Wir sind dieses Team!<br>Achtzehn Freunde mit derselben DNA im Gen<br>Zwanzig Jahre her, dass wir die Welt bewegt<br>Ein Gefühl, das niemals, niemals mehr vergeht<br>Vom ersten Logo bis zum Titel in der Hand<br>Wir sind HONAMAS – die Besten im Land!</div></section>'
			. '<section><p>Bridge</p><div>Und hinten die Köpfe, die das alles gebaut<br>Bernie hat uns damals voll vertraut<br>Totte daneben, immer nah dran<br>Der wusste genau, was jeder hier kann<br>Reiner der Doc, hat uns wieder hingestellt<br>Wenn’s wehtat im Kopf oder dem Rest der Welt<br>Mario und Paape, die Hände aus Gold<br>Haben alles geflickt, was nicht mehr rollt<br>Gigi sah alles, noch bevor du was sagst<br>Wo es zwickt, wo es klemmt, was dich heute noch plagt<br>Und hinten steht Bernd, ganz ruhig, ist doch klar<br>Er hat uns erfunden – und war einfach da!</div></section>'
			. '<section><p>Final Chorus</p><div>HONAMAS – Wir bleiben dieses Team!<br>Achtzehn Freunde mit derselben DNA im Gen<br>Zwanzig Jahre her, dass wir die Welt bewegt<br>Ein Gefühl, das niemals, niemals mehr vergeht<br>Von der ersten Idee bis zum WM-Pokal<br>Wir sind HONAMAS – einmal und für alle Mal!</div></section>'
			. '<section><p>Outro</p><div>Und wenn einer fragt, was am Ende noch zählt:<br>Es war unser Spirit, der die Welt heute noch quält<br>Egal, wohin jeder Einzelne geht<br>Wir sind die HONAMAS – das Team, das niemals vergeht!</div></section>'
			. '</div><!-- /wp:html -->'
			. '</div><!-- /wp:group -->',
	);

	if ( $song_page instanceof WP_Post ) {
		$song_data['ID'] = $song_page->ID;
		wp_update_post( wp_slash( $song_data ) );
	} else {
		wp_insert_post( wp_slash( $song_data ) );
	}

	update_option( 'honamas20_reunion_seed_version', '2026-08-25-song-page-media-audio-title' );
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
