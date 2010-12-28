<?php

abstract class Operator {
	
	public abstract function group($tokens);
	
	protected static function hasToken($tokens, $str) {
		foreach ($tokens as $i => $t) {
			if ($t instanceof Token && $t -> equals($str)) {
				return $i;
			}
		}
		
		return false;
	}
	
	public static function tokenToValue($token) {
		if ($token instanceof Value) {
			return $token;
		}
		
		if ($token -> isNumber()) {
			$r = new Value_Number();
			$r -> setValue($token -> getStr());
			return $r;
		}
		
		throw new Parser_Exception('Coś nie tak. Dwa znaki obok siebie?');
	}
}
