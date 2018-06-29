<?php
/**
 * Hooks for frontend display
 *
 * @package Baroque
 */


/**
 * Adds custom classes to the array of body classes.
 *
 * @since 1.0
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function baroque_body_classes_new( $classes ) {

	if ( is_singular( 'post' ) ) {
		$classes[] = baroque_get_option( 'single_post_layout_award' );

		if ( ! intval( baroque_get_option( 'show_post_format' ) ) ||
			( ! baroque_single_post_has_post_format() )
		) {
			$classes[] = 'hide-post-format';
		}

	} elseif ( baroque_is_award() ) {


		$classes[] = 'baroque-blog-page';
		$classes[] = 'blog-' . baroque_get_option( 'award_style' );
		$classes[] = baroque_get_option( 'award_layout' );

	}

	return $classes;
}

add_filter( 'body_class', 'baroque_body_classes_new' );
