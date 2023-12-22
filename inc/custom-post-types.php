<?php

/**
 * Register template CPT
 */
function authlab_templates_cpt() {
	$args = array(
		'label'               => __( 'Templates', 'authlab-kadence-child' ),
		'labels'              => array(
			'name'          => __( 'Templates', 'authlab-kadence-child' ),
			'singular_name' => __( 'Template', 'authlab-kadence-child' ),
		),
		'menu_icon'           => 'dashicons-layout',
		'supports'            => array( 'title', 'editor' ),
		'public'              => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'show_in_rest'        => true,
		'capability_type'     => 'post',
		'rewrite'             => array( 'slug' => 'authlab_templates' ),
	);

	register_post_type( 'authlab_templates', $args );
}

add_action( 'init', 'authlab_templates_cpt' );

/**
 * Register integration CPT
 */
function authlab_integration_cpt() {
	$args = array(
		'label'               => __( 'Integration', 'authlab-kadence-child' ),
		'description'         => __( 'Integrations custom post type', 'authlab-kadence-child' ),
		'labels'              => array(
			'name'                  => __( 'Integrations', 'authlab-kadence-child' ),
			'singular_name'         => __( 'Integration', 'authlab-kadence-child' ),
			'featured_image'        => __( 'Integration icon', 'authlab-kadence-child' ),
			'set_featured_image'    => __( 'Set integration icon', 'authlab-kadence-child' ),
			'remove_featured_image' => __( 'Remove integration icon', 'authlab-kadence-child' ),
			'use_featured_image'    => __( 'Use as integration icon', 'authlab-kadence-child' ),
		),
		'menu_icon'           => 'dashicons-editor-justify',
		'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'public'              => true,
		'hierarchical'        => false,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'capability_type'     => 'post',
		'rewrite'             => array( 'slug' => 'integrations' ),
	);

	register_post_type( 'authlab_integration', $args );
}

add_action( 'init', 'authlab_integration_cpt' );

/**
 * Register integration Taxonomy
 */
function authlab_integration_taxonomy() {
	$args = array(
		'hierarchical'      => true,
		'labels'            => array(
			'name'          => __( 'Category', 'authlab-kadence-child' ),
			'singular_name' => __( 'Category', 'authlab-kadence-child' ),
		),
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'integrations-category' ),
	);
	register_taxonomy( 'integration_category', array( 'authlab_integration' ), $args );
}

add_action( 'init', 'authlab_integration_taxonomy' );

/**
 * Register FAQ CPT
 */
function authlab_faq_cpt() {
	$args = array(
		'label'               => __( 'Faqs', 'authlab-kadence-child' ),
		'description'         => __( 'Faqs custom post type', 'authlab-kadence-child' ),
		'labels'              => array(
			'name'               => __( 'Faqs', 'authlab-kadence-child' ),
			'singular_name'      => __( 'Faq', 'authlab-kadence-child' ),
			'use_featured_image' => __( 'Use as faqs icon', 'authlab-kadence-child' ),
		),
		'menu_icon'           => 'dashicons-list-view',
		'supports'            => array( 'title', 'editor' ),
		'public'              => true,
		'hierarchical'        => false,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'capability_type'     => 'post',
		'rewrite'             => array( 'slug' => 'faqs' ),
	);

	register_post_type( 'authlab_faq', $args );
}

add_action( 'init', 'authlab_faq_cpt' );

/**
 * Register FAQ Taxonomy
 */
function authlab_faq_taxonomy() {
	$args = array(
		'hierarchical'      => true,
		'labels'            => array(
			'name'          => __( 'Category', 'authlab-kadence-child' ),
			'singular_name' => __( 'Category', 'authlab-kadence-child' ),
		),
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'faq-category' ),
	);
	register_taxonomy( 'faq_category', array( 'authlab_faq' ), $args );
}

add_action( 'init', 'authlab_faq_taxonomy' );
