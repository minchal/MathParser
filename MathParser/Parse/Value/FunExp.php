<?php

namespace MathParser\Parse\Value;

class FunExp extends Fun implements IValue {
	
	protected $name = 'exp';
	
	public function getValue() {
		return exp($this->args[0]->getValue());
	}
}
