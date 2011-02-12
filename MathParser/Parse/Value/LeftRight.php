<?php

namespace MathParser\Parse\Value;

abstract class LeftRight {
	
	protected $left;
	protected $right;
	
	public function setLeft(IValue $t) {
		$this -> left = $t;
	}
	
	public function setRight(IValue $t) {
		$this -> right = $t;
	}
}
