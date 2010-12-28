<?php

class Operator_Minus extends Operator {
	
	public function group($tokens) {
		while ( ($key = self::hasToken($tokens, '-')) !== false ) {
			$value = new Value_Minus();
			
			if (!isset($tokens[$key-1])) {
				$num = new Value_Number();
				$num -> setValue(0);
				$value -> setLeft($num);
			} else {
				$value -> setLeft(self::tokenToValue($tokens[$key-1]));
				
				unset($tokens[$key-1]);
			}
			
			if (!isset($tokens[$key+1])) {
				throw new Parser_Exception('Brak prawego argumentu dla odejmowania w miejscu '.$token->getPosition().'!');
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
