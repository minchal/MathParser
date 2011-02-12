<?php
/**
 * MathParser library.
 * 
 * @author   Michał Pawłowski <michal@pawlowski.be>
 * @license  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

namespace MathParser\Parse\Fun;

/**
 * Interface for function creator class.
 */
interface IFun {
	public function getDelimiter();
	
	public function getArgCount();
	
	public function createValue($args);
}
