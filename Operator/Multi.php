<?php

class Operator_Multi extends Operator {
	
	public function group($tokens) {
		while ( ($key = self::hasToken($tokens, '*')) !== false ) {
			$value = new Value_Multi();
			
			if (!isset($tokens[$key+1])) {
				throw new Parser_Exception('Brak lewego argumentu dla mnożenia w miejscu '.$token->getPosition().'!');
			}
			
			$value -> setLeft(self::tokenToValue($tokens[$key-1]));
			unset($tokens[$key-1]);
			
			if (!isset($tokens[$key+1])) {
				throw new Parser_Exception('Brak prawego argumentu dla mnożenia w miejscu '.$token->getPosition().'!');
			}
			
			$value -> setRight(self::tokenToValue($tokens[$key+1]));
			unset($tokens[$key+1]);
			
			$tokens[$key] = $value;
			
			// uporządkowanie kluczy
			$tokens = array_values($tokens);
		}
		
		return $tokens;
	}
}
