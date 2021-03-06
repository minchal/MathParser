<?php
/**
 * MathParser library.
 * 
 * @author   Michał Pawłowski <michal@pawlowski.be>
 * @license  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

namespace MathParser\Parse\Operator;
use MathParser\Compute;

class Add implements IOperator {
	
	public function getDelimiter() {
		return '+';
	}
	
	public function getPrecedence() {
		return 2;
	}
	
	public function isLeftAssoc() {
		return true;
	}
	
	public function getArgCount() {
		return 2;
	}
	
	public function createValue($args) {
		$value = new Compute\Add();
		$value -> setLeft($args[0]);
		$value -> setRight($args[1]);
		return $value;
	}
}
