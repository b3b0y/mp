<?php
/**
 * Hooks for template header
 *
 * @package Baroque
 */

/**
 * Display page header
 */
function baroque_page_header_new() {


	if ( baroque_is_award() ) {
		get_template_part( 'parts/page-headers/award' );
	}
}

add_action( 'baroque_after_header', 'baroque_page_header_new', 10 );


/**
 * Filter to archive title and add page title for singular pages
 *
 * @param string $title
 *
 * @return string
 */
function baroque_the_archive_title_new( $title ) {
	if ( is_search() ) {
		$title = esc_html__( 'Search Results', 'baroque' );

	} elseif ( baroque_is_award() ) {
		$title = wp_kses( baroque_get_option( 'award_page_header_title' ), wp_kses_allowed_html( 'post' ) );

		if ( ! $title ) {
			$title = get_the_title( get_option( 'page_for_posts' ) );
		}

	}

	return $title;
}

add_filter( 'get_the_archive_title', 'baroque_the_archive_title_new' );
