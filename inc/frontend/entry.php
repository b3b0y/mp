<?php
/**
 * Hooks for template archive
 *
 * @package Baroque
 */


/**
 * Open tag after start site content
 */
if ( ! function_exists( 'baroque_site_content_open' ) ) :

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

/**
 * Single Post Format
 */
if ( ! function_exists( 'baroque_single_post_format' ) ) :

	function baroque_single_post_format() {
		if ( ! is_singular( 'post' ) ) {
			return;
		}

		get_template_part( 'parts/single-thumbnail' );
	}

endif;

add_action( 'baroque_site_content_open', 'baroque_single_post_format', 10 );

/**
 * Single Portfolio Thumbnail
 */
if ( ! function_exists( 'baroque_single_portfolio_thumb' ) ) :

	function baroque_single_portfolio_thumb() {
		if ( ! is_singular( 'portfolio' ) ) {
			return;
		}

		get_template_part( 'parts/single-portfolio-thumb' );
	}

endif;

add_action( 'baroque_before_single_portfolio', 'baroque_single_portfolio_thumb', 10 );

/**
 * Add award categories
 *
 * @since  1.0
 *
 *
 */
if ( ! function_exists( 'baroque_award_text_categories' ) ) :
	function baroque_award_text_categories() {
		$award_style = baroque_get_option( 'award_style' );
		$cat_filter = intval( baroque_get_option( 'award_cat_filter' ) );

		if ( ! $cat_filter ) {
			return;
		}

		if ( $award_style == 'text' ) {
			echo '<div class="col-md-4 col-sm-12 col-xs-12 award-text-filter">';
		}

		if ( $award_style == 'masonry' ) {
			echo '<div class="container">';
		}

		baroque_taxs_list();

		if ( $award_style == 'masonry' ) {
			echo '</div>';
		}

		if ( $award_style == 'text' ) {
			echo '</div>';
		}
	}
endif;

add_action( 'baroque_before_post_list', 'baroque_award_text_categories' );
add_action( 'baroque_before_archive_post_list', 'baroque_award_text_categories' );

/**
 *  Add award featured
 *
 *
 */

if ( ! function_exists( 'baroque_award_featured' ) ) :
	function baroque_award_featured() {

		if ( ! baroque_is_award() ) {
			return;
		}

		if ( baroque_get_option( 'award_style' ) != 'text' ) {
			return;
		}

		$query = new WP_Query(
			array(
				'posts_per_page' => 1,
				'tag'            => 'featured',
			)
		);

		$output = '';
		while ( $query->have_posts() ) : $query->the_post();
			$image  = get_the_post_thumbnail_url();
			$bg_css = '';
			if ( $image ) {
				$bg_css = 'style="background-image:url(' . esc_url( $image ) . ')"';
			}
			$categories = get_the_category();
			if ( ! empty( $categories ) ) {
				$output .= '<a class="cat-title" href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
			}
			$output .= sprintf(
				'<h2><a href="%s" class="post-title">' .
				'%s' .
				'</a></h2>',
				esc_url( get_the_permalink() ),
				get_the_title()
			);

			echo sprintf(
				'<div class="baroque-post-featured">' .
				'<div class="featured-image" %s></div>' .
				'<div class="post-featured-content parallax" id="baroque-post-featured-content">' .
				'<div class="container">' .
				'%s' .
				'</div>' .
				'</div>' .
				'</div>',
				$bg_css,
				$output
			);

			break;
		endwhile;
		wp_reset_postdata();
	}

endif;

add_action( 'baroque_after_header', 'baroque_award_featured', 20 );


/**
 * Add portfolio header
 *
 * @since  1.0
 *
 *
 */
if ( ! function_exists( 'baroque_portfolio_header' ) ) :
	function baroque_portfolio_header() {
		$portfolio_layout = baroque_get_option( 'single_portfolio_layout' );

		if ( get_post_meta( get_the_ID(), 'custom_portfolio_layout', true ) ) {
			$portfolio_layout = get_post_meta( get_the_ID(), 'portfolio_layout', true );
		}

		if ( $portfolio_layout != '4' ) {
			return;
		}

		?>
		<div class="container">
			<div class="entry-header">
				<h2><?php the_title(); ?></h2>
				<div class="portfolio-excerpt"><?php the_excerpt(); ?></div>
				<?php echo baroque_portfolio_meta(); ?>
			</div>
		</div>
		<?php
	}
