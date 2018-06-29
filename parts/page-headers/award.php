<?php
$page_header = baroque_get_option( 'award_page_header' );

if ( ! intval( $page_header ) ) {
	return;
}

?>

<div class="page-header blog-page-header">
	<div class="container">
		<?php
		the_archive_title( '<h1>', '</h1>' );
		baroque_award_description();
		?>
	</div>
</div>
