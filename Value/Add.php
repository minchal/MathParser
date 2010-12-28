<?php

class Value_Add extends Value_LR {
	
	public function getValue() {
		return $this->left->getValue() + $this->right->getValue();
	}
	
	public function toString() {
		return '(' . $this->left . '+' . $this->right . ')';
	}
}
