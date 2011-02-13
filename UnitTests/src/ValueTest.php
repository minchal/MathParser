<?php

use MathParser\Compute\Number;
use MathParser\Compute\Add;
use MathParser\Compute\Multi;

class ValueTest extends PHPUnit_Framework_TestCase {
	
	protected $a;
	protected $b;
	protected $c;
	
	public function setUp() {
		$a = new Multi();
		
		$b = new Add();
			$b1 = new Number();
				$b1 -> setValue(2);
			$b2 = new Add();
				$b21 = new Number();
					$b21 -> setValue(3);
				$b22 = new Number();
					$b22 -> setValue(4);
				
				$b2 -> setLeft($b21);
				$b2 -> setRight($b22);
			
			$b -> setLeft($b1);
			$b -> setRight($b2);
		
		$c = new Number();
			$c -> setValue(5);
		
		$a -> setLeft($b);
		$a -> setRight($c);
		
		$this -> a = $a;
		$this -> b = $b;
		$this -> c = $c;
	}
	
	public function testNumber() {
		$this->assertEquals($this->c->getValue(), 5);
	}
	
	public function testAdd() {
		$this->assertEquals($this->b->getValue(), 9);
	}
	
	public function testMulti() {
		$this->assertEquals($this->a->getValue(), 45);
	}
}
