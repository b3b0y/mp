<?php
/**
 * Baroque theme customizer
 *
 * @package Baroque
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Baroque_Customize_new {
	/**
	 * Customize settings
	 *
	 * @var array
	 */
	protected $config = array();

	/**
	 * The class constructor
	 *
	 * @param array $config
	 */
	public function __construct( $config ) {
		$this->config = $config;

		if ( ! class_exists( 'Kirki' ) ) {
			return;
		}

		$this->register();
	}

	/**
	 * Register settings
	 */
	public function register() {
		/**
		 * Add the theme configuration
		 */
		if ( ! empty( $this->config['theme'] ) ) {
			Kirki::add_config(
				$this->config['theme'], array(
					'capability'  => 'edit_theme_options',
					'option_type' => 'theme_mod',
				)
			);
		}

		/**
		 * Add panels
		 */
		if ( ! empty( $this->config['panels'] ) ) {
			foreach ( $this->config['panels'] as $panel => $settings ) {
				Kirki::add_panel( $panel, $settings );
			}
		}

		/**
		 * Add sections
		 */
		if ( ! empty( $this->config['sections'] ) ) {
			foreach ( $this->config['sections'] as $section => $settings ) {
				Kirki::add_section( $section, $settings );
			}
		}

		/**
		 * Add fields
		 */
		if ( ! empty( $this->config['theme'] ) && ! empty( $this->config['fields'] ) ) {
			foreach ( $this->config['fields'] as $name => $settings ) {
				if ( ! isset( $settings['settings'] ) ) {
					$settings['settings'] = $name;
				}

				Kirki::add_field( $this->config['theme'], $settings );
			}
		}
	}

	/**
	 * Get config ID
	 *
	 * @return string
	 */
	public function get_theme() {
		return $this->config['theme'];
	}

	/**
	 * Get customize setting value
	 *
	 * @param string $name
	 *
	 * @return bool|string
	 */
	public function get_option( $name ) {

		$default = $this->get_option_default( $name );

		return get_theme_mod( $name, $default );
	}

	/**
	 * Get default option values
	 *
	 * @param $name
	 *
	 * @return mixed
	 */
	public function get_option_default( $name ) {
		if ( ! isset( $this->config['fields'][ $name ] ) ) {
			return false;
		}

		return isset( $this->config['fields'][ $name ]['default'] ) ? $this->config['fields'][ $name ]['default'] : false;
	}
}

/**
 * This is a short hand function for getting setting value from customizer
 *
 * @param string $name
 *
 * @return bool|string
 */
// function baroque_get_option( $name ) {
// 	global $baroque_customize;
//
// 	if ( empty( $baroque_customize ) ) {
// 		return false;
// 	}
//
// 	if ( class_exists( 'Kirki' ) ) {
// 		$value = Kirki::get_option( $baroque_customize->get_theme(), $name );
// 	} else {
// 		$value = $baroque_customize->get_option( $name );
// 	}
//
// 	return apply_filters( 'baroque_get_option', $value, $name );
// }

/**
 * Get default option values
 *
 * @param $name
 *
 * @return mixed
 */

/**
 * Move some default sections to `general` panel that registered by theme
 *
 * @param object $wp_customize
 */
function baroque_customize_modify_new( $wp_customize ) {
	$wp_customize->get_section( 'title_tagline' )->panel     = 'general';
	$wp_customize->get_section( 'static_front_page' )->panel = 'general';
}

add_action( 'customize_register', 'baroque_customize_modify_new' );

