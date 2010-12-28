<?php

class Token {
	
	protected $str;
	protected $position;
	
	public function __construct($str, $pos) {
		$this -> str = $str;
		$this -> position = $pos;
	}
	
	public function getStr() {
		return $this -> str;
	}
	
	public function getPosition() {
		return $this -> position;
	}
	
	public function equals($str) {
		return $this -> str == $str;
	}
	
	public function isNumber() {
		return is_numeric($this -> str);
	}
}
