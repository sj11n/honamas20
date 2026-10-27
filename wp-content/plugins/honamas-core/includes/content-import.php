<?php
/**
 * Content import: puts the HONAMAS page content (content/*.html, written by scripts/build-content.mjs)
 * into the WordPress pages and its media into the media library.
 *
 * Runs only when an editor presses the button under Werkzeuge › HONAMAS-Inhalte. Existing pages are
 * updated in place, so their previous version stays available as a revision.
 *
 * @package HonamasCore
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const HONAMAS_CORE_CONTENT_DIR = __DIR__ . '/../content/';

function honamas_core_content_manifest(): array {
	$file = HONAMAS_CORE_CONTENT_DIR . 'pages.json';
	if ( ! is_readable( $file ) ) {
		return array();
	}
	$manifest = json_decode( (string) file_get_contents( $file ), true );
	return is_array( $manifest ) ? $manifest : array();
}

function honamas_core_add_content_import_page(): void {
	add_management_page(
		__( 'HONAMAS-Inhalte', 'honamas-core' ),
		__( 'HONAMAS-Inhalte', 'honamas-core' ),
		'edit_pages',
		'honamas-content',
		'honamas_core_render_content_import_page'
	);
}
add_action( 'admin_menu', 'honamas_core_add_content_import_page' );

function honamas_core_render_content_import_page(): void {
	if ( ! current_user_can( 'edit_pages' ) || ! current_user_can( 'upload_files' ) ) {
		wp_die( esc_html__( 'Keine Berechtigung.', 'honamas-core' ) );
	}

	$manifest = honamas_core_content_manifest();
	$imported = (int) get_option( 'honamas_core_content_version', 0 );
	$version  = (int) ( $manifest['version'] ?? 0 );
	$result   = isset( $_GET['honamas-import'] ) ? sanitize_key( wp_unslash( $_GET['honamas-import'] ) ) : '';
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'HONAMAS-Inhalte', 'honamas-core' ); ?></h1>
		<?php if ( 'done' === $result ) : ?>
			<div class="notice notice-success"><p><?php esc_html_e( 'Die Inhalte wurden übernommen. Frühere Fassungen sind als Revision der jeweiligen Seite gespeichert.', 'honamas-core' ); ?></p></div>
		<?php elseif ( 'error' === $result ) : ?>
			<div class="notice notice-error"><p><?php esc_html_e( 'Beim Übernehmen ist ein Fehler aufgetreten. Details stehen im Fehlerprotokoll des Servers.', 'honamas-core' ); ?></p></div>
		<?php endif; ?>

		<p><?php esc_html_e( 'Übernimmt die Startseite, die fünf Kapitel und die Seiten Der Honama, Die Ur-HONAMAS, Erfolge und Der Film in WordPress. Bilder und Videos kommen in die Mediathek. Danach werden alle Inhalte hier im Backend gepflegt.', 'honamas-core' ); ?></p>
		<p><?php esc_html_e( 'Bestehende Seiten werden überschrieben, ihre bisherige Fassung bleibt als Revision erhalten. Die Startseite wird als statische Startseite eingestellt. Im Impressum wird nur der Abschnitt „Quellen und Bildnachweise“ angehängt, der übrige Text bleibt unverändert.', 'honamas-core' ); ?></p>

		<table class="widefat striped" style="max-width:760px">
			<thead><tr><th><?php esc_html_e( 'Seite', 'honamas-core' ); ?></th><th><?php esc_html_e( 'Status', 'honamas-core' ); ?></th></tr></thead>
			<tbody>
			<?php foreach ( $manifest['pages'] ?? array() as $page ) : ?>
				<?php $existing = get_page_by_path( $page['slug'] ); ?>
				<tr>
					<td><?php echo esc_html( $page['title'] ); ?> <code>/<?php echo esc_html( $page['slug'] ); ?>/</code></td>
					<td><?php echo esc_html( $existing ? __( 'vorhanden, wird aktualisiert', 'honamas-core' ) : __( 'wird angelegt', 'honamas-core' ) ); ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>

		<p>
			<?php
			echo esc_html(
				$imported >= $version
					? sprintf( /* translators: %d: content version. */ __( 'Fassung %d ist bereits übernommen. Ein erneutes Übernehmen überschreibt Änderungen, die seitdem im Backend gemacht wurden.', 'honamas-core' ), $imported )
					: sprintf( /* translators: %d: content version. */ __( 'Fassung %d ist bereit zur Übernahme.', 'honamas-core' ), $version )
			);
			?>
		</p>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="honamas_core_import_content">
			<?php wp_nonce_field( 'honamas_core_import_content' ); ?>
			<?php submit_button( __( 'Inhalte übernehmen', 'honamas-core' ), 'primary', 'submit', false ); ?>
		</form>
	</div>
	<?php
}

function honamas_core_handle_content_import(): void {
	if ( ! current_user_can( 'edit_pages' ) || ! current_user_can( 'upload_files' ) ) {
		wp_die( esc_html__( 'Keine Berechtigung.', 'honamas-core' ) );
	}
	check_admin_referer( 'honamas_core_import_content' );

	$ok = honamas_core_import_content();

	wp_safe_redirect( add_query_arg( 'honamas-import', $ok ? 'done' : 'error', admin_url( 'tools.php?page=honamas-content' ) ) );
	exit;
}
add_action( 'admin_post_honamas_core_import_content', 'honamas_core_handle_content_import' );

