<?php
/**
 * Plugin Name: HONAMAS Core
 * Description: Structured content for the HONAMAS archive and the Ur-HONAMAS team.
 * Version: 0.1.6
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
			'supports' => array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes' ),
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

/**
 * Add the editorial fields needed for each archive object.
 */
function honamas_core_add_archive_meta_box(): void {
	add_meta_box(
		'honamas-archive-details',
		__( 'Archivmetadaten', 'honamas-core' ),
		'honamas_core_render_archive_meta_box',
		'honamas_archive_item',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes_honamas_archive_item', 'honamas_core_add_archive_meta_box' );

function honamas_core_render_archive_meta_box( WP_Post $post ): void {
	wp_nonce_field( 'honamas_archive_details', 'honamas_archive_details_nonce' );
	$values = array();
	foreach ( array( 'asset_date', 'origin', 'credit', 'rights_note', 'source_url', 'file_id' ) as $field ) {
		$values[ $field ] = get_post_meta( $post->ID, 'honamas_' . $field, true );
	}
	?>
	<p><label for="honamas_asset_date"><strong><?php esc_html_e( 'Datum', 'honamas-core' ); ?></strong></label><br><input class="widefat" id="honamas_asset_date" name="honamas_asset_date" type="text" value="<?php echo esc_attr( $values['asset_date'] ); ?>" placeholder="17. September 2006"></p>
	<p><label for="honamas_origin"><strong><?php esc_html_e( 'Herkunft', 'honamas-core' ); ?></strong></label><br><input class="widefat" id="honamas_origin" name="honamas_origin" type="text" value="<?php echo esc_attr( $values['origin'] ); ?>" placeholder="Privatarchiv / Redaktion / Verband"></p>
	<p><label for="honamas_credit"><strong><?php esc_html_e( 'Fotograf oder Credit', 'honamas-core' ); ?></strong></label><br><input class="widefat" id="honamas_credit" name="honamas_credit" type="text" value="<?php echo esc_attr( $values['credit'] ); ?>"></p>
	<p><label for="honamas_rights_note"><strong><?php esc_html_e( 'Rechtehinweis', 'honamas-core' ); ?></strong></label><br><input class="widefat" id="honamas_rights_note" name="honamas_rights_note" type="text" value="<?php echo esc_attr( $values['rights_note'] ); ?>"></p>
	<p><label for="honamas_source_url"><strong><?php esc_html_e( 'Externer Quelllink', 'honamas-core' ); ?></strong></label><br><input class="widefat" id="honamas_source_url" name="honamas_source_url" type="url" value="<?php echo esc_attr( $values['source_url'] ); ?>"></p>
	<p><label for="honamas_file_id"><strong><?php esc_html_e( 'Mediathek-ID für Originaldatei', 'honamas-core' ); ?></strong></label><br><input class="small-text" id="honamas_file_id" min="0" name="honamas_file_id" type="number" value="<?php echo esc_attr( $values['file_id'] ); ?>"></p>
	<p><label for="honamas_related_chapter"><strong><?php esc_html_e( 'Zugehöriges Kapitel', 'honamas-core' ); ?></strong></label><br><?php wp_dropdown_pages( array( 'name' => 'honamas_related_chapter', 'id' => 'honamas_related_chapter', 'show_option_none' => __( 'Kein Kapitel zugeordnet', 'honamas-core' ), 'option_none_value' => '0', 'selected' => (int) get_post_meta( $post->ID, 'honamas_related_chapter', true ) ) ); ?></p>
	<?php
}

function honamas_core_save_archive_meta( int $post_id ): void {
	if ( ! isset( $_POST['honamas_archive_details_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['honamas_archive_details_nonce'] ) ), 'honamas_archive_details' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	foreach ( array( 'asset_date', 'origin', 'credit', 'rights_note', 'source_url', 'file_id', 'related_chapter' ) as $field ) {
		if ( ! isset( $_POST[ 'honamas_' . $field ] ) ) {
			continue;
		}
		$value = wp_unslash( $_POST[ 'honamas_' . $field ] );
		$value = in_array( $field, array( 'file_id', 'related_chapter' ), true ) ? absint( $value ) : ( 'source_url' === $field ? esc_url_raw( $value ) : sanitize_text_field( $value ) );
		if ( '' === $value || 0 === $value ) {
			delete_post_meta( $post_id, 'honamas_' . $field );
		} else {
			update_post_meta( $post_id, 'honamas_' . $field, $value );
		}
	}
}
add_action( 'save_post_honamas_archive_item', 'honamas_core_save_archive_meta' );

/**
 * Add the editorial fields needed for each team motif.
 */
function honamas_core_add_team_meta_box(): void {
	add_meta_box(
		'honamas-team-details',
		__( 'Teamdaten', 'honamas-core' ),
		'honamas_core_render_team_meta_box',
		'honamas_team_member',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes_honamas_team_member', 'honamas_core_add_team_meta_box' );

function honamas_core_render_team_meta_box( WP_Post $post ): void {
	wp_nonce_field( 'honamas_team_details', 'honamas_team_details_nonce' );
	$nickname      = get_post_meta( $post->ID, 'honamas_nickname', true );
	$jersey_number = get_post_meta( $post->ID, 'honamas_jersey_number', true );
	?>
	<p><label for="honamas_nickname"><strong><?php esc_html_e( 'Spitzname', 'honamas-core' ); ?></strong></label><br><input class="widefat" id="honamas_nickname" name="honamas_nickname" type="text" value="<?php echo esc_attr( $nickname ); ?>" placeholder="Emmel"></p>
	<p><label for="honamas_jersey_number"><strong><?php esc_html_e( 'Rückennummer 2006', 'honamas-core' ); ?></strong></label><br><input class="small-text" id="honamas_jersey_number" min="0" name="honamas_jersey_number" type="number" value="<?php echo esc_attr( $jersey_number ); ?>" placeholder="7"></p>
	<p class="description"><?php esc_html_e( 'Für die öffentliche Teamseite reichen Name, Spitzname, Motiv und optional die Rückennummer. Weitere biografische Angaben sollten nur ergänzt werden, wenn sie redaktionell wirklich gebraucht werden.', 'honamas-core' ); ?></p>
	<?php
}

function honamas_core_save_team_meta( int $post_id ): void {
	if ( ! isset( $_POST['honamas_team_details_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['honamas_team_details_nonce'] ) ), 'honamas_team_details' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$fields = array(
		'nickname'      => 'sanitize_text_field',
		'jersey_number' => 'absint',
	);

	foreach ( $fields as $field => $sanitize_callback ) {
		if ( ! isset( $_POST[ 'honamas_' . $field ] ) ) {
			continue;
		}
		$value = wp_unslash( $_POST[ 'honamas_' . $field ] );
		$value = 'absint' === $sanitize_callback ? absint( $value ) : sanitize_text_field( $value );
		if ( '' === $value || 0 === $value ) {
			delete_post_meta( $post_id, 'honamas_' . $field );
		} else {
			update_post_meta( $post_id, 'honamas_' . $field, $value );
		}
	}
}
add_action( 'save_post_honamas_team_member', 'honamas_core_save_team_meta' );

/**
 * Render the filterable archive collection without binding the editorial
 * content model to a third-party block or plugin.
 */
function honamas_core_render_archive_collection(): string {
	$current_category = isset( $_GET['archiv-kategorie'] ) ? sanitize_key( wp_unslash( $_GET['archiv-kategorie'] ) ) : '';
	$categories       = get_terms( array( 'taxonomy' => 'honamas_archive_category', 'hide_empty' => false ) );
	$archive_url      = get_post_type_archive_link( 'honamas_archive_item' );
	$query_args       = array( 'post_type' => 'honamas_archive_item', 'posts_per_page' => 24 );

	if ( $current_category && term_exists( $current_category, 'honamas_archive_category' ) ) {
		$query_args['tax_query'] = array( array( 'taxonomy' => 'honamas_archive_category', 'field' => 'slug', 'terms' => $current_category ) );
	} else {
		$current_category = '';
	}

	$items = new WP_Query( $query_args );
	ob_start();
	?>
	<nav aria-label="<?php esc_attr_e( 'Archiv filtern', 'honamas-core' ); ?>" class="honamas-archive-filter">
		<a class="<?php echo $current_category ? '' : 'is-active'; ?>" href="<?php echo esc_url( $archive_url ); ?>"><?php esc_html_e( 'Alle', 'honamas-core' ); ?></a>
		<?php foreach ( $categories as $category ) : ?>
			<a class="<?php echo $current_category === $category->slug ? 'is-active' : ''; ?>" href="<?php echo esc_url( add_query_arg( 'archiv-kategorie', $category->slug, $archive_url ) ); ?>"><?php echo esc_html( $category->name ); ?></a>
		<?php endforeach; ?>
	</nav>
	<?php if ( $items->have_posts() ) : ?>
		<div class="honamas-archive-grid">
			<?php while ( $items->have_posts() ) : $items->the_post(); ?>
				<?php
				$item_id    = get_the_ID();
				$asset_date = get_post_meta( $item_id, 'honamas_asset_date', true );
				$origin     = get_post_meta( $item_id, 'honamas_origin', true );
				$item_terms = get_the_terms( $item_id, 'honamas_archive_category' );
				$category   = $item_terms && ! is_wp_error( $item_terms ) ? $item_terms[0]->name : '';
				$excerpt    = get_the_excerpt();
				if ( ! $excerpt ) {
					$excerpt = wp_trim_words( wp_strip_all_tags( get_the_content() ), 24 );
				}
				?>
				<article class="honamas-archive-card">
					<a aria-label="<?php echo esc_attr( get_the_title() ); ?>" class="honamas-archive-card__image" href="<?php the_permalink(); ?>">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( 'large', array( 'loading' => 'lazy' ) ); ?>
						<?php else : ?>
							<span><?php esc_html_e( 'Archiv', 'honamas-core' ); ?></span>
						<?php endif; ?>
					</a>
					<div class="honamas-archive-card__content">
						<p class="honamas-meta"><?php echo esc_html( trim( implode( ' · ', array_filter( array( $category, $asset_date ) ) ) ) ); ?></p>
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<?php if ( $excerpt ) : ?><p><?php echo esc_html( $excerpt ); ?></p><?php endif; ?>
						<?php if ( $origin ) : ?><p class="honamas-archive-card__origin"><?php echo esc_html( $origin ); ?></p><?php endif; ?>
					</div>
				</article>
			<?php endwhile; ?>
		</div>
	<?php else : ?>
		<section class="honamas-archive-empty">
			<p class="honamas-meta"><?php esc_html_e( 'Im Aufbau', 'honamas-core' ); ?></p>
			<h2><?php esc_html_e( 'Die ersten Originale folgen.', 'honamas-core' ); ?></h2>
			<p><?php esc_html_e( 'Das Archiv wird fortlaufend mit ausgewählten Dokumenten, Fotos, Kleidung und Pressebelegen ergänzt.', 'honamas-core' ); ?></p>
		</section>
	<?php endif; ?>
	<?php
	wp_reset_postdata();
	return (string) ob_get_clean();
}
add_shortcode( 'honamas_archive_collection', 'honamas_core_render_archive_collection' );

function honamas_core_render_archive_metadata(): string {
	$post_id = get_the_ID();
	$fields  = array(
		'asset_date'  => __( 'Datum', 'honamas-core' ),
		'origin'      => __( 'Herkunft', 'honamas-core' ),
		'credit'      => __( 'Credit', 'honamas-core' ),
		'rights_note' => __( 'Rechte', 'honamas-core' ),
	);
	$metadata = array();
	foreach ( $fields as $field => $label ) {
		$value = get_post_meta( $post_id, 'honamas_' . $field, true );
		if ( $value ) {
			$metadata[ $label ] = $value;
		}
	}
	$source_url = get_post_meta( $post_id, 'honamas_source_url', true );
	$file_id    = (int) get_post_meta( $post_id, 'honamas_file_id', true );

	if ( ! $metadata && ! $source_url && ! $file_id ) {
		return '';
	}

	ob_start();
	?>
	<aside class="honamas-archive-metadata">
		<h2><?php esc_html_e( 'Objektdaten', 'honamas-core' ); ?></h2>
		<?php if ( $metadata ) : ?><dl><?php foreach ( $metadata as $label => $value ) : ?><div><dt><?php echo esc_html( $label ); ?></dt><dd><?php echo esc_html( $value ); ?></dd></div><?php endforeach; ?></dl><?php endif; ?>
		<?php if ( $source_url ) : ?><p><a href="<?php echo esc_url( $source_url ); ?>" rel="noopener" target="_blank"><?php esc_html_e( 'Externe Quelle öffnen', 'honamas-core' ); ?></a></p><?php endif; ?>
		<?php if ( $file_id && wp_get_attachment_url( $file_id ) ) : ?><p><a href="<?php echo esc_url( wp_get_attachment_url( $file_id ) ); ?>"><?php esc_html_e( 'Originaldatei öffnen', 'honamas-core' ); ?></a></p><?php endif; ?>
	</aside>
	<?php
	return (string) ob_get_clean();
}
add_shortcode( 'honamas_archive_metadata', 'honamas_core_render_archive_metadata' );

function honamas_core_render_archive_navigation(): string {
	$archive_url = get_post_type_archive_link( 'honamas_archive_item' );
	$previous    = get_previous_post();
	$next        = get_next_post();

	ob_start();
	?>
	<nav aria-label="<?php esc_attr_e( 'Archivnavigation', 'honamas-core' ); ?>" class="honamas-archive-navigation">
		<?php if ( $previous ) : ?><a href="<?php echo esc_url( get_permalink( $previous ) ); ?>"><?php esc_html_e( '← Vorheriges Objekt', 'honamas-core' ); ?></a><?php endif; ?>
		<a class="honamas-archive-navigation__overview" href="<?php echo esc_url( $archive_url ); ?>"><?php esc_html_e( 'Zum Archiv', 'honamas-core' ); ?></a>
		<?php if ( $next ) : ?><a class="honamas-archive-navigation__next" href="<?php echo esc_url( get_permalink( $next ) ); ?>"><?php esc_html_e( 'Nächstes Objekt →', 'honamas-core' ); ?></a><?php endif; ?>
	</nav>
	<?php
	return (string) ob_get_clean();
}
add_shortcode( 'honamas_archive_navigation', 'honamas_core_render_archive_navigation' );

/**
 * Render the team photograph selected on the Ur-HONAMAS page.
 *
 * Keeping the image on the page itself makes the start-page teaser
 * editorially manageable without introducing another settings screen.
 */
function honamas_core_render_team_start_image(): string {
	$team_page = get_page_by_path( 'die-ur-honamas' );
	$image_id  = $team_page ? get_post_thumbnail_id( $team_page ) : 0;

	if ( ! $image_id ) {
		return '<div class="honamas-team-start__placeholder" aria-hidden="true"></div>';
	}

	$alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
	if ( '' === $alt ) {
		$alt = __( 'Mannschaftsfoto der Ur-HONAMAS von 2006.', 'honamas-core' );
	}

	return sprintf(
		'<figure class="honamas-team-start__image">%s</figure>',
		wp_get_attachment_image(
			$image_id,
			'full',
			false,
			array(
				'alt'      => $alt,
				'loading'  => 'lazy',
				'decoding' => 'async',
			)
		)
	);
}
add_shortcode( 'honamas_team_start_image', 'honamas_core_render_team_start_image' );

function honamas_core_render_team_collection(): string {
	$members = new WP_Query(
		array(
			'post_type'      => 'honamas_team_member',
			'posts_per_page' => 50,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'title'      => 'ASC',
			),
			'order'          => 'ASC',
		)
	);

	if ( ! $members->have_posts() ) {
		return '<p>' . esc_html__( 'Die Team-Motive werden vorbereitet.', 'honamas-core' ) . '</p>';
	}

	ob_start();
	?>
	<section aria-label="<?php esc_attr_e( 'Teammitglieder der Ur-HONAMAS', 'honamas-core' ); ?>" class="honamas-team-collection">
		<?php while ( $members->have_posts() ) : $members->the_post(); ?>
			<?php
			$member_id     = get_the_ID();
			$nickname      = get_post_meta( $member_id, 'honamas_nickname', true );
			$jersey_number = (int) get_post_meta( $member_id, 'honamas_jersey_number', true );
			$initials      = honamas_core_get_initials( get_the_title() );
			?>
			<article class="honamas-team-card">
				<figure class="honamas-team-card__media">
					<?php if ( has_post_thumbnail() ) : ?>
						<?php
						echo wp_get_attachment_image(
							get_post_thumbnail_id( $member_id ),
							'large',
							false,
							array(
								'alt'     => sprintf(
									/* translators: %s: team member name. */
									__( 'Motiv von %s.', 'honamas-core' ),
									get_the_title()
								),
								'loading' => 'lazy',
							)
						);
						?>
					<?php else : ?>
						<span aria-hidden="true"><?php echo esc_html( $initials ); ?></span>
					<?php endif; ?>
				</figure>
				<div class="honamas-team-card__body">
					<?php if ( $jersey_number ) : ?><p class="honamas-team-card__number"><?php echo esc_html( '#' . $jersey_number ); ?></p><?php endif; ?>
					<h2><?php the_title(); ?></h2>
					<?php if ( $nickname ) : ?><p><?php echo esc_html( $nickname ); ?></p><?php endif; ?>
				</div>
			</article>
		<?php endwhile; ?>
	</section>
	<?php
	wp_reset_postdata();
	return (string) ob_get_clean();
}
add_shortcode( 'honamas_team_collection', 'honamas_core_render_team_collection' );

function honamas_core_get_initials( string $name ): string {
	$parts    = preg_split( '/\s+/', trim( $name ) );
	$initials = '';
	foreach ( $parts as $part ) {
		if ( '' !== $part ) {
			$initials .= substr( $part, 0, 1 );
		}
	}
	return strtoupper( substr( $initials, 0, 2 ) );
}

function honamas_core_get_roster(): array {
	return array(
		array( 'name' => 'Ulrich Bubolz', 'nickname' => 'Bubi', 'keywords' => array( 'Bubi' ) ),
		array( 'name' => 'Sebastian Biederlack', 'nickname' => 'Buddy', 'keywords' => array( 'Buddy' ) ),
		array( 'name' => 'Carlos Nevado', 'nickname' => 'Carlito', 'keywords' => array( 'Carlos', 'Carlito' ) ),
		array( 'name' => 'Sebastian Draghun', 'nickname' => 'Dragon', 'keywords' => array( 'Dragon' ) ),
		array( 'name' => 'Björn Emmerling', 'nickname' => 'Emmel', 'keywords' => array( 'Emmel' ) ),
		array( 'name' => 'Tim Jessulat', 'nickname' => 'Enti', 'keywords' => array( 'Enti' ) ),
		array( 'name' => 'Eike Duckwitz', 'nickname' => 'General', 'keywords' => array( 'General' ) ),
		array( 'name' => 'Philipp Crone', 'nickname' => 'Hupe', 'keywords' => array( 'Hupe' ) ),
		array( 'name' => 'Jan-Marco Montag', 'nickname' => 'Jambo', 'keywords' => array( 'Jambo' ) ),
		array( 'name' => 'Niklas Meinert', 'nickname' => 'Meini', 'keywords' => array( 'Meini' ) ),
		array( 'name' => 'Moritz Fürste', 'nickname' => 'Mo', 'keywords' => array( 'Mo' ) ),
		array( 'name' => 'Nicolás Emmerling', 'nickname' => 'Nici', 'keywords' => array( 'Nici' ) ),
		array( 'name' => 'Philipp Witte', 'nickname' => 'Piwi', 'keywords' => array( 'Piwi' ) ),
		array( 'name' => 'Justus Scharowski', 'nickname' => 'Scharo', 'keywords' => array( 'Scharo' ) ),
		array( 'name' => 'Christian Schulte', 'nickname' => 'Schüti', 'keywords' => array( 'Schueti', 'Schüti' ) ),
		array( 'name' => 'Tibor Weißenborn', 'nickname' => 'Tibs', 'keywords' => array( 'Tibs' ) ),
		array( 'name' => 'Oliver Hentschel', 'nickname' => 'Ulln', 'keywords' => array( 'Ulln' ) ),
		array( 'name' => 'Timo Wess', 'nickname' => 'Wesa', 'keywords' => array( 'Wesa' ) ),
		array( 'name' => 'Matthias Witthaus', 'nickname' => 'Witti', 'keywords' => array( 'Witti' ) ),
		array( 'name' => 'Philipp Zeller', 'nickname' => 'Zello', 'keywords' => array( 'Zello' ) ),
		array( 'name' => 'Christopher Zeller', 'nickname' => 'Zells', 'keywords' => array( 'Zells' ) ),
	);
}

function honamas_core_seed_team_members(): void {
	if ( '1' === get_option( 'honamas_core_team_seeded' ) ) {
		return;
	}

	$index = 0;
	foreach ( honamas_core_get_roster() as $member ) {
		$slug    = sanitize_title( $member['name'] );
		$posts   = get_posts(
			array(
				'name'           => $slug,
				'post_type'      => 'honamas_team_member',
				'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
				'posts_per_page' => 1,
			)
		);
		$post_id = $posts ? (int) $posts[0]->ID : 0;

		if ( ! $post_id ) {
			$post_id = wp_insert_post(
				array(
					'post_type'    => 'honamas_team_member',
					'post_status'  => 'publish',
					'post_title'   => $member['name'],
					'post_name'    => $slug,
					'post_content' => '',
					'menu_order'   => $index,
				),
				true
			);
			if ( is_wp_error( $post_id ) ) {
				continue;
			}
		} else {
			wp_update_post(
				array(
					'ID'         => $post_id,
					'menu_order' => $index,
				)
			);
		}

		if ( ! get_post_meta( $post_id, 'honamas_nickname', true ) ) {
			update_post_meta( $post_id, 'honamas_nickname', $member['nickname'] );
		}

		if ( ! get_post_thumbnail_id( $post_id ) ) {
			$portrait_id = honamas_core_find_team_portrait_id( $member['keywords'] );
			if ( $portrait_id ) {
				set_post_thumbnail( $post_id, $portrait_id );
			}
		}

		$index++;
	}

	update_option( 'honamas_core_team_seeded', '1', false );
}
add_action( 'admin_init', 'honamas_core_seed_team_members' );

function honamas_core_find_team_portrait_id( array $keywords ): int {
	return honamas_core_find_attachment_id( $keywords, 'image' );
}

function honamas_core_find_attachment_id( array $keywords, string $mime_type = '' ): int {
	$args = array(
		'post_type'      => 'attachment',
		'post_status'    => 'inherit',
		'posts_per_page' => 700,
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	if ( '' !== $mime_type ) {
		$args['post_mime_type'] = $mime_type;
	}

	$attachments = get_posts( $args );

	foreach ( $attachments as $attachment ) {
		$metadata = wp_get_attachment_metadata( $attachment->ID );
		$filename = isset( $metadata['file'] ) ? wp_basename( $metadata['file'] ) : '';
		$haystack = honamas_core_normalize_lookup_text( $attachment->post_title . ' ' . $attachment->post_name . ' ' . $filename );

		foreach ( $keywords as $keyword ) {
			$needle = honamas_core_normalize_lookup_text( $keyword );
			if ( '' === $needle ) {
				continue;
			}
			if ( strlen( $needle ) <= 2 ) {
				if ( preg_match( '/(^|[^a-z0-9])' . preg_quote( $needle, '/' ) . '([^a-z0-9]|$)/', $haystack ) ) {
					return (int) $attachment->ID;
				}
				continue;
			}
			if ( str_contains( $haystack, $needle ) ) {
				return (int) $attachment->ID;
			}
		}
	}

	return 0;
}

function honamas_core_normalize_lookup_text( string $text ): string {
	$text = strtolower( remove_accents( $text ) );
	return preg_replace( '/[^a-z0-9]+/', ' ', $text ) ?: '';
}

function honamas_core_get_initial_archive_items(): array {
	return array(
		array(
			'title'    => 'Team-Identity-Originaldokument 2006',
			'slug'     => 'team-identity-originaldokument-2006',
			'category' => 'dokumente',
			'date'     => '2006',
			'origin'   => 'Team HONAMAS / Projektarchiv',
			'excerpt'  => 'Das Originaldokument zur Team Identity von 2006 als zentraler Beleg für Sprache, Werte und Selbstverständnis der Ur-HONAMAS.',
			'content'  => '<p>Dieses Archivobjekt ist als Belegstelle für die Team Identity der HONAMAS angelegt. Es soll das Originaldokument von 2006 aufnehmen und die Entwicklung von Name, Logo, gemeinsamen Werten und sportlichem Selbstverständnis nachvollziehbar machen.</p><p><strong>Noch zu ergänzen:</strong> Originaldatei, Seitenzahl, Herkunft, Rechtehinweis, sichtbarer Credit und gegebenenfalls eine lesbare Vorschau.</p>',
		),
		array(
			'title'    => 'Erstes HONAMAS-Trainingsteil',
			'slug'     => 'erstes-honamas-trainingsteil',
			'category' => 'kleidung',
			'date'     => '2006',
			'origin'   => 'Team HONAMAS / Projektarchiv',
			'excerpt'  => 'Frühe Trainingskleidung mit HONAMAS-Logo aus dem Umfeld der Heim-WM 2006.',
			'content'  => '<p>Dieses Archivobjekt sammelt die frühen Kleidungsstücke, auf denen der Name HONAMAS vor und während der Heim-WM 2006 sichtbar wurde.</p><p><strong>Noch zu ergänzen:</strong> konkretes Kleidungsstück, Bildauswahl, Zeitraum, Herkunft, Rechtehinweis und Credit.</p>',
		),
		array(
			'title'    => '1.500 HONAMAS-Shirts vor der WM 2006',
			'slug'     => '1500-honamas-shirts-vor-der-wm-2006',
			'category' => 'kleidung',
			'date'     => '2006',
			'origin'   => 'Team HONAMAS / Projektarchiv',
			'excerpt'  => 'Vier Tage vor WM-Beginn wurden 1.500 HONAMAS-Shirts produziert und der Name damit sichtbar in die Arena getragen.',
			'content'  => '<p>Vier Tage vor Beginn der Heim-WM 2006 wurden 1.500 HONAMAS-Shirts produziert. Dieses Archivobjekt belegt den Moment, in dem der Name nicht mehr nur intern existierte, sondern sichtbar nach außen getragen wurde.</p><p><strong>Noch zu ergänzen:</strong> Foto oder Dokument, genaue Datierung, Herkunft, Rechtehinweis und Credit.</p>',
		),
		array(
			'title'    => 'Mannschaftsfoto der Ur-HONAMAS 2006',
			'slug'     => 'mannschaftsfoto-der-ur-honamas-2006',
			'category' => 'fotos',
			'date'     => '2006',
			'origin'   => 'Team HONAMAS / Projektarchiv',
			'excerpt'  => 'Das Mannschaftsfoto des WM-Teams von 2006 als zentrales Bilddokument der Ur-HONAMAS.',
			'content'  => '<p>Das Mannschaftsfoto ist das zentrale Bilddokument der Ur-HONAMAS. Es gehört als eigener Archivbeleg zur Teamseite und zur Geschichte des Namens.</p><p><strong>Noch zu ergänzen:</strong> Ort, Datum, Personen, Fotograf, Rechtehinweis, Credit und finale Bildunterschrift.</p>',
		),
		array(
			'title'    => 'Reece-Trikotdesign 2017',
			'slug'     => 'reece-trikotdesign-2017',
			'category' => 'dokumente',
			'date'     => '2017',
			'origin'   => 'Reece Australia / Projektarchiv',
			'excerpt'  => 'Entwürfe beziehungsweise Ansichten des ersten offiziellen HONAMAS-Trikots von 2017.',
			'content'  => '<p>Als Vertriebsleiter des DHB-Ausrüsters Reece Australia gehörte Jan-Marco Montag zu den Designern des ersten richtigen HONAMAS-Trikots. Dieses Archivobjekt hält die Entwürfe beziehungsweise Ansichten aus dem Jahr 2017 fest.</p><p><strong>Noch zu ergänzen:</strong> konkrete Bildauswahl, Designrechte, Herkunft, Rechtehinweis und Credit.</p>',
		),
		array(
			'title'    => 'Markenanmeldung 2010 und DHB-Eintragung 2021',
			'slug'     => 'markenanmeldung-2010-dhb-eintragung-2021',
			'category' => 'dokumente',
			'date'     => '2010 / 2021',
			'origin'   => 'Projektarchiv',
			'excerpt'  => 'Dokumente zur Sicherung der Marke HONAMAS 2010 und zur offiziellen Eintragung beim DHB 2021.',
			'content'  => '<p>Dieses Archivobjekt bündelt die Unterlagen zur Markensicherung: die persönliche Anmeldung durch Björn Emmerling am 30. März 2010 und die offizielle Eintragung beim DHB am 16. Juni 2021.</p><p><strong>Noch zu ergänzen:</strong> finale Dokumentenauswahl, Datenschutzprüfung, Rechtehinweis, Herkunft und Credit.</p>',
		),
	);
}

function honamas_core_seed_initial_archive_items(): void {
	if ( '1' === get_option( 'honamas_core_initial_archive_seeded' ) ) {
		return;
	}

	honamas_core_ensure_archive_categories();

	foreach ( honamas_core_get_initial_archive_items() as $item ) {
		$existing = get_posts(
			array(
				'name'           => $item['slug'],
				'post_type'      => 'honamas_archive_item',
				'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
				'posts_per_page' => 1,
			)
		);

		if ( $existing ) {
			continue;
		}

		$post_id = wp_insert_post(
			array(
				'post_type'    => 'honamas_archive_item',
				'post_status'  => 'publish',
				'post_title'   => $item['title'],
				'post_name'    => $item['slug'],
				'post_excerpt' => $item['excerpt'],
				'post_content' => $item['content'],
			),
			true
		);

		if ( is_wp_error( $post_id ) ) {
			continue;
		}

		$term = term_exists( $item['category'], 'honamas_archive_category' );
		if ( $term ) {
			wp_set_object_terms( $post_id, (int) $term['term_id'], 'honamas_archive_category' );
		}

		update_post_meta( $post_id, 'honamas_asset_date', $item['date'] );
		update_post_meta( $post_id, 'honamas_origin', $item['origin'] );
	}

	update_option( 'honamas_core_initial_archive_seeded', '1', false );
}
add_action( 'admin_init', 'honamas_core_seed_initial_archive_items' );

function honamas_core_assign_initial_archive_assets(): void {
	if ( '2026-08-15-1' === get_option( 'honamas_core_initial_archive_assets_assigned' ) ) {
		return;
	}

	$assignments = array(
		'team-identity-originaldokument-2006' => array(
			'image' => array( '253 TEAM IDENTITY 1', '253-team-identity-1' ),
			'file'  => array( '257 2006 07 13 Honamas Team Identity', 'Honamas Team Identity pdf' ),
		),
		'erstes-honamas-trainingsteil'        => array(
			'clear_image' => true,
		),
		'1500-honamas-shirts-vor-der-wm-2006' => array(
			'image' => array( '310 100 1206 scaled', '310-100_1206-scaled' ),
		),
		'mannschaftsfoto-der-ur-honamas-2006' => array(
			'image' => array( '416 Team Honamas', '416-team_honamas' ),
		),
		'reece-trikotdesign-2017'             => array(
			'image' => array( '347 Reece Australia Design Honamas Home', '347-reece-australia-design-honamas-home' ),
		),
	);

	foreach ( $assignments as $slug => $assets ) {
		$posts = get_posts(
			array(
				'name'           => $slug,
				'post_type'      => 'honamas_archive_item',
				'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
				'posts_per_page' => 1,
			)
		);

		if ( ! $posts ) {
			continue;
		}

		$post_id = (int) $posts[0]->ID;

		if ( ! empty( $assets['clear_image'] ) ) {
			delete_post_thumbnail( $post_id );
		}

		if ( ! empty( $assets['image'] ) ) {
			$image_id = honamas_core_find_attachment_id( $assets['image'], 'image' );
			if ( $image_id ) {
				set_post_thumbnail( $post_id, $image_id );
			}
		}

		if ( empty( get_post_meta( $post_id, 'honamas_file_id', true ) ) && ! empty( $assets['file'] ) ) {
			$file_id = honamas_core_find_attachment_id( $assets['file'], 'application/pdf' );
			if ( $file_id ) {
				update_post_meta( $post_id, 'honamas_file_id', $file_id );
			}
		}
	}

	update_option( 'honamas_core_initial_archive_assets_assigned', '2026-08-15-1', false );
}
add_action( 'admin_init', 'honamas_core_assign_initial_archive_assets', 25 );

function honamas_core_ensure_archive_categories(): void {
	foreach ( array( 'dokumente' => 'Dokumente', 'kleidung' => 'Kleidung', 'fotos' => 'Fotos', 'presse' => 'Presse' ) as $slug => $name ) {
		if ( ! term_exists( $slug, 'honamas_archive_category' ) ) {
			wp_insert_term( $name, 'honamas_archive_category', array( 'slug' => $slug ) );
		}
	}
}
add_action( 'init', 'honamas_core_ensure_archive_categories', 20 );

function honamas_core_seed_archive_categories(): void {
	honamas_core_ensure_archive_categories();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'honamas_core_seed_archive_categories' );
register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
