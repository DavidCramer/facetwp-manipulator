<?php

/**
 * FacetWP_Manipulator Main Class
 *
 * @package   fwpmanip
 * @author    David Cramer
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 David Cramer
 */
class FacetWP_Manipulator {

	/**
	 * Holds instance of the class
	 *
	 * @since   1.0.0
	 *
	 * @var     FacetWP_Manipulator
	 */
	private static $instance;

	/**
	 * Holds the admin page object
	 *
	 * @since   1.0.0
	 *
	 * @var     \fwpmanip\ui\page
	 */
	private $admin_page;

	/**
	 * Holds the code to run for each hook
	 *
	 * @since   1.0.0
	 *
	 * @var     array
	 */
	private $hooks;

	/**
	 * FacetWP_Manipulator constructor.
	 */
	public function __construct() {

		// create admin objects
		add_action( 'plugins_loaded', array( $this, 'register_admin' ) );
		// setup notifications
		add_action( 'init', array( $this, 'setup' ) );
		// add required fields check
		add_action( 'fwpmanip_control_item_submit_hooks', array( $this, 'verify_config' ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return  FacetWP_Manipulator  A single instance
	 */
	public static function init() {

		// If the single instance hasn't been set, set it now.
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;

	}

	/**
	 * Verifies required fields are entered when adding an event notifier
	 *
	 * @since 1.0.0
	 *
	 */
	public function verify_config( $data ) {

		$message = array();
		// check if a hook is set.
		if ( empty( $data['general']['event'] ) ) {
			$message[] = __( 'Please select a Filter.', 'facetwp-manipulator' );
		}
		// check for some code
		if ( empty( $data['general']['code'] ) ) {
			$message[] = __( 'You need to have some code to run.', 'facetwp-manipulator' );
		}
		// remove empty
		$message = array_filter( $message );

		if ( ! empty( $message ) ) {
			wp_send_json_error( implode( '<br>', $message ) );
		}


	}

	/**
	 * Register the admin pages
	 *
	 * @since 1.0.0
	 */
	public function register_admin() {

		$this->admin_page = fwpmanip()->add( 'page', 'facetwp-manipulator', $this->admin_core_page() );

	}

	/**
	 * @return fwpmanip
	 *
	 * @since 1.0.0
	 */
	public function admin_core_page() {

		$structure = array(
			'page_title' => __( 'FacetWP Manipulator', 'facetwp-manipulator' ),
			'menu_title' => __( 'FWP Manipulator', 'facetwp-manipulator' ),
			'base_color' => '#906dbe',
			'parent'     => 'options-general.php',
			'full_width' => true,
			'attributes' => array(
				'data-autosave' => true,
			),
			'header'     => array(
				'id'          => 'admin_header',
				'label'       => __( 'FacetWP Manipulator', 'facetwp-manipulator' ),
				'description' => __( '1.0.0', 'facetwp-manipulator' ),
				'control'     => array(
					array(
						'type' => 'separator',
					),
				),
				'modal'       => array(
					'id'          => 'about',
					'label'       => __( 'About', 'facetwp-manipulator' ),
					'description' => __( 'FacetWP Manipulator', 'facetwp-manipulator' ),
					'width'       => 450,
					'height'      => 550,
					'attributes'  => array(
						'class' => 'page-title-action',
					),
					'top_tabs'    => true,
					'section'     => array(
						'about' => array(
							'label'   => __( 'FacetWP Manipulator', 'facetwp-manipulator' ),
							'control' => array(
								'about_text' => array(
									'type'     => 'template',
									'template' => FWPMANIP_PATH . 'includes/about-template.php',
								),
							),
						),
					),
				),
			),
			'style'      => array(
				'admin' => FWPMANIP_URL . 'assets/css/admin.css',
				'prism' => FWPMANIP_URL . 'assets/css/prism.css',
			),
			'script'     => array(
				'admin' => FWPMANIP_URL . 'assets/js/admin.js',
				'prism' => FWPMANIP_URL . 'assets/js/prism.js',
			),
			'control'    => array(
				'hooks' => array(
					'label'  => __( 'Add Item', 'facetwp-manipulator' ),
					'type'   => 'item',
					'config' => array(
						'label'       => __( 'Create New Manipulator', 'facetwp-manipulator' ),
						'description' => __( 'Configure Manipulator', 'facetwp-manipulator' ),
						'width'       => 780,
						'height'      => 692,
						'template'    => FWPMANIP_PATH . 'includes/admin-template.php',
						'top_tabs'    => true,
						'section'     => array(
							'general' => include FWPMANIP_PATH . 'includes/general-config.php',
						),
						'footer'      => array(
							'id'      => 'status',
							'control' => array(
								'add_item'    => array(
									'label'      => __( 'Create Manipulator', 'facetwp-manipulator' ),
									'type'       => 'button',
									'attributes' => array(
										'type'       => 'submit',
										'data-state' => 'add',
									),
								),
								'update_item' => array(
									'label'      => __( 'Update Manipulator', 'facetwp-manipulator' ),
									'type'       => 'button',
									'attributes' => array(
										'type'       => 'submit',
										'data-state' => 'update',
									),
								),
							),
						),
					),
				),
			),
			'template'   => FWPMANIP_PATH . 'includes/hook-samples.php',
		);

		return $structure;
	}


	/**
	 * Setup hooks
	 *
	 * @since 1.0.0
	 */
	public function setup() {

		$data = $this->admin_page->load_data();
		if ( empty( $data['hooks'] ) ) {
			return;
		}
		$hooks = json_decode( $data['hooks'], ARRAY_A );
		foreach ( $hooks as $hook ) {
			$this->hooks[ $hook['general']['event'] ][] = $hook['general']['code'];
			add_filter( $hook['general']['event'], array( $this, $hook['general']['event'] ), 10, 10 );
		}
	}

	/**
	 * handles the hooks call
	 *
	 * @since 1.0.0
	 */
	public function __call( $hook, $arguments ) {

		$arg_set = $this->argument_sets( $hook, $arguments );
		$keys    = array_keys( $arg_set );
		extract( $arg_set );
		foreach ( $this->hooks[ $hook ] as $manipulator ) {
			$$keys[0] = eval( $manipulator );
		}

		return $$keys[0];
	}

	/**
	 * Builds the argument names as per facetwp docs.
	 *
	 * @since 1.0.0
	 */
	private function argument_sets( $hook, $arguments ) {
		switch ( $hook ) {
			case 'facetwp_index_row':
				$set = array(
					'params' => $arguments[0],
					'class'  => $arguments[1],
				);
				break;
			case 'facetwp_indexer_query_args';
			case 'facetwp_facet_render_args':
				$set = array(
					'args' => $arguments[0],
				);
				break;
			case 'facetwp_query_args':
				$set = array(
					'query_args' => $arguments[0],
					'class'      => $arguments[1],
				);
				break;
			case 'facetwp_pre_filtered_post_ids';
			case 'facetwp_filtered_post_ids':
				$set = array(
					'post_ids' => $arguments[0],
					'class'    => $arguments[1],
				);
				break;
			case 'facetwp_facet_orderby':
				$set = array(
					'orderby' => $arguments[0],
					'facet'   => $arguments[1],
				);
				break;
			case 'facetwp_facet_filter_posts':
				$set = array(
					'return' => $arguments[0],
					'params' => $arguments[1],
				);
				break;
			case 'facetwp_is_main_query':
				$set = array(
					'is_main_query' => $arguments[0],
					'query'         => $arguments[1],
				);
				break;
			case 'facetwp_template_use_archive':
				$set = array(
					'use_archive' => $arguments[0],
				);
				break;
			case 'facetwp_facet_html';
			case 'facetwp_pager_html';
			case 'facetwp_result_count';
			case 'facetwp_render_output';
				$set = array(
					'output' => $arguments[0],
					'params' => $arguments[1],
				);
				break;
			case 'facetwp_template_html':
				$set = array(
					'output' => $arguments[0],
					'class'  => $arguments[1],
				);
				break;
			case 'facetwp_per_page_options':
				$set = array(
					'options' => $arguments[0],
				);
				break;
			case 'facetwp_sort_options':
				$set = array(
					'options' => $arguments[0],
					'params'  => $arguments[1],
				);
				break;
			case 'facetwp_sort_html':
				$set = array(
					'html'   => $arguments[0],
					'params' => $arguments[1],
				);
				break;
			case 'facetwp_sort_html':
				$set = array(
					'html'   => $arguments[0],
					'params' => $arguments[1],
				);
				break;
			case 'facetwp_assets';
				$set = array(
					'assets' => $arguments[0],
				);
				break;
			case 'facetwp_facet_types';
				$set = array(
					'facet_types' => $arguments[0],
				);
				break;
			case 'facetwp_facet_sources';
				$set = array(
					'sources' => $arguments[0],
				);
				break;
			case 'facetwp_facets';
				$set = array(
					'facets' => $arguments[0],
				);
				break;
			case 'facetwp_i18n':
				$set = array(
					'string' => $arguments[0],
				);
				break;
			case 'facetwp_proximity_autocomplete_options':
				$set = array(
					'options' => $arguments[0],
				);
				break;

			default:
				$set = $arguments;
				break;
		}

		return $set;
	}

}

// init
FacetWP_Manipulator::init();
