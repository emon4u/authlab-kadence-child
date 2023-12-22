<?php
/**
 * Enqueue child styles.
 */
function authlab_kadence_child_styles() {
	wp_enqueue_script( 'isotope', get_stylesheet_directory_uri() . '/assets/js/isotope.pkgd.min.js', array( 'jquery' ),
		'3.0.6' );
	wp_enqueue_script( 'authlab-kadence-js', get_stylesheet_directory_uri() . '/assets/js/child-theme-scripts.js',
		array( 'jquery', 'isotope' ), time() );
	wp_enqueue_style( 'authlab-kadence-css', get_stylesheet_directory_uri() . '/style.css', array(), time() );
}

add_action( 'wp_enqueue_scripts', 'authlab_kadence_child_styles', 99 );
add_action( 'enqueue_block_editor_assets', 'authlab_kadence_child_styles' );

require get_stylesheet_directory() . '/inc/custom-post-types.php';
require get_stylesheet_directory() . '/inc/meta-boxes.php';
require get_stylesheet_directory() . '/inc/frontend.php';
