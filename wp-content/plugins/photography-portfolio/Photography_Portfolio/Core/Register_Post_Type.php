<?php


namespace Photography_Portfolio\Core;


class Register_Post_Type {


	public static function initialize() {


		/**
		 * Turns out taxonomies have to be registered before the
		 * post type is registered to get pretty URLs like `/portfolio/category/%cat`
		 *
		 * @link https://cnpagency.com/blog/the-right-way-to-do-wordpress-custom-taxonomy-rewrites/
		 *
		 * `add_action` order is improtant here:
		 */
		add_action( 'init', [ __CLASS__, 'register_taxonomy' ], 5 );
		add_action( 'init', [ __CLASS__, 'register_post_type' ], 5 );

	}


	public static function register_post_type() {

		$labels = apply_filters(
			'phort/post_type/labels',
			[
				'name'               => _x( 'Portfolio Entries', 'Post Type General Name', 'phort-plugin' ),
				'singular_name'      => _x( 'Portfolio Entry', 'Post Type Singular Name', 'phort-plugin' ),
				'menu_name'          => __( 'Portfolio', 'phort-plugin' ),
				'parent_item_colon'  => __( 'Parent Entry', 'phort-plugin' ),
				'all_items'          => __( 'All Entries', 'phort-plugin' ),
				'view_item'          => __( 'View Entries', 'phort-plugin' ),
				'add_new_item'       => __( 'Add New Portfolio  Entry', 'phort-plugin' ),
				'add_new'            => __( 'New Portfolio  Entry', 'phort-plugin' ),
				'edit_item'          => __( 'Edit Portfolio Entry', 'phort-plugin' ),
				'update_item'        => __( 'Update Entry', 'phort-plugin' ),
				'search_items'       => __( 'Search portfolio', 'phort-plugin' ),
				'not_found'          => __( 'No portfolio entries found', 'phort-plugin' ),
				'not_found_in_trash' => __( 'No portfolio entries found in Trash', 'phort-plugin' ),
			]
		);

		$args = apply_filters(
			'phort/post_type/args',
			[
				'label'               => __( 'portfolio', 'phort-plugin' ),
				'description'         => __( 'Portfolio', 'phort-plugin' ),
				'labels'              => $labels,
				'supports'            => [ 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ],
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_nav_menus'   => true,
				'show_in_admin_bar'   => true,
				'menu_position'       => 5,
				'menu_icon'           => 'dashicons-portfolio',
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'post',
				'rewrite'             => [ 'slug' => 'portfolio' ],

			]
		);


		register_post_type( 'phort_post', $args );
	}


	public static function register_taxonomy() {

		$labels = apply_filters(
			'phort/taxonomy/labels',
			[
				'name'                       => _x( 'Portfolio Categories', 'Taxonomy General Name', 'phort-plugin' ),
				'singular_name'              => _x( 'Portfolio Category', 'Taxonomy Singular Name', 'phort-plugin' ),
				'menu_name'                  => __( 'Categories', 'phort-plugin' ),
				'all_items'                  => __( 'All Categories', 'phort-plugin' ),
				'parent_item'                => __( 'Parent Category', 'phort-plugin' ),
				'parent_item_colon'          => __( 'Parent Category:', 'phort-plugin' ),
				'new_item_name'              => __( 'New Category Name', 'phort-plugin' ),
				'add_new_item'               => __( 'Add New Category', 'phort-plugin' ),
				'edit_item'                  => __( 'Edit Category', 'phort-plugin' ),
				'update_item'                => __( 'Update Category', 'phort-plugin' ),
				'separate_items_with_commas' => __( 'Separate categories with commas', 'phort-plugin' ),
				'search_items'               => __( 'Search Portfolio categories', 'phort-plugin' ),
				'add_or_remove_items'        => __( 'Add or remove categories', 'phort-plugin' ),
				'choose_from_most_used'      => __( 'Choose from the most used categories', 'phort-plugin' ),
			]
		);

		$args = apply_filters(
			'phort/taxonomy/args',
			[
				'labels'            => $labels,
				'hierarchical'      => true,
				'public'            => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_nav_menus' => true,
				'show_tagcloud'     => false,
				'rewrite'           => [
					'slug'       => 'portfolio/category',
					'with_front' => false,
				],
			]
		);


		register_taxonomy( 'phort_post_category', 'phort_post', $args );

	}


}