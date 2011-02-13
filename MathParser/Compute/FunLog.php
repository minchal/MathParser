<?php
/**
 * MathParser library.
 * 
 * @author   Michał Pawłowski <michal@pawlowski.be>
 * @license  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

namespace MathParser\Compute;

class FunLog extends Fun implements IValue {
	
	protected $name = 'log';
	
	public function getValue() {
		$base = $this->args[1]->getValue();
		
		if ($base <= 0) {
			throw new Exception('Log base must be greater than 0');
		}
		
		return log($this->args[0]->getValue(), $base);
	}
}
