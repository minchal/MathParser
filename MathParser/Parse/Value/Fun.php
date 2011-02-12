<?php
/**
 * MathParser library.
 * 
 * @author   Michał Pawłowski <michal@pawlowski.be>
 * @license  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

namespace MathParser\Parse\Value;

/**
 * Implementation of abstract function value.
 */
abstract class Fun {
	
	protected $name = 'fun';
	protected $args = array();
	
	public function setArgs($args) {
		$this -> args = $args;
	}
	
	public function toInfixString() {
		$tmp = array();
		foreach ($this->args as $arg) {
			$tmp[] = $arg -> toInfixString();
		}
		
		return $this->name . '('.implode(', ',$tmp).')';
	}
	
	public function toPostfixString() {
		$tmp = array();
		foreach ($this->args as $arg) {
			$tmp[] = $arg -> toPostfixString();
		}
		
		return implode('',$tmp) . $this->name;
	}
}
