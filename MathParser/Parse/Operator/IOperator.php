<?php

namespace MathParser\Parse\Operator;

interface IOperator {
	public function getDelimiter();
	
	public function getPrecedence();
	
	public function isLeftAssoc();
	
	public function getArgCount();
	
	public function createValue($args);
}
