<?php
/**
 * MathParser library.
 * 
 * @author   Michał Pawłowski <michal@pawlowski.be>
 * @license  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

namespace MathParser\Parse\Fun;
use MathParser\Compute;

class Log implements IFun {
	public function getDelimiter() {
		return 'log';
	}
	
	public function getArgCount() {
		return 2;
	}
	
	public function createValue($args) {
		$value = new Compute\FunLog();
		$value -> setArgs($args);
		return $value;
	}
}
