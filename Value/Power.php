<?php

class Value_Power extends Value_LR {
	
	public function getValue() {
		$base = $this->left->getValue();
		$exp = $this->right->getValue();
		
		return pow($base, $exp);
	}
	
	public function toString() {
		return '(' . $this->left . '^' . $this->right . ')';
	}
}
