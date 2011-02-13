<?php
/**
 * MathParser library.
 * 
 * @author   Michał Pawłowski <michal@pawlowski.be>
 * @license  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

namespace MathParser\Compute;

class Power extends LeftRight implements IValue {
	
	public function getValue() {
		$base = $this->left->getValue();
		$exp = $this->right->getValue();
		
		return pow($base, $exp);
	}
	
	public function toInfixString() {
		return '(' . $this->left->toInfixString() . '^' . $this->right->toInfixString() . ')';
	}
	
	public function toPostfixString() {
		return $this->left->toPostfixString() . $this->right->toPostfixString() . '^ ';
	}
}
