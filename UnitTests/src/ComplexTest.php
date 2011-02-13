<?php

use MathParser\Parse\Parser;

class ComplexTest extends PHPUnit_Framework_TestCase {
	
	protected $p;
	
	protected function setUp() {
		$this -> p = new Parser();
	}
	
	public function testComplex() {
		$root = $this -> p -> parse('3 + 4 * 2 / ( 1 - 5 ) ^ 2 ^ 3');
		$this->assertEquals(3.0001220703125, $root -> getValue());
		
		$root = $this -> p -> parse('(log(10^2,exp(3e4)) + 7 ^3)/5 + 9.43');
		$this->assertEquals($root -> getValue(), (log(pow(10,2),exp(3e4)) + pow(7,3))/5 + 9.43);
		$this->assertEquals($root -> toInfixString(), '(((log((10^2), exp(30000))+(7^3))/5)+9.43)');
	}
	
	/**
     * @expectedException MathParser\Compute\Exception
     */
	public function testDivideBy0() {
		$root = $this -> p -> parse('10/0');
		$root -> getValue();
	}
	
	/**
     * @expectedException MathParser\Compute\Exception
     */
	public function testModuloBy0() {
		$root = $this -> p -> parse('10%0');
		$root -> getValue();
	}
	
	/**
     * @expectedException MathParser\Compute\Exception
     */
	public function testLogBase0() {
		$root = $this -> p -> parse('log(5,0)');
		$root -> getValue();
	}
}
