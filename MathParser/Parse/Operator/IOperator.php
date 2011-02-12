<?php
/**
 * MathParser library.
 * 
 * @author   Michał Pawłowski <michal@pawlowski.be>
 * @license  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

namespace MathParser\Parse\Operator;

/**
 * Interface for operator.
 */
interface IOperator {
	public function getDelimiter();
	
	public function getPrecedence();
	
	public function isLeftAssoc();
	
	public function getArgCount();
	
	public function createValue($args);
}
