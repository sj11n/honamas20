<?php
/**
 * Shortcodes for the parts of the HONAMAS pages that are built from WordPress data:
 * the chapter navigation (all pages with the template „Kapitel“, in their page order)
 * and the Ur-HONAMAS team (the Teammitglieder posts).
 *
 * @package HonamasCore
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Published pages that use the „Kapitel“ template, ordered by their page order.
 *
 * @return WP_Post[]
 */
function honamas_core_get_chapters(): array {
	return get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'posts_per_page' => 30,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'title'      => 'ASC',
			),
			'meta_key'       => '_wp_page_template', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'meta_value'     => 'kapitel', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
		)
	);
}

function honamas_core_render_chapter_navigation(): string {
	$chapters = honamas_core_get_chapters();
	if ( ! $chapters ) {
		return '';
	}

	$current = get_queried_object_id();
	$items   = '';
	foreach ( $chapters as $chapter ) {
		$is_current = (int) $chapter->ID === (int) $current;
		$items     .= sprintf(
			'<li><a class="bar-link%s" href="%s"%s>%s</a></li>',
			$is_current ? ' is-current' : '',
			esc_url( get_permalink( $chapter ) ),
			$is_current ? ' aria-current="page"' : '',
			esc_html( get_the_title( $chapter ) )
		);
	}

	return sprintf(
		'<nav class="chap-nav" aria-label="%s"><ul>%s</ul></nav>',
		esc_attr__( 'Kapitel der Geschichte', 'honamas-core' ),
		$items
	);
}
add_shortcode( 'honamas_kapitel_navigation', 'honamas_core_render_chapter_navigation' );

function honamas_core_render_chapter_pager(): string {
	$chapters = honamas_core_get_chapters();
	$ids      = array_map( static fn( WP_Post $p ): int => (int) $p->ID, $chapters );
	$index    = array_search( (int) get_queried_object_id(), $ids, true );
	if ( false === $index ) {
		return '';
	}

	$link = static function ( string $url, string $title, string $label, bool $next ): string {
		return sprintf(
			'<a class="pager-link%s" href="%s"><span class="pager-title">%s</span><span class="small">%s</span></a>',
			$next ? ' pager-next' : '',
			esc_url( $url ),
			esc_html( $title ),
			esc_html( $label )
		);
	};

	$previous = $chapters[ $index - 1 ] ?? null;
	$next     = $chapters[ $index + 1 ] ?? null;
	$team     = get_page_by_path( 'die-ur-honamas' );

	$left = $previous
		? $link( get_permalink( $previous ), get_the_title( $previous ), __( 'Vorheriges Kapitel', 'honamas-core' ), false )
		: $link( home_url( '/#geschichte' ), __( 'Die Geschichte', 'honamas-core' ), __( 'Zur Übersicht', 'honamas-core' ), false );

	if ( $next ) {
		$right = $link( get_permalink( $next ), get_the_title( $next ), __( 'Nächstes Kapitel', 'honamas-core' ), true );
	} elseif ( $team ) {
		$right = $link( get_permalink( $team ), get_the_title( $team ), __( 'Weiter', 'honamas-core' ), true );
	} else {
		$right = $link( home_url( '/' ), 'HONAMAS', __( 'Zur Startseite', 'honamas-core' ), true );
	}

	return sprintf( '<section class="pager wrap" aria-label="%s">%s%s</section>', esc_attr__( 'Weiter lesen', 'honamas-core' ), $left, $right );
}
add_shortcode( 'honamas_kapitel_weiter', 'honamas_core_render_chapter_pager' );

/**
 * The Ur-HONAMAS from the Teammitglieder posts: layout="bars" (start page) or layout="roster" (team page).
 */
