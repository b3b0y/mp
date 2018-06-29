<?php
/**
 * @package Baroque
 */

$col = baroque_get_option( 'single_post_col_award' );
$offset = baroque_get_option( 'single_post_col_offset_award' );
$colOffset = '';
if ( $offset != 0 ) {
	$colOffset = 'col-md-offset-' . $offset;
}

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<div class="container">
			<div class="row">
				<div class="col-md-<?php echo esc_attr( $col ) ?> <?php echo esc_attr( $colOffset ) ?> col-xs-12 col-sm-12">
					<div class="entry-meta">
						<?php baroque_entry_meta( true ) ?>
					</div><!-- .entry-meta -->
					<h2 class="entry-title"><?php the_title() ?></h2>
				</div>
			</div>
		</div>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'baroque' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<?php baroque_entry_footer(); ?>

</article><!-- #post-## -->
