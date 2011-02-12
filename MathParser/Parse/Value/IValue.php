<?php

namespace MathParser\Parse\Value;

interface IValue {
	public function getValue();
	
	public function toInfixString();
	public function toPostfixString();
}
