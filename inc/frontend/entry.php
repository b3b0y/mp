<?php
/**
 * Hooks for template archive
 *
 * @package Baroque
 */

 /**
  * Add CSS classes to posts
  *
  * @param array $classes
  *
  * @return array
  */
 function baroque_post_class_new( $classes ) {

 	$classes[] = has_post_thumbnail() ? '' : 'no-thumb';

 	return $classes;
 }

 add_filter( 'post_class', 'baroque_post_class_new' );


/**
 * Open tag after start site content
 */
if ( ! function_exists( 'baroque_site_content_open_new' ) ) :

	function baroque_site_content_open_new() {
		$b_style     = baroque_get_option( 'award_style' );
		$p_style     = baroque_get_option( 'portfolio_style' );
		$catalog_row = '';

		$container = 'container';

		if ( baroque_is_award() && $b_style == 'masonry' ) {
			$container = 'baroque-container';

		} elseif ( is_singular( 'portfolio' ) ) {
			$container = 'baroque-container';

		} elseif ( baroque_is_portfolio() ) {
			if ( $p_style == 'grid-wide' || $p_style == 'masonry' || $p_style == 'carousel' || $p_style == 'parallax' ) {
				$container = 'baroque-container';
			}
		} elseif ( baroque_is_catalog() ) {
			$container   = 'baroque-container';
			$catalog_row = 'catalog-row';

		} elseif ( baroque_is_page_template() ) {
			$container = 'baroque-container';
		}

		echo '<div class="' . esc_attr( apply_filters( 'baroque_site_content_container_class', $container ) ) . '">';
		echo '<div class="row ' . $catalog_row . '">';
	}

endif;

add_action( 'baroque_site_content_open', 'baroque_site_content_open_new', 20 );

/**
 * Close tag before end site content
 */
if ( ! function_exists( 'baroque_site_content_close' ) ) :

	function baroque_site_content_close() {
		echo '</div>';
		echo '</div>';
	}

endif;

add_action( 'baroque_site_content_close', 'baroque_site_content_close', 100 );