endif;

add_action( 'baroque_before_single_portfolio_content', 'baroque_portfolio_header', 10 );

/**
 * Add portfolio socials share
 *
 * @since  1.0
 *
 *
 */
if ( ! function_exists( 'baroque_portfolio_footer' ) ) :
	function baroque_portfolio_footer() {
		$portfolio_layout = baroque_get_option( 'single_portfolio_layout' );

		if ( get_post_meta( get_the_ID(), 'custom_portfolio_layout', true ) ) {
			$portfolio_layout = get_post_meta( get_the_ID(), 'portfolio_layout', true );
		}

		if ( $portfolio_layout != '4' ) {
			return;
		}
		if ( function_exists( 'baroque_addons_share_link_socials' ) ) {
			?>
			<div class="container">
				<div class="entry-footer">
					<?php echo baroque_addons_share_link_socials( get_the_title(), get_the_permalink(), get_the_post_thumbnail() ) ?>
				</div>
			</div>
			<?php
		}
	}
endif;

add_action( 'baroque_after_single_portfolio_content', 'baroque_portfolio_footer', 10 );

/**
 * Add portfolio button
 *
 * @since  1.0
 *
 *
 */
if ( ! function_exists( 'baroque_portfolio_button' ) ) :
	function baroque_portfolio_button() {
		$portfolio_layout = baroque_get_option( 'single_portfolio_layout' );

		if ( get_post_meta( get_the_ID(), 'custom_portfolio_layout', true ) ) {
			$portfolio_layout = get_post_meta( get_the_ID(), 'portfolio_layout', true );
		}

		if ( $portfolio_layout != '2' ) {
			return;
		}

		?>
		<div class="portfolio-button">
			<a href="<?php echo esc_url( get_post_type_archive_link( 'portfolio' ) ) ?>">
				<?php echo apply_filters( 'baroque_back_to_projects_button', esc_html__( 'BACK TO PROJECTS', 'baroque' ) ); ?>
			</a>
			<a class="portfolio-toggle-content" href="#">
				<?php echo apply_filters( 'baroque_portfolio_show_content', esc_html__( 'SHOW INFORMATION', 'baroque' ) ); ?>
				<i class="icon-plus"></i>
			</a>
		</div>
		<?php
	}
endif;

add_action( 'baroque_after_single_portfolio_content', 'baroque_portfolio_button', 20 );


/**
 * Add portfolio categories
 *
 * @since  1.0
 *
 *
 */
if ( ! function_exists( 'baroque_portfolio_taxes_list' ) ) :
	function baroque_portfolio_taxes_list() {
		$p_style    = baroque_get_option( 'portfolio_style' );
		$cat_filter = intval( baroque_get_option( 'portfolio_cat_filter' ) );

		if ( ! $cat_filter ) {
			return;
		}

		if ( $p_style == 'parallax' || $p_style == 'carousel' ) {
			return;
		}

		if ( $p_style == 'grid-wide' ) {
			echo '<div class="container">';
		}

		baroque_taxs_list( 'portfolio_category' );

		if ( $p_style == 'grid-wide' ) {
			echo '</div>';
		}
	}
endif;

add_action( 'baroque_before_portfolio_content', 'baroque_portfolio_taxes_list', 10 );
add_action( 'baroque_before_archive_portfolio_content', 'baroque_portfolio_taxes_list', 10 );

/**
 * Open frame portfolio carousel
 *
 * @since  1.0
 *
 *
 */
if ( ! function_exists( 'baroque_open_frame_portfolio_carousel' ) ) :
	function baroque_open_frame_portfolio_carousel() {
		$p_style = baroque_get_option( 'portfolio_style' );

		if ( $p_style != 'carousel' ) {
			return;
		}

		echo '<div class="portfolio-frame">';
	}
endif;

add_action( 'baroque_before_portfolio_content', 'baroque_open_frame_portfolio_carousel', 20 );
add_action( 'baroque_before_archive_portfolio_content', 'baroque_open_frame_portfolio_carousel', 20 );

/**
 * Close frame portfolio carousel
 *
 * @since  1.0
 *
 *
 */
if ( ! function_exists( 'baroque_close_frame_portfolio_carousel' ) ) :
	function baroque_close_frame_portfolio_carousel() {
		$p_style = baroque_get_option( 'portfolio_style' );

		if ( $p_style != 'carousel' ) {
			return;
		}

		echo '</div>';
	}
