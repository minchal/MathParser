<?php
/**
 * MathParser library.
 * 
 * @author   Michał Pawłowski <michal@pawlowski.be>
 * @license  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

namespace MathParser\Parse\Value;

class Modulo extends LeftRight implements IValue {
	
	public function getValue() {
		return $this->left->getValue() % $this->right->getValue();
	}
	
	public function toInfixString() {
		return '(' . $this->left->toInfixString() . '%' . $this->right->toInfixString() . ')';
	}
	
	public function toPostfixString() {
		return $this->left->toPostfixString() . $this->right->toPostfixString() . '% ';
	}
}
