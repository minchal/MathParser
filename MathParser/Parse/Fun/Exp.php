<?php

namespace MathParser\Parse\Fun;
use MathParser\Parse\Value;

class Exp implements IFun {
	public function getDelimiter() {
		return 'exp';
	}
	
	public function getArgCount() {
		return 1;
	}
	
	public function createValue($args) {
		$value = new Value\FunExp();
		$value -> setArgs($args);
		return $value;
	}
}
