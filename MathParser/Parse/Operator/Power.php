<?php
/**
 * MathParser library.
 * 
 * @author   Michał Pawłowski <michal@pawlowski.be>
 * @license  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

namespace MathParser\Parse\Operator;
use MathParser\Compute;

class Power implements IOperator {
	
	public function getDelimiter() {
		return '^';
	}
	
	public function getPrecedence() {
		return 4;
	}
	
	public function isLeftAssoc() {
		return false;
	}
	
	public function getArgCount() {
		return 2;
	}
	
	public function createValue($args) {
		$value = new Compute\Power();
		$value -> setLeft($args[0]);
		$value -> setRight($args[1]);
		return $value;
	}
}
