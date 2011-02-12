<?php

namespace MathParser\Parse\Fun;

interface IFun {
	public function getDelimiter();
	
	public function getArgCount();
	
	public function createValue($args);
}
