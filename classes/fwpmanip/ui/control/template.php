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
 * Template file include. for including custom control html/php
 *
 * @since 1.0.0
 */
class template extends \fwpmanip\ui\control {

	/**
	 * The type of object
	 *
	 * @since       1.0.0
	 * @access public
	 * @var         string
	 */
	public $type = 'template';

	/**
	 * Render the Control
	 *
	 * @since 1.0.0
	 * @see \fwpmanip\ui\fwpmanip
	 * @access public
	 * @return string HTML of rendered control
	 */
	public function render() {

		$output = $this->input();

		return $output;
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
		$output = null;
		if ( ! empty( $this->struct['template'] ) && file_exists( $this->struct['template'] ) ) {
			ob_start();
			include $this->struct['template'];
			$output .= ob_get_clean();
		}

		return $output;
	}

}
