<?php

use MathParser\Parse\Parser;
use MathParser\Parse\Context;
use MathParser\Tokenize\Token;

class ParserTest extends PHPUnit_Framework_TestCase {
	
	protected $p;
	
	protected function setUp() {
		$this -> p = new Parser();
	}
	
	public function testPostfixToValue() {
		$t = $this -> p -> getTokenizer();
		
		$root = $this -> p -> postfixToValue(array(new Token('123',0)));
		$this->assertEquals(123, $root -> getValue());
		$this->assertEquals('123', $root -> toInfixString());
		
		$root = $this -> p -> postfixToValue(array(new Token('2',0),new Token('3',0),new Token('+',0)));
		$this->assertEquals(5, $root -> getValue());
		$this->assertEquals('(2+3)', $root -> toInfixString());
		
		$root = $this -> p -> postfixToValue($t -> tokenize('5 1 2 + 4 * 3 - +'));
		$this->assertEquals(14, $root -> getValue());
		$this->assertEquals('(5+(((1+2)*4)-3))', $root -> toInfixString());
		$this->assertEquals('5 1 2 + 4 * 3 - + ', $root -> toPostfixString());
		
		$root = $this -> p -> postfixToValue($t -> tokenize('12 2 3 4 * 10 5 / + * +'));
		$this->assertEquals(40, $root -> getValue());
	}
	
	public function testNumbers() {
		$root = $this -> p -> parse('123');
		$this->assertEquals($root -> getValue(), 123);
		$this->assertEquals($root -> toInfixString(), '123');
		
		$root = $this -> p -> parse('12.3');
		$this->assertEquals($root -> getValue(), 12.3);
		$this->assertEquals($root -> toInfixString(), '12.3');
		
		$root = $this -> p -> parse('12e3');
		$this->assertEquals($root -> getValue(), 12e3);
		$this->assertEquals($root -> toInfixString(), '12000');
	}
	
	public function testBasic() {
		$root = $this -> p -> parse('2+2');
		$this->assertEquals($root -> getValue(), 4);
		$this->assertEquals($root -> toInfixString(), '(2+2)');
		
		$root = $this -> p -> parse('2+2*2');
		$this->assertEquals($root -> getValue(), 6);
		$this->assertEquals($root -> toInfixString(), '(2+(2*2))');
	}
	
	public function testBrackets() {
		$root = $this -> p -> parse('(2+2)*2');
		$this->assertEquals($root -> getValue(), 8);
		$this->assertEquals($root -> toInfixString(), '((2+2)*2)');
		
		$root = $this -> p -> parse('(((2+(2))))');
		$this->assertEquals($root -> getValue(), 4);
		$this->assertEquals($root -> toInfixString(), '(2+2)');
	}
	
	/**
     * @expectedException MathParser\Parse\Exception
     */
	public function testBracketsException() {
		$this -> p -> parse('(2+2*2');
	}
	
	/**
     * @expectedException MathParser\Parse\Exception
     */
	public function testBracketsException2() {
		$this -> p -> parse('2+2)*2');
	}
	
	public function testFunctions() {
		$root = $this -> p -> parse('exp(2)');
		$this->assertEquals($root -> getValue(), exp(2));
		$this->assertEquals($root -> toInfixString(), 'exp(2)');
		
		
		$root = $this -> p -> parse('exp(2)+2');
		$this->assertEquals($root -> getValue(), exp(2)+2);
		$this->assertEquals($root -> toInfixString(), '(exp(2)+2)');
		
		$root = $this -> p -> parse('log(10,2)');
		$this->assertEquals($root -> getValue(), log(10,2));
		$this->assertEquals($root -> toInfixString(), 'log(10, 2)');
	}
	
	public function testVariables() {
		$c = new Context();
		$c -> setVariable('A', 10);
		$p = new Parser($c);
		
		$root = $p -> parse('A+5');
		
		$this->assertEquals($root -> getValue(), 10+5);
		$this->assertEquals($root -> toInfixString(), '(A+5)');
		
		$c -> setVariable('A', 20);
		$this->assertEquals($root -> getValue(), 20+5);
		
		$c -> setVariable('B', 5);
		$root = $p -> parse('A+B');
		$this->assertEquals($root -> getValue(), 20+5);
	}
	
	public function testComplex() {
		$root = $this -> p -> parse('3 + 4 * 2 / ( 1 - 5 ) ^ 2 ^ 3');
		$this->assertEquals(3.0001220703125, $root -> getValue());
		
		$root = $this -> p -> parse('(log(10^2,exp(3e4)) + 7 ^3)/5 + 9.43');
		$this->assertEquals($root -> getValue(), (log(pow(10,2),exp(3e4)) + pow(7,3))/5 + 9.43);
		$this->assertEquals($root -> toInfixString(), '(((log((10^2), exp(30000))+(7^3))/5)+9.43)');
	}
}
