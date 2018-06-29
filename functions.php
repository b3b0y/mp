<?php
add_action( 'wp_enqueue_scripts', 'baroque_child_enqueue_scripts', 50 );

function baroque_child_enqueue_scripts() {
	wp_enqueue_style( 'baroque-child-style', get_stylesheet_uri() );

	if ( is_rtl() ) {
		wp_enqueue_style( 'baroque-rtl', get_template_directory_uri() . '/rtl.css', array(), '20180418' );
	}
}
	// Frontend functions and shortcodes
	require('inc/backend/customizer_new.php');
	require('inc/backend/awards.php');

	// Frontend functions and shortcodes
	require('inc/functions/entry.php');

	// Frontend hooks
	require('inc/frontend/layout.php');
	require( 'inc/frontend/header.php');
	require('inc/frontend/entry.php');


	function baroque_vc_addons_init2() {
		load_plugin_textdomain( 'baroque', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );

		new Baroque_Awards;
	}

	add_action( 'after_setup_theme', 'baroque_vc_addons_init2', 20 );


	function add_award_fields_meta_box() {
		add_meta_box(
			'award_fields_meta_box', // $id
			'Award Fields', // $title
			'show_award_fields_meta_box', // $callback
			'award', // $screen
			'normal', // $context
			'high' // $priority
		);
	}
	add_action( 'add_meta_boxes', 'add_award_fields_meta_box' );

	function show_award_fields_meta_box() {
		global $post;
			$meta = get_post_meta( $post->ID, 'award_fields', true );

		?>

		<input type="hidden" name="your_meta_box_nonce" value="<?php echo wp_create_nonce( basename(__FILE__) ); ?>">

	    <!-- All fields will go here -->
			<p>
				<label for="award_fields[award_url]">URL </label>
				<br>
				<input type="text" name="award_fields[award_url]" id="award_fields[award_url]" class="regular-text" value="<?php echo ($meta != '') ? $meta['award_url'] : ''; ?>">
			</p>
		<?php }

		function save_award_fields_meta( $post_id ) {
		// verify nonce
		if ( !wp_verify_nonce( $_POST['your_meta_box_nonce'], basename(__FILE__) ) ) {
			return $post_id;
		}
		// check autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}
		// check permissions
		if ( 'page' === $_POST['post_type'] ) {
			if ( !current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			} elseif ( !current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}
		}

		$old = get_post_meta( $post_id, 'award_fields', true );
		$new = $_POST['award_fields'];

		if ( $new && $new !== $old ) {
			update_post_meta( $post_id, 'award_fields', $new );
		} elseif ( '' === $new && $old ) {
			delete_post_meta( $post_id, 'award_fields', $old );
		}
	}
	add_action( 'save_post', 'save_award_fields_meta' );
