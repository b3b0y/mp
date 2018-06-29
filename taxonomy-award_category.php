<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Baroque
 */

get_header();


?>

<div class="page-header page-header-default" style="padding-top: 0;">
	<div class="container">
		<div class="row">
			<div class=" col-md-12col-sm-12 col-xs-12">
				<img src="<?php  echo  get_theme_mod('award_image'); ?>" class="img-responsive">
				<h3><?php  echo  get_theme_mod('award_header_title'); ?></h3>
				<p> <?php  echo  get_theme_mod('award_description'); ?> </p>
			</div>
		</div>
		</p>
	</div>
</div>

<div class="portfolio-masonry">
	<div id="primary" class="content-area <?php baroque_content_columns(); ?>">

		<?php do_action( 'baroque_award_category_content_before' ); ?>

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>

			<div class="ba-portfolio-content">
				<div class="ba-portfolio-loading">
					<span class="loading-icon">
						<span class="bubble"><span class="dot"></span></span>
						<span class="bubble"><span class="dot"></span></span>
						<span class="bubble"><span class="dot"></span></span>
					</span>
				</div>
				<div class="list-portfolio">
					<?php while ( have_posts() ) : the_post(); ?>

						<?php

						/* Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'parts/content', 'award' );
						?>

					<?php endwhile; ?>
				</div>
			<?php baroque_numeric_pagination(); ?>
		</div>
		<?php else : ?>

			<?php get_template_part( 'parts/content', 'none' ); ?>

		<?php endif; ?>

		<?php do_action( 'baroque_award_category_content_after' ); ?>

	</div><!-- #primary -->
</div>
<?php get_footer(); ?>
