<?php

class Value_Divide extends Value_LR {
	
	public function getValue() {
		return $this->left->getValue() / $this->right->getValue();
	}
	
	public function toString() {
		return '(' . $this->left . '/' . $this->right . ')';
	}
}
