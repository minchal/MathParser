<?php

namespace MathParser\Parse\Value;

class Modulo extends LeftRight implements IValue {
	
	public function getValue() {
		return $this->left->getValue() % $this->right->getValue();
	}
	
	public function toInfixString() {
		return '(' . $this->left->toInfixString() . '%' . $this->right->toInfixString() . ')';
	}
	
	public function toPostfixString() {
		return $this->left->toPostfixString() . $this->right->toPostfixString() . '% ';
	}
}
