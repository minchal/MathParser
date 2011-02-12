<?php

use MathParser\Tokenize\Tokenizer;
use MathParser\Tokenize\Token;

class TokenizerTest extends PHPUnit_Framework_TestCase {
	
	public function testSimple() {
		$t = new Tokenizer(array('a','b','@','cd','e1f','aa'));
		
		$this -> assertEquals($t -> tokenize(''), array());
		
		$this -> assertEquals($t -> tokenize('123'), array(new Token('123', 0)));
		$this -> assertEquals($t -> tokenize('12.3'), array(new Token('12.3', 0)));
		$this -> assertEquals($t -> tokenize('12cd34'), array(new Token('12', 0),new Token('cd', 2),new Token('34', 4)));
		
		// whitespace
		$this -> assertEquals($t -> tokenize('12 3'), array(new Token('12', 0), new Token('3', 3)));
		$this -> assertEquals($t -> tokenize(' 12cd 34'), array(new Token('12', 1),new Token('cd', 3),new Token('34', 6)));
		
		// exponential
		$this -> assertEquals($t -> tokenize('12e3'), array(new Token('12e3', 0)));
	}
	
	public function testMath() {
		$t = new Tokenizer(array('+','-','*','abs','(',',',')','A'));
		
		$this -> assertEquals(
			$t -> tokenize('(12.5)'), 
			array(new Token('(', 0),new Token('12.5', 1),new Token(')', 5))
		);
		
		$this -> assertEquals(
			$t -> tokenize('2+2-2'), 
			array(new Token('2', 0),new Token('+', 1),new Token('2', 2),new Token('-', 3),new Token('2', 4))
		);
		
		$this -> assertEquals(
			$t -> tokenize('abs(12,34)'), 
			array(new Token('abs', 0),new Token('(', 3),new Token('12', 4),new Token(',', 6),new Token('34', 7),new Token(')', 9))
		);
		
		$this -> assertEquals(
			self::implode($t -> tokenize('abs(12,34)')),
			'abs|(|12|,|34|)'
		);
		
		$this -> assertEquals(
			self::implode($t -> tokenize('12 -+ 2- 2')), 
			'12|-|+|2|-|2'
		);
		
		$this -> assertEquals(
			self::implode($t -> tokenize('5 1 2 + 4 * 3 - +')), 
			'5|1|2|+|4|*|3|-|+'
		);
		
		$this -> assertEquals(
			self::implode($t -> tokenize('A+10')), 
			'A|+|10'
		);
	}
	
	/**
     * @expectedException MathParser\Tokenize\Exception
     */
	public function testNotNumbers() {
		$t = new Tokenizer(array('+','-'));
		$t -> tokenize('asd');
	}
	
	/**
     * @expectedException MathParser\Tokenize\Exception
     */
	public function testNotNUmbers2() {
		$t = new Tokenizer(array('+','-'));
		$t -> tokenize('a1+');
	}
	
	public static function implode($tokens) {
		return implode('|', $tokens);
	}
}
