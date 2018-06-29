<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Baroque
 */

get_header();

$award_view = baroque_get_option( 'award_style' );
$type_nav  = baroque_get_option( 'type_nav_award' );
$css       = 'clearfix';
$row_css   = '';

if ( $award_view == 'grid' ) {
	$row_css = 'row';
} elseif ( $award_view == 'masonry' ) {
	$row_css = 'baroque-post-row';
}

$col = 'col-md-8 col-xs-12 col-sm-12';

?>

<div id="primary" class="content-area <?php baroque_content_columns(); ?>">
	<main id="main" class="site-main <?php echo esc_attr( $award_view == 'text' ? 'row' : '' ); ?>">

		<?php
		/* baroque_award_text_categories
		 *
		 */
		do_action( 'baroque_before_archive_post_list' );
		?>

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>

			<div class="ba-award-content <?php echo esc_attr( $award_view == 'text' ? $col : '' ); ?>">
				<div class="ba-award-loading">
					<span class="loading-icon">
						<span class="bubble"><span class="dot"></span></span>
						<span class="bubble"><span class="dot"></span></span>
						<span class="bubble"><span class="dot"></span></span>
					</span>
				</div>

				<div class="<?php echo esc_attr( $row_css ) ?>">

					<div class="baroque-post-list <?php echo esc_attr( $css ) ?>">

						<?php while ( have_posts() ) : the_post(); ?>

							<?php
							/* Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'parts/content', get_post_format() );
							?>

						<?php endwhile; ?>

					</div>
					<!--.baroque-post-list-->

				</div>
				<!--.row-->

				<?php
				if ( $type_nav == 'numeric' ) {
					baroque_numeric_pagination();
				} else {
					baroque_paging_nav();
				}
				?>

			</div><!--.ba-award-content-->

		<?php else : ?>

			<?php get_template_part( 'parts/content', 'none' ); ?>

		<?php endif; ?>


	</main>
	<!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
