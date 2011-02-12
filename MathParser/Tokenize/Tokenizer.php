<?php
/**
 * MathParser library.
 * 
 * @author   Michał Pawłowski <michal@pawlowski.be>
 * @license  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

namespace MathParser\Tokenize;

/**
 * Tokenizer
 * breaks string to Tokens.
 */
class Tokenizer {
	
	protected $ops = array();
	protected $tokens = array();
	
	/**
	 * Tokenizer constructor.
	 * Needs delimiters array.
	 * 
	 * @param Array $ops
	 */
	public function __construct($ops) {
		$this -> ops = $ops;
		
		// sortowane wg. długości (najdłuższe na początku)
		usort($this -> ops, function($a, $b) {
			if (strlen($a) == strlen($b)) {
				return 0;
			}
			
			return strlen($a) > strlen($b) ? -1 : 1;
		});
	}
	
	/**
	 * Get last tokenized array.
	 */
	public function getLastTokens() {
		return $this -> tokens;
	}
	
	/**
	 * Change string to Tokens array.
	 */
	public function tokenize($buffer) {
		$this -> tokens = array();
		$bufferIndex = 0;
		$found = '';
		
		while ($buffer) {
			$matches = array();
			
			// whitespace
			if (preg_match('/^([\s]).*$/', $buffer, $matches)) {
				$found = $matches[1];
				
			// number
			} else if(preg_match('/^([0-9]+[\.e]?[0-9]*).*$/', $buffer, $matches)) {
				$found = $matches[1];
				$this -> tokens[] = new Token($found, $bufferIndex);
				
			} else {
				// operator
				foreach ($this -> ops as $op) {
					if (strpos($buffer, $op) === 0) {
						$found = $op;
						$this -> tokens[] = new Token($op, $bufferIndex);
						break;
					}
				}
			}
			
			if (!strlen($found)) {
				throw new Exception('Nie można rozpoznać symbolu na pozycji '.$bufferIndex);
			}
			
			// remove founded token from buffer
			$buffer = substr($buffer, strlen($found));
			
			$bufferIndex += strlen($found);
			$found = '';
		}
		
		return $this -> tokens;
	}
}
