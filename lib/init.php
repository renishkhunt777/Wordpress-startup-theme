<?php
/**
 * Matword theme init setup
 *
 * @package Matword
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 900; /* pixels */
}

if ( ! function_exists( 'matword_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function matword_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on matwordtheme, use a find and replace
	 * to change 'matwordtheme' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'matwordtheme', get_template_directory() . '/languages' );

	// Clean up the head
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Register nav menus
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'matwordtheme' ),
	) );

	// Register Widget Areas
	// Function location: /lib/theme-functions.php
	add_action( 'widgets_init', 'matword_widgets_init' );

	// Execute shortcodes in widgets
	// add_filter('widget_text', 'do_shortcode');

	// Add Editor Style
	add_editor_style();

	// Prevent File Modifications
	if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
		define( 'DISALLOW_FILE_EDIT', true );
	}

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	// Add Image Sizes
	// add_image_size( $name, $width = 0, $height = 0, $crop = false );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'matwordtheme_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Remove Dashboard Meta Boxes
	// Function location: /lib/theme-functions.php
	add_action( 'wp_dashboard_setup', 'matword_remove_dashboard_widgets' );

	// Change Admin Menu Order
	// Function location: /lib/theme-functions.php
	add_filter( 'custom_menu_order', '__return_true' );
	add_filter( 'menu_order', 'matword_custom_menu_order' );

	// Hide Admin Areas that are not used
	// Function location: /lib/theme-functions.php
	add_action( 'admin_menu', 'matword_remove_menu_pages' );

	// Remove default link for images
	// Function location: /lib/theme-functions.php
	add_action( 'admin_init', 'matword_imagelink_setup', 10 );

	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Enqueue scripts
	// Function location: /lib/theme-functions.php
	add_action( 'wp_enqueue_scripts', 'matword_scripts' );

	// Remove Query Strings From Static Resources
	// Function location: /lib/theme-functions.php
	add_filter( 'script_loader_src', 'matword_remove_script_version', 15, 1 );
	add_filter( 'style_loader_src', 'matword_remove_script_version', 15, 1 );

	// Remove Read More Jump
	// Function location: /lib/theme-functions.php
	add_filter( 'the_content_more_link', 'matword_remove_more_jump_link' );

	// set a limit of character to display in listing
	add_filter("the_content", "plugin_myContentFilter");
}
endif; // matword_setup

add_action( 'after_setup_theme', 'matword_setup' );