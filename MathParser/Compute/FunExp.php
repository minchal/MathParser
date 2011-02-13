<?php
/**
 * MathParser library.
 * 
 * @author   Michał Pawłowski <michal@pawlowski.be>
 * @license  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

namespace MathParser\Compute;

class FunExp extends Fun implements IValue {
	
	protected $name = 'exp';
	
	public function getValue() {
		return exp($this->args[0]->getValue());
	}
}
