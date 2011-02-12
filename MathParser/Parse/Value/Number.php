<?php
/**
 * MathParser library.
 * 
 * @author   Michał Pawłowski <michal@pawlowski.be>
 * @license  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

namespace MathParser\Parse\Value;

class Number implements IValue {
	
	protected $num;
	
	public function setValue($num) {
		$this -> num = (float) $num;
	}
	
	public function getValue() {
		return $this -> num;
	}
	
	public function toInfixString() {
		return (string) $this -> num;
	}
	
	public function toPostfixString() {
		return (string) $this -> num .' ';
	}
}
