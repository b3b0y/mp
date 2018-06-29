<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Baroque
 */

get_header(); ?>

<div id="primary" class="content-area <?php baroque_content_columns(); ?>">
	<main id="main" class="site-main">


		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'parts/content', 'award' ); ?>

			<?php baroque_author_box(); ?>

			<?php get_template_part( 'parts/related-posts' ); ?>

			<?php
			// If comments are open or we have at least one comment, load up the comment template
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
			?>

		<?php endwhile; // end of the loop. ?>


	</main>
	<!-- #main -->
</div>
		<!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
