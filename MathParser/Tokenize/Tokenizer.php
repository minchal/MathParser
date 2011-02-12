<?php

namespace MathParser\Tokenize;

class Tokenizer {
	
	protected $ops = array();
	protected $tokens = array();
	
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
	
	public function getLastTokens() {
		return $this -> tokens;
	}
	
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
			
			// usunięcie pierwszego wystąpienia
			$buffer = substr($buffer, strlen($found));
			
			$bufferIndex += strlen($found);
			$found = '';
		}
		
		return $this -> tokens;
	}
}
