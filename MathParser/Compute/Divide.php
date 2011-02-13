<?php
/**
 * MathParser library.
 * 
 * @author   Michał Pawłowski <michal@pawlowski.be>
 * @license  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

namespace MathParser\Compute;

class Divide extends LeftRight implements IValue {
	
	public function getValue() {
		$right = $this->right->getValue();
		
		if ($right == 0) {
			throw new Exception('Division by zero!');
		}
		
		return $this->left->getValue() / $right;
	}
	
	public function toInfixString() {
		return '(' . $this->left->toInfixString() . '/' . $this->right->toInfixString() . ')';
	}
	
	public function toPostfixString() {
		return $this->left->toPostfixString() . $this->right->toPostfixString() . '/ ';
	}
}
