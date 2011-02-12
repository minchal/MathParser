<?php

namespace MathParser\Parse\Value;

class Power extends LeftRight implements IValue {
	
	public function getValue() {
		$base = $this->left->getValue();
		$exp = $this->right->getValue();
		
		return pow($base, $exp);
	}
	
	public function toInfixString() {
		return '(' . $this->left->toInfixString() . '^' . $this->right->toInfixString() . ')';
	}
	
	public function toPostfixString() {
		return $this->left->toPostfixString() . $this->right->toPostfixString() . '^ ';
	}
}
