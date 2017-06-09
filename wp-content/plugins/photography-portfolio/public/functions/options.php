<?php


/**
 * Easy way to get option values
 *
 * @param      $option
 * @param null $default @deprecated
 *
 * @return mixed|null
 */
function phort_get_option( $option, $deprecated = '' ) {

	$default    = '';
	$_undefined = '[undefined]';


	/**
	 * @deprecated at 1.1.4
	 * @todo       Remove at 1.2.0
	 */
	if ( ! empty( $deprecated ) ) {
		// Never implemented
		_deprecated_argument( __FUNCTION__, '1.1.4' );
	}

	/**
	 * Priority #1: `apply_filters()`
	 * Allow quick override through WP Filters
	 *
	 * Filters have been touched if `apply_filters()` returns anything else than `[undefined]`
	 * In that case, return that value
	 */
	$value = apply_filters( 'phort_option_' . $option, $_undefined );
	if ( $value !== $_undefined ) {
		return $value;
	}


	/**
	 * Setup the default value
	 */
	$setting = phort_instance()->settings->get( $option );
	if ( isset( $setting['default'] ) ) {
		$default = $setting['default'];
	}


	/**
	 * Priority #2: `get_post_meta()`
	 * Get `$option` from post meta
	 */
	if ( in_the_loop() ) {
		$value = get_post_meta( get_the_ID(), 'phort_' . $option, true );

		if ( $value && $value !== $default ) {
			return $value;
		}
	}

	/**
	 * Priority #3: `cmb2_get_option()`
	 * Get the global option from wordpress options
	 */
	$options = get_option( 'phort_options' );
	if ( isset( $options[ $option ] ) ) {
		$value = $options[ $option ];
	}

	if ( $value === $_undefined ) {
		return $default;
	}

	return $value;
}


function phort_set_option( $option, $value ) {

	$options = get_option( 'phort_options' );
	if ( ! $options || ! is_array( $options ) ) {
		$options = [];
	}

	$options[ $option ] = $value;

	update_option( 'phort_options', $options );
}


/**
 * Make it easy for themes and/or extensions to set their own defaults.
 * For example, if a new layout is added and prefered as the default.
 *
 * @see https://github.com/justnorris/easy-photography-portfolio/wiki#change-the-defaults
 *
 * @param array $defaults - An array of key => value pairs to customize the defaults
 */
function phort_set_defaults( $defaults ) {

	$phort_settings = phort_instance()->settings;

	foreach ( $defaults as $option_id => $value ) {

		// Validate that an option exists, before trying to set the default value
		if ( defined( "WP_DEBUG" ) && WP_DEBUG && ! $phort_settings->exists( $option_id ) ) {
			trigger_error( "Trying to set a default for {$option_id}, but there is no such option in the registry" );
			continue;
		}

		$option            = $phort_settings->get( $option_id );
		$option['default'] = $value;

		$phort_settings->update( $option );

	}


}




