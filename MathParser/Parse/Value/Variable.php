<?php

namespace MathParser\Parse\Value;
use MathParser\Parse\Context;

class Variable implements IValue {
	
	protected $name;
	protected $context;
	
	public function getValue() {
		$val = $this -> context -> getVariable($this -> name);
		return $val instanceof Ivalue ? $val->getValue() : $val;
	}
	
	public function setName($name) {
		$this -> name = $name;
	}
	
	public function setContext(Context $c) {
		$this -> context = $c;
	}
	
	public function toInfixString() {
		return $this->name;
	}
	
	public function toPostfixString() {
		return $this->name.' ';
	}
}
