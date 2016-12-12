<?php
/**
 * FWPMANIP Helper Functions
 *
 * @package   fwpmanip
 * @author    David Cramer
 * @license   GPL-2.0+
 * @copyright 2016 David Cramer
 */


/**
 * FWPMANIP Object class autoloader.
 * It locates and finds class via classes folder structure.
 *
 * @since 1.0.0
 *
 * @param string $class class name to be checked and autoloaded
 */
function fwpmanip_autoload_class( $class ) {
	$parts = explode( '\\', $class );
	$name  = array_shift( $parts );
	if ( file_exists( FWPMANIP_PATH . 'classes/' . $name ) ) {
		if ( ! empty( $parts ) ) {
			$name .= '/' . implode( '/', $parts );
		}
		$class_file = FWPMANIP_PATH . 'classes/' . $name . '.php';
		if ( file_exists( $class_file ) ) {
			include_once $class_file;
		}
	}
}

/**
 * FWPMANIP Helper to minipulate the overall UI instance.
 *
 * @since 1.0.0
 */
function fwpmanip() {
	$request_data = array(
		'post'    => $_POST,
		'get'     => $_GET,
		'files'   => $_FILES,
		'request' => $_REQUEST,
		'server'  => $_SERVER,
	);

	// init UI
	return \fwpmanip\ui::get_instance( $request_data );
}

/**
 * FWPMANIP Helper to minipulate the overall UI instance.
 *
 * @since 1.0.0
 */
function fwpmanip_share() {
	// init UI
	return \fwpmanip\share\share::get_instance();
}

