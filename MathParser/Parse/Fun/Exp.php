<?php
/**
 * MathParser library.
 * 
 * @author   Michał Pawłowski <michal@pawlowski.be>
 * @license  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

namespace MathParser\Parse\Fun;
use MathParser\Compute;

class Exp implements IFun {
	public function getDelimiter() {
		return 'exp';
	}
	
	public function getArgCount() {
		return 1;
	}
	
	public function createValue($args) {
		$value = new Compute\FunExp();
		$value -> setArgs($args);
		return $value;
	}
}
