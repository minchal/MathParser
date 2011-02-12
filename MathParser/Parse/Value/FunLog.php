<?php
/**
 * MathParser library.
 * 
 * @author   Michał Pawłowski <michal@pawlowski.be>
 * @license  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

namespace MathParser\Parse\Value;

class FunLog extends Fun implements IValue {
	
	protected $name = 'log';
	
	public function getValue() {
		return log($this->args[0]->getValue(), $this->args[1]->getValue());
	}
}
