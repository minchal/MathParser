<?php
/**
 * MathParser library.
 * 
 * @author   Michał Pawłowski <michal@pawlowski.be>
 * @license  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

namespace MathParser\Compute;

/**
 * Binary operator abstract implementation.
 */
abstract class LeftRight {
	
	protected $left;
	protected $right;
	
	public function setLeft(IValue $t) {
		$this -> left = $t;
	}
	
	public function setRight(IValue $t) {
		$this -> right = $t;
	}
}
