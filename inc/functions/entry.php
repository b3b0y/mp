<?php



/**
 * Get award description
 *
 * @since  1.0
 */

if ( ! function_exists( 'baroque_award_description' ) ) :
	function baroque_award_description() {
		$award_style = baroque_get_option( 'award_style' );

		if ( ! baroque_is_award() ) {
			return;
		}

		if ( $award_style == 'masonry' || $award_style == 'classic' ) {
			return;
		}

		$award_text = do_shortcode( wp_kses( baroque_get_option( 'award_description' ), wp_kses_allowed_html( 'post' ) ) );

		if ( is_category() ) {
			if ( $cat_desc = category_description() ) {
				$award_text = $cat_desc;
			}
		}

		if ( empty( $award_text ) ) {
			return;
		}

		printf( '<div class="page-desc">%s</div>', $award_text );
	}

endif;


/**
 * Check is award
 *
 * @since  1.0
 */

if ( ! function_exists( 'baroque_is_award' ) ) :
	function baroque_is_award() {

		if ( ( is_archive() || is_author() || is_category() || is_home() || is_tag() ) && 'award' == get_post_type() ) {
			return true;
		}

		return false;
	}

endif;