/**
 * Import every page of the manifest. Returns false when a page or a media file failed.
 */
function honamas_core_import_content(): bool {
	$manifest = honamas_core_content_manifest();
	if ( empty( $manifest['pages'] ) ) {
		return false;
	}

	if ( function_exists( 'set_time_limit' ) ) {
		set_time_limit( 300 );
	}

	$ok      = true;
	$page_id = array();

	foreach ( $manifest['pages'] as $page ) {
		$content = honamas_core_resolve_content_file( $page['slug'] . '.html' );
		if ( null === $content ) {
			$ok = false;
			continue;
		}

		$existing = get_page_by_path( $page['slug'] );
		$postarr  = array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => $page['title'],
			'post_name'    => $page['slug'],
			'post_content' => $content,
			'menu_order'   => (int) $page['menu_order'],
		);
		if ( $existing ) {
			$postarr['ID'] = $existing->ID;
		}

		$id = $existing ? wp_update_post( wp_slash( $postarr ), true ) : wp_insert_post( wp_slash( $postarr ), true );
		if ( is_wp_error( $id ) ) {
			error_log( 'HONAMAS import: ' . $page['slug'] . ': ' . $id->get_error_message() ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
			$ok = false;
			continue;
		}

		update_post_meta( $id, '_wp_page_template', sanitize_key( $page['template'] ) );
		if ( ! empty( $page['thumbnail'] ) ) {
			$thumbnail = honamas_core_content_media_id( (string) $page['thumbnail'] );
			if ( $thumbnail ) {
				set_post_thumbnail( $id, $thumbnail );
			}
		}
		$page_id[ $page['slug'] ] = (int) $id;
	}

	foreach ( $manifest['append'] ?? array() as $append ) {
		$target = get_page_by_path( $append['slug'] );
		$extra  = honamas_core_resolve_content_file( $append['file'] );
		if ( ! $target || null === $extra ) {
			continue;
		}
		if ( str_contains( $target->post_content, (string) $append['marker'] ) ) {
			continue;
		}
		$result = wp_update_post(
			wp_slash(
				array(
					'ID'           => $target->ID,
					'post_content' => rtrim( $target->post_content ) . "\n\n" . $extra,
				)
			),
			true
		);
		if ( is_wp_error( $result ) ) {
			$ok = false;
		}
	}

	if ( ! empty( $manifest['front_page'] ) && ! empty( $page_id[ $manifest['front_page'] ] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $page_id[ $manifest['front_page'] ] );
	}

	if ( $ok ) {
		update_option( 'honamas_core_content_version', (int) $manifest['version'], false );
	}

	return $ok;
}

/**
 * Read a content file and replace its {{id:file}} and {{url:file}} placeholders with media library values.
 */
function honamas_core_resolve_content_file( string $file ): ?string {
	$path = HONAMAS_CORE_CONTENT_DIR . basename( $file );
	if ( ! is_readable( $path ) ) {
		return null;
	}

	$content = (string) file_get_contents( $path );
	$failed  = false;

	$content = preg_replace_callback(
		'/\{\{(id|url):([a-z0-9._-]+)\}\}/i',
		static function ( array $m ) use ( &$failed ): string {
			$attachment_id = honamas_core_content_media_id( $m[2] );
			if ( ! $attachment_id ) {
				$failed = true;
				return 'id' === $m[1] ? '0' : '';
			}
			return 'id' === $m[1] ? (string) $attachment_id : (string) wp_get_attachment_url( $attachment_id );
		},
		$content
	);

	return $failed ? null : $content;
}

/**
 * The media library ID for a bundled content file, uploading it the first time it is needed.
 */
function honamas_core_content_media_id( string $file ): int {
	static $cache = array();
	if ( isset( $cache[ $file ] ) ) {
		return $cache[ $file ];
	}

	$found = get_posts(
		array(
			'post_type'      => 'attachment',
			'post_status'    => 'inherit',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'meta_key'       => '_honamas_content_file', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'meta_value'     => $file, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
		)
	);
	if ( $found ) {
		$cache[ $file ] = (int) $found[0];
		return $cache[ $file ];
	}

	$source = HONAMAS_CORE_CONTENT_DIR . 'media/' . $file;
	if ( ! is_readable( $source ) ) {
		error_log( 'HONAMAS import: media file missing: ' . $file ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
		return 0;
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$tmp = wp_tempnam( $file );
	copy( $source, $tmp );
	$attachment_id = media_handle_sideload( array( 'name' => $file, 'tmp_name' => $tmp ), 0 );
	if ( is_wp_error( $attachment_id ) ) {
		wp_delete_file( $tmp );
		error_log( 'HONAMAS import: ' . $file . ': ' . $attachment_id->get_error_message() ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
		return 0;
	}

	update_post_meta( $attachment_id, '_honamas_content_file', $file );
	$cache[ $file ] = (int) $attachment_id;
	return $cache[ $file ];
}
