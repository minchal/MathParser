<?php

abstract class Value {
	
	public abstract function getValue();
	
	public abstract function toString();
	
	public function __toString() {
		return $this -> toString();
	}
}
