<?php
/**
 * Susty Child WP functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package susty-child
 */

// Ensure both parent and child theme are included

function susty_child_enqueue_styles() {
 
    $parent_style = 'parent-style';
 
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}

add_action( 'wp_enqueue_scripts', 'susty_child_enqueue_styles' );

// Dequeue Jetpack scripts
 
function susty_child_dequeues() {

	wp_dequeue_script( 'devicepx' );

}

add_action( 'wp_enqueue_scripts', 'susty_child_dequeues' );

add_filter( 'jetpack_implode_frontend_css', '__return_false', 99 ); // This *may* be needed for Jetpack's Gutenberg blocks

// Add native lazy loading

function susty_child_add_lazyload( $content ) {

	$content = str_replace( '<img ', '<img loading="lazy" ', $content );
	$content = str_replace( '<iframe ', '<iframe loading="lazy" ', $content );

	return $content;
}

add_filter( 'the_content', 'susty_child_add_lazyload' );

// If just one post in result just show it - this removes a redundant page load from the search process

function susty_child_single_result() {

	if ( is_search() ) {
		global $wp_query;
		if ( 1 === $wp_query->post_count && 1 === $wp_query->max_num_pages ) {
			wp_safe_redirect( get_permalink( $wp_query->posts[ 0 ]->ID ) );
			exit;
		}
	}
}

add_action( 'template_redirect', 'susty_child_single_result' );

// Add a search box to the primary menu

function add_search_box( $items, $args ) {

	if( $args->theme_location === 'menu-1' ){
		$items = '<li class="searchbox-position">' . get_search_form( false ) . '</li>' . $items;
	}

	return $items;
}

add_filter( 'wp_nav_menu_items', 'add_search_box', 10, 2 );

// Remove core Emoji support.

remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
add_filter( 'emoji_svg_url', '__return_false' );