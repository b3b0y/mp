<?php
/**
 * @package Baroque
 */

global $wp_query;

$current = $wp_query->current_post + 1;

$size = 'baroque-blog-grid';
$award_style = baroque_get_option( 'award_style' );
$excerpt_length = intval( baroque_get_option( 'award_excerpt_length' ) );

$css_class = 'post-wrapper';

if ( 'grid' == $award_style ) {
	$css_class .= ' col-md-4 col-sm-6 col-xs-12';

} elseif ( 'list' == $award_style ) {
	$size = 'baroque-blog-list';

} elseif ( 'masonry' == $award_style ) {
	$css_class .= ' blog-masonry-wrapper';

	if ( $current % 12 == 1 || $current % 12 == 4 || $current % 12 == 5 || $current % 12 == 6 ) {
		$size = 'baroque-blog-masonry-1';
	} elseif ( $current % 12 == 3 || $current % 12 == 9 ) {
		$size = 'baroque-blog-masonry-3';
	} else {
		$size = 'baroque-blog-masonry-2';
	}

} elseif ( 'classic' == $award_style ) {
	$size = 'baroque-blog-classic';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $css_class ); ?>>
	<div class="blog-wrapper">
		<?php if ( 'text' != $award_style && has_post_thumbnail() ) : ?>
			<div class="entry-thumbnail">
				<a class="blog-thumb" href="<?php the_permalink() ?>"><?php the_post_thumbnail( $size ) ?></a>
				<?php if ( 'grid' == $award_style || 'classic' == $award_style ) : ?>
					<a href="<?php the_permalink() ?>" class="read-more">
						<?php echo apply_filters( 'baroque_blog_read_more_text', esc_html__( 'MORE', 'baroque' ) ); ?>
						<i class="icon-plus"></i>
					</a>
				<?php endif ?>
			</div>
		<?php endif; ?>

		<div class="entry-summary">
			<div class="entry-header">
				<div class="entry-meta">
					<?php baroque_entry_meta() ?>
				</div><!-- .entry-meta -->
				<h2 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>

				<?php if ( 'list' == $award_style || 'masonry' == $award_style || 'classic' == $award_style ) : ?>
					<div class="entry-excerpt"><?php baroque_content_limit( $excerpt_length, '' ); ?></div>
				<?php endif ?>
			</div>
			<?php if ( 'list' == $award_style || 'masonry' == $award_style ) : ?>
			<a href="<?php the_permalink() ?>" class="read-more">
				<?php echo apply_filters( 'baroque_blog_read_more_text', esc_html__( 'MORE', 'baroque' ) ); ?>
				<i class="icon-plus"></i>
			</a>
			<?php endif ?>
		</div><!-- .entry-content -->
	</div>
</article><!-- #post-## -->
