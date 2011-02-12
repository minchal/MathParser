<?php

namespace MathParser\Parse\Value;

class FunLog extends Fun implements IValue {
	
	protected $name = 'log';
	
	public function getValue() {
		return log($this->args[0]->getValue(), $this->args[1]->getValue());
	}
}
