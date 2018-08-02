<?php
/**
 * Functions for ACF
 */

/**
 * Hide ACF from admin menu, just for safety
 */
add_filter( 'acf/settings/show_admin', '__return_false' );

/**
 * Load all the ACF options from this file
 */
require_once( get_template_directory() . '/inc/acf-fields.php' );


/**
 * Fix if ACF is not activated after theme install
 * No function prefixing here because ACF get_field function
 */
if ( ! is_admin() && ! function_exists( 'get_field' ) ) {
    function get_field( $key ) {
        return get_post_meta( get_the_ID(), $key, true );
    }
    function have_rows( $value = false ) {
    	return false;
	}
}

/**
 * Remove the notification when a update is available for ACF PRO
 * updates will be shipped within theme updates because it's a premium plugin
 */
if ( ! function_exists( 'thelandscaper_hide_acf_update_notifications' ) ) {
	function thelandscaper_hide_acf_update_notifications( $value ) {
		if ( isset( $value ) && is_object( $value ) ) {
			unset( $value->response[ 'advanced-custom-fields-pro/acf.php' ] );
		}
		return $value;
	}
	add_filter( 'site_transient_update_plugins', 'thelandscaper_hide_acf_update_notifications' );
}