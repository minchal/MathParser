<?php
/**
 * MathParser library.
 * 
 * @author   Michał Pawłowski <michal@pawlowski.be>
 * @license  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

namespace MathParser\Parse\Value;
use MathParser\Parse\Context;

/**
 * Variable holds context and gets value when calculating.
 */
class Variable implements IValue {
	
	protected $name;
	protected $context;
	
	public function getValue() {
		$val = $this -> context -> getVariable($this -> name);
		return $val instanceof IValue ? $val->getValue() : $val;
	}
	
	public function setName($name) {
		$this -> name = $name;
	}
	
	public function setContext(Context $c) {
		$this -> context = $c;
	}
	
	public function toInfixString() {
		return $this->name;
	}
	
	public function toPostfixString() {
		return $this->name.' ';
	}
}
