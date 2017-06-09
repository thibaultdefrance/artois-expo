<?php


namespace Photography_Portfolio\Settings;


class PP_Post_Meta {


	/**
	 * PP_Post_Meta constructor.
	 */
	public function __construct() {

		add_action( 'cmb2_init', [ $this, 'before_content' ] );
		add_action( 'cmb2_init', [ $this, 'after_content' ] );

		/**
		 * CMB2 supports `after_title` since version 2.2.4
		 * But this way is still prettier for the user:
		 */
		add_action( 'edit_form_after_title', [ $this, 'move_metabox_to_after_title' ] );


	}


	/**
	 * Display checkbox metabox below title field
	 * @link https://github.com/WordPress/WordPress/blob/56d6682461be82da1a3bafc454dad2c9da451a38/wp-admin/edit-form-advanced.php#L517-L523
	 */
	public function move_metabox_to_after_title() {

		$cmb = cmb2_get_metabox( 'phort_post_before_meta' );
		if ( in_array( get_post_type(), $cmb->prop( 'object_types' ), 1 ) ) {
			$this->wrapper_open();
			$cmb->show_form();
			$this->wrapper_close();
		}
	}


	public function wrapper_open() {

		echo '
		<div class="PPA_Metabox PPA_Metabox--bc">
		';
	}


	public function wrapper_close() {

		echo '
			</div> <!-- .PPA_Metabox -->
			';
	}


	public function before_content() {

		$cmb = new_cmb2_box(
			array(
				'id'           => 'phort_post_before_meta',
				'object_types' => [ 'phort_post' ],
				'show_names'   => true,
				'context'      => 'normal',
				'priority'     => 'high',
			)
		);

		$cmb->add_field(
			array(

				'desc'  => '',
				'name'  => esc_html__( 'Entry Subtitle', 'phort-plugin' ),
				'title' => 'Portfolio',
				'id'    => 'phort_subtitle',
				'type'  => 'text',
			)
		);


		// Allow metabox extension
		do_action( 'phort/meta/before_content', $cmb );
	}


	public function after_content() {

		$cmb = new_cmb2_box(
			array(
				'id'           => 'phort_post_after_meta',
				'title'        => __( 'Photography Portfolio', 'phort-plugin' ),
				'object_types' => [ 'phort_post' ],
				'context'      => 'normal',
				'priority'     => 'high',
			)
		);

		$cmb->add_field(
			array(

				'desc'         => '',
				'id'           => 'phort_gallery',
				'type'         => 'file_list',
				'preview_size' => [ 125, 125, true ], // Default: [50,50]
				// Optional, override default text strings
				'text'         => [
					'add_upload_files_text' => esc_html__( 'Add Images', 'phort-plugin' ),
					'remove_image_text'     => esc_html__( 'Remove Image', 'phort-plugin' ),
					'file_text'             => esc_html__( 'File:', 'phort-plugin' ),
					'file_download_text'    => esc_html__( 'Download', 'phort-plugin' ),
					'remove_text'           => esc_html__( 'Remove', 'phort-plugin' ),
				],
			)
		);


		// Allow metabox extension
		do_action( 'phort/meta/after_content', $cmb );
	}
}