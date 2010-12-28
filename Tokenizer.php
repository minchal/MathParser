<?php

class Tokenizer {
	
	protected $str;
	protected $ops = array();
	protected $tokens = array();
	
	public function __construct($str, $ops) {
		$this -> str = $str;
		$this -> ops = $ops;
		
		$this -> tokenize();
	}
	
	public function getTokens() {
		return $this -> tokens;
	}
	
	protected function tokenize() {
		$str = $this -> str;
		$ops = $this -> ops;
		
		$ret = array();
		
		$len = strlen($str);
		
		$buff = '';
		
		for ($i=0; $i < $len; $i++) {
			$char = $str[$i];
			
			if (in_array($char, $ops)) {
				if ($buff) {
					$ret[] = new Token($buff, $buff_i);
					$buff = '';
				}
				
				$ret[] = new Token($char, $i);
				
			} else {
				if (!$buff) {
					$buff_i = $i;
				}
				
				$buff .= $char;
			}
		}
		
		if ($buff) {
			$ret[] = new Token($buff, $buff_i);
		}
		
		$this -> tokens = $ret;
	}
}
