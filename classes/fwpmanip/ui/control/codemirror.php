<?php
/**
 * FWPMANIP Controls
 *
 * @package   controls
 * @author    David Cramer
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 David Cramer
 */
namespace fwpmanip\ui\control;

/**
 * textarea / paragraph input
 *
 * @since 1.0.0
 */
class codemirror extends \fwpmanip\ui\control\textarea {

	/**
	 * The type of object
	 *
	 * @since       1.0.0
	 * @access public
	 * @var         string
	 */
	public $type = 'codemirror';

	/**
	 * Gets the attributes for the control.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function set_attributes() {

		parent::set_attributes();
		$this->attributes['rows']  = '5';
		$this->attributes['class'] = 'codemirror-editor';

		if ( ! empty( $this->struct['rows'] ) ) {
			$this->attributes['rows'] = $this->struct['rows'];
		}

	}

	/**
	 * Define styles and Scripts
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function set_assets() {

		// Initilize core styles
		$this->assets['style']['codemirror-control'] = $this->url . 'assets/controls/codemirror/codemirror' . FWPMANIP_ASSET_DEBUG . '.css';

		// Initilize core scripts
		$this->assets['script']['codemirror-control'] = $this->url . 'assets/controls/codemirror/codemirror' . FWPMANIP_ASSET_DEBUG . '.js';
		$this->assets['script']['codemirror-clike']   = $this->url . 'assets/controls/codemirror/clike/clike' . FWPMANIP_ASSET_DEBUG . '.js';
		$this->assets['script']['codemirror-php']     = $this->url . 'assets/controls/codemirror/php/php' . FWPMANIP_ASSET_DEBUG . '.js';
		$this->assets['script']['codemirror-init']    = $this->url . 'assets/controls/codemirror/codemirror-init' . FWPMANIP_ASSET_DEBUG . '.js';

		parent::set_assets();
	}

	/**
	 * Returns the main input field for rendering
	 *
	 * @since 1.0.0
	 * @see \fwpmanip\ui\fwpmanip
	 * @access public
	 * @return string
	 */
	public function input() {

		return '<textarea ' . $this->build_attributes() . '>' . esc_textarea( $this->get_value() ) . '</textarea>';
	}

}