endif;

add_action( 'baroque_after_portfolio_content', 'baroque_close_frame_portfolio_carousel', 10 );
add_action( 'baroque_after_archive_portfolio_content', 'baroque_close_frame_portfolio_carousel', 10 );

/**
 * Open wrapper portfolio carousel
 *
 * @since  1.0
 *
 *
 */
if ( ! function_exists( 'baroque_open_wrapper_portfolio_carousel' ) ) :
	function baroque_open_wrapper_portfolio_carousel() {
		$p_style = baroque_get_option( 'portfolio_style' );

		if ( $p_style != 'carousel' ) {
			return;
		}

		$css = array(
			'portfolio-carousel-wrapper',
		);

		$arrow     = baroque_get_option( 'portfolio_carousel_arrows' );
		$scrollbar = baroque_get_option( 'portfolio_carousel_scrollbar' );
		$dots      = baroque_get_option( 'portfolio_carousel_dots' );

		if ( ! intval( $arrow ) ) {
			$css[] = 'hide-navigation';
		}

		if ( ! intval( $scrollbar ) ) {
			$css[] = 'hide-scrollbar';
		}

		if ( $dots == false ) {
			$css[] = 'hide-dots';
		}

		echo '<div id="baroque-portfolio-carousel-wrapper" class="' . implode( ' ', $css ) . '">';
	}
endif;

add_action( 'baroque_before_portfolio_content', 'baroque_open_wrapper_portfolio_carousel', 15 );
add_action( 'baroque_before_archive_portfolio_content', 'baroque_open_wrapper_portfolio_carousel', 15 );

/**
 * Close wrapper portfolio carousel
 *
 * @since  1.0
 *
 *
 */
if ( ! function_exists( 'baroque_close_wrapper_portfolio_carousel' ) ) :
	function baroque_close_wrapper_portfolio_carousel() {
		$p_style = baroque_get_option( 'portfolio_style' );

		if ( $p_style != 'carousel' ) {
			return;
		}

		echo '</div>';
	}
endif;

add_action( 'baroque_after_portfolio_content', 'baroque_close_wrapper_portfolio_carousel', 50 );
add_action( 'baroque_after_archive_portfolio_content', 'baroque_close_wrapper_portfolio_carousel', 50 );

/**
 * Close wrapper portfolio carousel
 *
 * @since  1.0
 *
 *
 */
if ( ! function_exists( 'baroque_option_portfolio_carousel' ) ) :
	function baroque_option_portfolio_carousel() {
		$p_style = baroque_get_option( 'portfolio_style' );

		if ( $p_style != 'carousel' ) {
			return;
		}

		printf(
			'<div class="navigation">
				<div class="container">
					<div class="btn-prev"><i class="icon-chevron-left"></i></div>
					<div class="btn-next"><i class="icon-chevron-right"></i></div>
				</div>
			</div>
			<div class="container">
				<div class="scrollbar">
					<div class="handle">
						<div class="mousearea"></div>
					</div>
				</div>
				<ul class="pages">
				</ul>
			</div>'
		);
	}
endif;

add_action( 'baroque_after_portfolio_content', 'baroque_option_portfolio_carousel', 20 );
add_action( 'baroque_after_archive_portfolio_content', 'baroque_option_portfolio_carousel', 20 );

if ( ! function_exists( 'baroque_coming_soon_socials' ) ) :
	function baroque_coming_soon_socials() {

		$project_social = (array) baroque_get_option( 'coming_soon_socials' );

		if ( $project_social ) {

			$socials = (array) baroque_get_socials();

			printf( '<ul class="socials-inline coming-soon-socials">' );
			foreach ( $project_social as $social ) {
				foreach ( $socials as $name => $label ) {
					$link_url = $social['link_url'];

					if ( preg_match( '/' . $name . '/', $link_url ) ) {

						if ( $name == 'google' ) {
							$name = 'googleplus';
						}

						printf( '<li><a href="%s" target="_blank"><i class="social_%s"></i></a></li>', esc_url( $link_url ), esc_attr( $name ) );
						break;
					}
				}
			}
			printf( '</ul>' );
		}

	}

endif;

add_action( 'baroque_coming_soon_page_content', 'baroque_coming_soon_socials', 40 );