function baroque_customize_settings_new() {
	/**
	 * Customizer configuration
	 */

	$settings = array(
		'theme' => 'baroque',
	);

	$panels = array(
		'award'     => array(
			'priority' => 5,
			'title'    => esc_html__( 'Awards', 'baroque' ),
		),
	);

	$sections = array(
		'award_page_header'            => array(
			'title'       => esc_html__( 'Award Page Header', 'baroque' ),
			'description' => '',
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'panel'       => 'award',
		),
		'award_page'                   => array(
			'title'       => esc_html__( 'Award Page', 'baroque' ),
			'description' => '',
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'panel'       => 'award',
		),

		'single_post_award'           => array(
			'title'       => esc_html__( 'Single Post', 'baroque' ),
			'description' => '',
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'panel'       => 'award',
		),
	);

	$fields = array(

		// award
		'award_page_header'             => array(
			'type'        => 'toggle',
			'default'     => 1,
			'label'       => esc_html__( 'Enable Page Header', 'baroque' ),
			'section'     => 'award_page_header',
			'description' => esc_html__( 'Enable to show a page header for award page below the site header', 'baroque' ),
			'priority'    => 10,
		),
		'award_page_header_title'       => array(
			'type'            => 'textarea',
			'label'           => esc_html__( 'Award Page Header Title', 'baroque' ),
			'section'         => 'award_page_header',
			'default'         => '',
			'priority'        => 10,
			'active_callback' => array(
				array(
					'setting'  => 'award_page_header',
					'operator' => '==',
					'value'    => true,
				),
			),
		),
		'award_description'             => array(
			'type'            => 'textarea',
			'label'           => esc_html__( 'Award Description', 'baroque' ),
			'description'     => esc_html__( 'Shortcodes are allowed', 'baroque' ),
			'section'         => 'award_page_header',
			'default'         => '',
			'priority'        => 10,
			'active_callback' => array(
				array(
					'setting'  => 'award_page_header',
					'operator' => '==',
					'value'    => true,
				),
			),
		),
		'award_style'                   => array(
			'type'     => 'select',
			'label'    => esc_html__( 'Award Style', 'baroque' ),
			'section'  => 'award_page',
			'default'  => 'classic',
			'priority' => 10,
			'choices'  => array(
				'grid'    => esc_html__( 'Grid', 'baroque' ),
				'list'    => esc_html__( 'List', 'baroque' ),
				'masonry' => esc_html__( 'Masonry', 'baroque' ),
				'text'    => esc_html__( 'Text', 'baroque' ),
			),
		),
		'award_layout'                  => array(
			'type'            => 'select',
			'label'           => esc_html__( 'Award Classic Layout', 'baroque' ),
			'section'         => 'award_page',
			'default'         => 'content-sidebar',
			'priority'        => 10,
			'description'     => esc_html__( 'Select default sidebar for award classic.', 'baroque' ),
			'choices'         => array(
				'content-sidebar' => esc_html__( 'Right Sidebar', 'baroque' ),
				'sidebar-content' => esc_html__( 'Left Sidebar', 'baroque' ),
				'full-content'    => esc_html__( 'Full Content', 'baroque' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'award_style',
					'operator' => '==',
					'value'    => 'classic',
				),
			),
		),
		'award_excerpt_length'               => array(
			'type'     => 'number',
			'label'    => esc_html__( 'Excerpt Length', 'baroque' ),
			'section'  => 'award_page',
			'default'  => '20',
			'priority' => 10,
		),
		'award_custom_field_1'          => array(
			'type'    => 'custom',
			'section' => 'award_page',
			'default' => '<hr/>',
		),

		'award_custom_field_2'          => array(
			'type'    => 'custom',
			'section' => 'award_page',
			'default' => '<hr/>',
		),
		'type_nav_award'                     => array(
			'type'     => 'select',
			'label'    => esc_html__( 'Type of Navigation', 'baroque' ),
			'section'  => 'award_page',
			'default'  => 'numeric',
			'priority' => 10,
			'choices'  => array(
				'numeric'   => esc_html__( 'Numeric', 'baroque' ),
				'link'      => esc_html__( 'Link', 'baroque' ),
				'view_more' => esc_html__( 'View More', 'baroque' ),
			),
		),
		'view_more_text'               => array(
			'type'            => 'text',
			'label'           => esc_html__( 'View More Text', 'baroque' ),
			'section'         => 'award_page',
			'default'         => esc_html__( 'MORE', 'baroque' ),
			'priority'        => 10,
			'active_callback' => array(
				array(
					'setting'  => 'type_nav_award',
					'operator' => '==',
					'value'    => 'view_more',
				),
			),
		),
		'view_more_style'              => array(
			'type'            => 'select',
			'label'           => esc_html__( 'Style', 'baroque' ),
			'section'         => 'award_page',
			'default'         => '1',
			'priority'        => 10,
			'choices'         => array(
				'1' => esc_html__( 'Style 1', 'baroque' ),
				'2' => esc_html__( 'Style 2', 'baroque' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'type_nav_award',
					'operator' => '==',
					'value'    => 'view_more',
				),
			),
		),

		// Single Posts
		'single_post_layout_award'           => array(
			'type'        => 'select',
			'label'       => esc_html__( 'Single Post Layout', 'baroque' ),
			'section'     => 'single_post_award',
			'default'     => 'content-sidebar',
			'priority'    => 5,
			'description' => esc_html__( 'Select default sidebar for the single post page.', 'baroque' ),
			'choices'     => array(
				'content-sidebar' => esc_html__( 'Right Sidebar', 'baroque' ),
				'sidebar-content' => esc_html__( 'Left Sidebar', 'baroque' ),
				'full-content'    => esc_html__( 'Full Content', 'baroque' ),
			),
		),
		'show_post_format_award'             => array(
			'type'        => 'toggle',
			'label'       => esc_html__( 'Show Post Format', 'baroque' ),
			'description' => esc_html__( 'Check this option to show post format in the single post page.', 'baroque' ),
			'section'     => 'single_post_award',
			'default'     => 1,
			'priority'    => 10,
		),

		'show_post_social_share_award' => array(
			'type'        => 'toggle',
			'label'       => esc_html__( 'Show Socials Share', 'baroque' ),
			'description' => esc_html__( 'Check this option to show socials share in the single post page.', 'baroque' ),
			'section'     => 'single_post_award',
			'default'     => 0,
			'priority'    => 10,
		),

		'post_socials_share_award'        => array(
			'type'            => 'multicheck',
			'label'           => esc_html__( 'Socials Share', 'baroque' ),
			'section'         => 'single_post_award',
			'default'         => array( 'facebook', 'twitter', 'google', 'tumblr' ),
			'choices'         => array(
				'facebook'  => esc_html__( 'Facebook', 'baroque' ),
				'twitter'   => esc_html__( 'Twitter', 'baroque' ),
				'google'    => esc_html__( 'Google Plus', 'baroque' ),
				'tumblr'    => esc_html__( 'Tumblr', 'baroque' ),
				'pinterest' => esc_html__( 'Pinterest', 'baroque' ),
				'linkedin'  => esc_html__( 'Linkedin', 'baroque' ),
			),
			'priority'        => 10,
			'active_callback' => array(
				array(
					'setting'  => 'show_post_social_share',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		'show_author_box_award'           => array(
			'type'     => 'toggle',
			'label'    => esc_html__( 'Show Author Box', 'baroque' ),
			'section'  => 'single_post_award',
			'default'  => 0,
			'priority' => 10,
		),
		'post_custom_field_2_award'       => array(
			'type'    => 'custom',
			'section' => 'single_post_award',
			'default' => '<hr/>',
		),
		'single_post_col_award'           => array(
			'type'        => 'slider',
			'label'       => esc_html__( 'Single Post Columns', 'baroque' ),
			'description' => esc_html__( 'Set Columns for Header Section, Footer Section and Comment area of Single Post', 'baroque' ),
			'section'     => 'single_post_award',
			'transport'   => 'auto',
			'default'     => 12,
			'choices'     => array(
				'min'  => '1',
				'max'  => '12',
				'step' => '1',
			),
		),
		'single_post_col_offset_award'    => array(
			'type'        => 'slider',
			'label'       => esc_html__( 'Single Post Offset Columns', 'baroque' ),
			'description' => esc_html__( 'Increase the left margin of Header Section, Footer Section and Comment area in Single Post by number columns', 'baroque' ),
			'section'     => 'single_post_award',
			'transport'   => 'auto',
			'default'     => 0,
			'choices'     => array(
				'min'  => '0',
				'max'  => '11',
				'step' => '1',
			),
		),
		'post_custom_field_3_award'       => array(
			'type'    => 'custom',
			'section' => 'single_post_award',
			'default' => '<hr/>',
		),
		'related_posts_award'             => array(
			'type'        => 'toggle',
			'label'       => esc_html__( 'Related Posts', 'baroque' ),
			'section'     => 'single_post_award',
			'description' => esc_html__( 'Check this option to show related posts in the single post page.', 'baroque' ),
			'default'     => 0,
			'priority'    => 20,
		),
		'related_posts_title_award'       => array(
			'type'     => 'text',
			'label'    => esc_html__( 'Related Posts Title', 'baroque' ),
			'section'  => 'single_post_award',
			'default'  => esc_html__( 'POSTS YOU\'D MIGHT LIKE', 'baroque' ),
			'priority' => 20,

			'active_callback' => array(
				array(
					'setting'  => 'related_post',
					'operator' => '==',
					'value'    => true,
				),
			),
		),
		'related_posts_numbers_award'     => array(
			'type'            => 'number',
			'label'           => esc_html__( 'Related Posts Numbers', 'baroque' ),
			'section'         => 'single_post_award',
			'default'         => '2',
			'priority'        => 20,
			'active_callback' => array(
				array(
					'setting'  => 'related_post',
					'operator' => '==',
					'value'    => true,
				),
			),
		),

	);

	$settings['panels']   = apply_filters( 'baroque_customize_panels', $panels );
	$settings['sections'] = apply_filters( 'baroque_customize_sections', $sections );
	$settings['fields']   = apply_filters( 'baroque_customize_fields', $fields );

	return $settings;
}

$baroque_customize = new Baroque_Customize_new( baroque_customize_settings_new() );
