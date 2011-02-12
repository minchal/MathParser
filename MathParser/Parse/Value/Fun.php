<?php

namespace MathParser\Parse\Value;

abstract class Fun {
	
	protected $name = 'fun';
	protected $args = array();
	
	public function setArgs($args) {
		$this -> args = $args;
	}
	
	public function toInfixString() {
		$tmp = array();
		foreach ($this->args as $arg) {
			$tmp[] = $arg -> toInfixString();
		}
		
		return $this->name . '('.implode(', ',$tmp).')';
	}
	
	public function toPostfixString() {
		$tmp = array();
		foreach ($this->args as $arg) {
			$tmp[] = $arg -> toPostfixString();
		}
		
		return implode('',$tmp) . $this->name;
	}
}
