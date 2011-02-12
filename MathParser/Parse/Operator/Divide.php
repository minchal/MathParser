<?php

namespace MathParser\Parse\Operator;
use MathParser\Parse\Value;

class Divide implements IOperator {
	
	public function getDelimiter() {
		return '/';
	}
	
	public function getPrecedence() {
		return 3;
	}
	
	public function isLeftAssoc() {
		return true;
	}
	
	public function getArgCount() {
		return 2;
	}
	
	public function createValue($args) {
		$value = new Value\Divide();
		$value -> setLeft($args[0]);
		$value -> setRight($args[1]);
		return $value;
	}
}