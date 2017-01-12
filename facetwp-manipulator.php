<?php
/*
 * Plugin Name: FacetWP Manipulator
 * Plugin URI: https://cramer.co.za
 * Description: Manipulate FacetWP easily by applying custom code to FacetWP Hooks.
 * Version: 1.0.0
 * Author: David Cramer
 * Author URI: https://cramer.co.za
 * Text Domain: facetwp-manipulator
 * License: GPL2+
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Constants
define( 'FWPMANIP_PATH', plugin_dir_path( __FILE__ ) );
define( 'FWPMANIP_CORE', __FILE__ );
define( 'FWPMANIP_URL', plugin_dir_url( __FILE__ ) );
define( 'FWPMANIP_VER', '1.0.0' );

if ( ! version_compare( PHP_VERSION, '5.3.0', '>=' ) ) {
	if ( is_admin() ) {
		add_action( 'admin_notices', 'fwpmanip_php_ver' );
	}
} else {
	//Includes and run
	include_once FWPMANIP_PATH . 'fwpmanip-bootstrap.php';
	include_once FWPMANIP_PATH . 'classes/fwpmanip.php';
}

function fwpmanip_php_ver() {
	$message = __( 'FacetWP Manipulator requires PHP version 5.3 or later. We strongly recommend PHP 5.5 or later for security and performance reasons.', 'facetwp-minipulator' );
	echo '<div id="fwpmanip_error" class="error notice notice-error"><p>' . $message . '</p></div>';
}


add_filter( 'facetwp_map_marker_args', function ( $args ) {
	if( $args['title'] == ' Kfc' ) {
		$args['icon'] = 'https://upload.wikimedia.org/wikipedia/en/thumb/b/bf/KFC_logo.svg/40px-KFC_logo.svg.png';
	}
	if( $args['title'] == ' Spur' ){
		$args['icon'] = 'https://upload.wikimedia.org/wikipedia/en/thumb/3/39/Spur_Steak_Ranch_logo.png/50px-Spur_Steak_Ranch_logo.png';
	}
	if( $args['title'] == " Nando's" ){
		$args['icon'] = 'https://upload.wikimedia.org/wikipedia/en/thumb/c/c5/Nandos_logo.svg/50px-Nandos_logo.svg.png';
	}


	return $args;
} );
