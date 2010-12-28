<?php

abstract class Value_LR extends Value {
	
	protected $left;
	protected $right;
	
	public function setLeft(Value $t) {
		$this -> left = $t;
	}
	
	public function setRight(Value $t) {
		$this -> right = $t;
	}
}
