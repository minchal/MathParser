<?php
/**
 * MathParser library.
 * 
 * @author   Michał Pawłowski <michal@pawlowski.be>
 * @license  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

namespace MathParser\Parse;

/**
 * Class, thats waits for context content change.
 */
interface ContextListener {
	public function contextChanged();
}
