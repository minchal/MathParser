<?php

namespace MathParser\Parse\Operator;
use MathParser\Parse\Value;

class Power implements IOperator {
	
	public function getDelimiter() {
		return '^';
	}
	
	public function getPrecedence() {
		return 4;
	}
	
	public function isLeftAssoc() {
		return false;
	}
	
	public function getArgCount() {
		return 2;
	}
	
	public function createValue($args) {
		$value = new Value\Power();
		$value -> setLeft($args[0]);
		$value -> setRight($args[1]);
		return $value;
	}
}
