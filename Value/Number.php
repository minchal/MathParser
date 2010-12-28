<?php

class Value_Number extends Value {
	
	protected $num;
	
	public function setValue($num) {
		$this -> num = (float) $num;
	}
	
	public function getValue() {
		return $this->num;
	}
	
	public function toString() {
		return (string) $this -> num;
	}
}
