<?php
/**
 * MathParser library.
 * 
 * @author   Michał Pawłowski <michal@pawlowski.be>
 * @license  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

namespace MathParser\Tokenize;

/**
 * Simple token class.
 * Token holds string and position in source string.
 */
class Token {
	
	protected $str;
	protected $position;
	
	/**
	 * Token constructor.
	 * 
	 * @param string $str Token value
	 * @param int $pos Token position
	 */
	public function __construct($str, $pos) {
		$this -> str = $str;
		$this -> position = $pos;
	}
	
	/**
	 * Get string value.
	 */
	public function getStr() {
		return $this -> str;
	}
	
	/**
	 * Get position.
	 */
	public function getPosition() {
		return $this -> position;
	}
	
	/**
	 * String value equals to...
	 * 
	 * @param string $str Other string
	 * @return boolean
	 */
	public function equals($str) {
		return $this -> str == $str;
	}
	
	/**
	 * Is token's value numeric.
	 * 
	 * @return boolean
	 */
	public function isNumber() {
		return is_numeric($this -> str);
	}
	
	/**
	 * Print token.
	 * 
	 * @return string
	 */
	public function __toString() {
		return $this -> str;
	}
}
