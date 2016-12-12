<?php
/**
 * FWPMANIP Bootstrapper
 *
 * @package   fwpmanip
 * @author    David Cramer
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 David Cramer
 *
 */
// If this file is called directly, abort.
if ( defined( 'WPINC' ) ) {

	if ( ! defined( 'FWPMANIP_ASSET_DEBUG' ) ) {
		if ( ! defined( 'DEBUG_SCRIPTS' ) ) {
			define( 'FWPMANIP_ASSET_DEBUG', '.min' );
		} else {
			define( 'FWPMANIP_ASSET_DEBUG', '' );
		}
	}


	// include fwpmanip helper functions and autoloader.
	require_once( FWPMANIP_PATH . 'includes/functions.php' );

	// register fwpmanip autoloader
	spl_autoload_register( 'fwpmanip_autoload_class', true, false );

	// bootstrap plugin load
	add_action( 'plugins_loaded', 'fwpmanip' );

}
