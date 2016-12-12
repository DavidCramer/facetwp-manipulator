<?php
/**
 * FWPMANIP Control
 *
 * @package   controls
 * @author    David Cramer
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 David Cramer
 */
namespace fwpmanip\ui\control;

/**
 * Checkbox Fields group
 *
 * @since 1.0.0
 */
class checkbox extends \fwpmanip\ui\control\radio {

	/**
	 * The type of object
	 *
	 * @since       1.0.0
	 * @access public
	 * @var         string
	 */
	public $type = 'checkbox';

	/**
	 * Create and Return the control's input name
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string The control name
	 */
	public function name() {
		return parent::name() . '[]';
	}

}
