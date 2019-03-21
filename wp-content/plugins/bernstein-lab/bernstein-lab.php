<?php
/**
 * Plugin Name:     Bernstein Lab
 * Description:     Custom plugin for Bernstein Lab
 * Author:          Charles Bent, SYP Development
 * Author URI:      https://www.sypdevelopment.com
 * Text Domain:     bernstein-lab
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Bernstein_Lab
 */

add_action( 'init', 'research_post_type' );
add_action( 'init', 'people_post_type' );

/**
 * Research Project Post Type
 */
function research_post_type() {
	register_post_type( 'research',
		array(
			'labels'       => array(
				'name'          => __( 'Research Projects' ),
				'singular_name' => __( 'Research' )
			),
			'public'       => TRUE,
			'has_archive'  => FALSE,
			'rewrite'      => array( 'slug' => 'research', 'with_front' => TRUE ),
			'hierarchical' => TRUE,
			'supports'     => array(
				'title',
				'author',
				'custom-fields',
				'editor',
				'page-attributes',
				'thumbnail'
			),
			'not-found'    => __( 'Nothing was found. what to do?' ),
			'menu_icon'    => 'dashicons-portfolio'
		)
	);
}

/**
 * People Post Type
 */
function people_post_type() {
	register_post_type( 'people',
		array(
			'labels'       => array(
				'name'          => __( 'People' ),
				'singular_name' => __( 'People' )
			),
			'public'       => TRUE,
			'has_archive'  => TRUE,
			'rewrite'      => array( 'slug' => 'people', 'with_front' => FALSE ),
			'hierarchical' => TRUE,
			'supports'     => array(
				'title',
				'author',
				'custom-fields',
				'editor',
				'thumbnail'
			),
			'not-found'    => __( 'Nothing was found. what to do?' ),
			'menu_icon'    => 'dashicons-groups'
		)
	);
}