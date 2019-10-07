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

// Add a search box to the primary menu

function add_search_box( $items, $args ) {

	if( $args->theme_location === 'menu-1' ){
		$items = '<li class="searchbox-position">' . get_search_form( false ) . '</li>' . $items;
	}

	return $items;
}

add_filter( 'wp_nav_menu_items', 'add_search_box', 10, 2 );
