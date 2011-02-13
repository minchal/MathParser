<?php
/**
 * MathParser library.
 * 
 * @author   Michał Pawłowski <michal@pawlowski.be>
 * @license  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

namespace MathParser\Compute;

/**
 * Value class interface.
 */
interface IValue {
	public function getValue();
	
	public function toInfixString();
	public function toPostfixString();
}
