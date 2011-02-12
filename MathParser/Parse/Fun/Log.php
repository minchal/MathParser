<?php

namespace MathParser\Parse\Fun;
use MathParser\Parse\Value;

class Log implements IFun {
	public function getDelimiter() {
		return 'log';
	}
	
	public function getArgCount() {
		return 2;
	}
	
	public function createValue($args) {
		$value = new Value\FunLog();
		$value -> setArgs($args);
		return $value;
	}
}
