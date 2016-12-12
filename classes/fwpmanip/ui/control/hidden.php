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
 * Hidden input field
 * @todo Remove all labels and wrappers.
 * @since 1.0.0
 */
class hidden extends \fwpmanip\ui\control {

	/**
	 * The type of object
	 *
	 * @since       1.0.0
	 * @access public
	 * @var         string
	 */
	public $type = 'hidden';

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

}