function honamas_core_render_team( $atts ): string {
	$atts    = shortcode_atts( array( 'layout' => 'roster' ), $atts, 'honamas_team' );
	$members = get_posts(
		array(
			'post_type'      => 'honamas_team_member',
			'post_status'    => 'publish',
			'posts_per_page' => 60,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'title'      => 'ASC',
			),
		)
	);
	if ( ! $members ) {
		return '';
	}

	$out = '';
	foreach ( $members as $i => $member ) {
		$name     = get_the_title( $member );
		$nickname = (string) get_post_meta( $member->ID, 'honamas_nickname', true );
		$facts    = honamas_core_team_facts( $member->ID );
		$quote    = (string) get_post_meta( $member->ID, 'honamas_team_quote', true );
		$image    = get_post_thumbnail_id( $member );
		$alt      = $nickname
			? sprintf( /* translators: 1: name, 2: nickname. */ __( 'Porträt von %1$s, genannt %2$s', 'honamas-core' ), $name, $nickname )
			: sprintf( /* translators: %s: name. */ __( 'Porträt von %s', 'honamas-core' ), $name );
		$picture  = $image ? wp_get_attachment_image( $image, 'medium_large', false, array( 'alt' => $alt, 'loading' => 'lazy' ) ) : '';

		if ( 'bars' === $atts['layout'] ) {
			$text = '';
			if ( $facts ) {
				$text .= '<p>' . esc_html( implode( ', ', $facts ) ) . '</p>';
			}
			if ( $quote ) {
				$text .= '<p class="bar-quote">„' . esc_html( $quote ) . '“</p>';
			}
			$out .= sprintf(
				'<details class="bar"%s><summary><span class="bar-name">%s</span><span class="bar-nick">%s</span></summary><div class="bar-body">%s%s</div></details>',
				0 === $i ? ' open' : '',
				esc_html( $name ),
				esc_html( $nickname ),
				$picture,
				$text ? '<div class="bar-text">' . $text . '</div>' : ''
			);
		} else {
			$out .= sprintf(
				'<li class="roster-item">%s<span class="roster-name">%s</span>%s%s</li>',
				$picture,
				esc_html( $name ),
				$nickname ? '<span class="roster-nick small">' . esc_html( sprintf( /* translators: %s: nickname. */ __( 'genannt %s', 'honamas-core' ), $nickname ) ) . '</span>' : '',
				$facts ? '<span class="roster-facts small">' . esc_html( implode( ' · ', $facts ) ) . '</span>' : ''
			);
		}
	}

	return 'bars' === $atts['layout']
		? '<div class="bars">' . $out . '</div>'
		: '<ul class="roster">' . $out . '</ul>';
}
add_shortcode( 'honamas_team', 'honamas_core_render_team' );

/**
 * Jersey number, position and club of 2006 for a team member, as far as they are filled in.
 *
 * @return string[]
 */
function honamas_core_team_facts( int $member_id ): array {
	$facts  = array();
	$number = (int) get_post_meta( $member_id, 'honamas_jersey_number', true );
	if ( $number ) {
		/* translators: %d: jersey number. */
		$facts[] = sprintf( __( 'Rückennummer %d', 'honamas-core' ), $number );
	}
	foreach ( array( 'honamas_position_2006', 'honamas_club_2006' ) as $key ) {
		$value = trim( (string) get_post_meta( $member_id, $key, true ) );
		if ( '' !== $value ) {
			$facts[] = $value;
		}
	}
	return $facts;
}

/**
 * The chapters with their featured image, for the side column of plain pages (Impressum, Kontakt, Datenschutz).
 */
function honamas_core_render_chapter_teaser(): string {
	$chapters = honamas_core_get_chapters();
	if ( ! $chapters ) {
		return '';
	}
	$items = '';
	foreach ( $chapters as $chapter ) {
		$image  = get_post_thumbnail_id( $chapter );
		$items .= sprintf(
			'<li><a href="%s">%s<span>%s</span></a></li>',
			esc_url( get_permalink( $chapter ) ),
			$image ? wp_get_attachment_image( $image, 'medium', false, array( 'alt' => '', 'loading' => 'lazy' ) ) : '',
			esc_html( get_the_title( $chapter ) )
		);
	}
	return sprintf(
		'<aside class="teaser" aria-labelledby="teaser-h"><h2 id="teaser-h">%s</h2><ul class="teaser-list">%s</ul></aside>',
		esc_html__( 'Die Geschichte', 'honamas-core' ),
		$items
	);
}
add_shortcode( 'honamas_kapitel_teaser', 'honamas_core_render_chapter_teaser' );

/**
 * Up to four other archive objects with a picture, shown under an archive object.
 */
function honamas_core_render_archive_more(): string {
	$items = get_posts(
		array(
			'post_type'      => 'honamas_archive_item',
			'post_status'    => 'publish',
			'posts_per_page' => 4,
			'post__not_in'   => array( (int) get_queried_object_id() ),
			'meta_key'       => '_thumbnail_id', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'orderby'        => 'date',
		)
	);
	if ( ! $items ) {
		return '';
	}
	$cards = '';
	foreach ( $items as $item ) {
		$cards .= sprintf(
			'<article class="honamas-archive-card"><a class="honamas-archive-card__image" href="%1$s" aria-label="%2$s">%3$s</a><div class="honamas-archive-card__content"><h3><a href="%1$s">%4$s</a></h3></div></article>',
			esc_url( get_permalink( $item ) ),
			esc_attr( get_the_title( $item ) ),
			get_the_post_thumbnail( $item, 'medium_large', array( 'loading' => 'lazy' ) ),
			esc_html( get_the_title( $item ) )
		);
	}
	return sprintf(
		'<section class="archive-more wrap" aria-labelledby="archive-more-h"><h2 id="archive-more-h">%s</h2><div class="honamas-archive-grid archive-more-grid">%s</div></section>',
		esc_html__( 'Mehr aus dem Archiv', 'honamas-core' ),
		$cards
	);
}
add_shortcode( 'honamas_archive_more', 'honamas_core_render_archive_more' );
