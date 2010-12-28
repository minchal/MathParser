<?php

class Parser {
	
	protected $str;
	protected $root;
	
	protected $ops;
	protected $operators;
	
	public function __construct($str) {
		if (!$this -> validate($str)) {
			throw new Parser_Exception('Podany ciąg jest nieprawidłowy!');
		}
		
		$this -> str = $str;
		
		$this -> ops = array('*','+','/','-','^','(',')');
		
		$this -> operators[] = new Operator_Power();
		$this -> operators[] = new Operator_Modulo();
		$this -> operators[] = new Operator_Divide();
		$this -> operators[] = new Operator_Multi();
		$this -> operators[] = new Operator_Minus();
		$this -> operators[] = new Operator_Add();
		
		$this -> parse();
	}
	
	public function parse() {
		$tokenizer = new Tokenizer($this -> str, $this -> ops);
		
		$this -> root = $this -> parseTokens($tokenizer -> getTokens());
	}
	
	/**
	 * Złączenie wszystkich tokenów w jedną wartość.
	 */
	protected function parseTokens($tokens) {
		$tokens = $this -> parseBrackets($tokens);
		
		// operatory w ustalonej kolejności
		foreach ($this -> operators as $op) {
			$tokens = $op -> group($tokens);
		}
		
		print_r($tokens);
		
		if (count($tokens) > 1) {
			throw new Parser_Exception('Coś poszło całkiem nie tak. Zostały niezgrupowane Tokeny.');
		}
		
		if  ($tokens[0] instanceof Token) {
			$r = new Value_Number();
			$r -> setValue($tokens[0] -> getStr());
			return $r;
		}
		
		return $tokens[0];
	}
	
	/**
	 * Wyszukanie i zastąpienie nawiasów w pojedyńcze wartości.
	 * 
	 * @param $tokens Array
	 * @returns Array
	 */
	protected function parseBrackets($tokens) {
		$next = array();
		
		for ($i=0; $i < count($tokens); $i++) {
			$token = $tokens[$i];
			
			if ($token -> equals('(')) {
				$tmp = array();
				
				$stack = 0;
				
				while ($i < count($tokens)) {
					$i++;
					
					if ($tokens[$i] -> equals('(')) {
						$stack++;
					}
					
					if ($tokens[$i] -> equals(')')) {
						if ($stack == 0) {
							break;
						}
						$stack--;
					}
					
					$tmp[] = $tokens[$i];
				}
				
				// doszedł do końca
				if ($i == count($tokens)) {
					throw new Parser_Exception('Nie znaleziono nawiasu zamykającego dla nawiasu otwierającego na pozycji '.$token->getPosition().'!');
				}
				
				$next[] = $this -> parseTokens($tmp);
			} else {
				$next[] = $token;
			}
		}
		
		return $next;
	}
	
	public function validate($str) {
		return true; // TODO
	}
	
	public function getValue() {
		return $this -> root -> getValue();
	}
	
	public function toString() {
		return (string) $this -> root;
	}
	
	public function __toString() {
		return $this -> toString();
	}
}
