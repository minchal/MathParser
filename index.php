<?php

function __autoload($class) {
	require str_replace('_', '/', $class);
}

function testStr($str) {
	try {
		eval('$r='.$str.';');
		echo 'Input: '.$str .'='.$r ."\n";
		$t = new Tokenizer($str);
		
		echo 'Output: '.$t -> getValue() ."\n";
		echo 'As string: '.$t -> toString() ."\n";
	} catch (Exception $e) {
		echo $e -> getMessage() ."\n";
	}
}

echo '<pre>';

testStr('2+(2.1+(10+11)*32+4)*5');

echo '<br /><hr /><br />';

testStr('222.1');

echo '<br /><hr /><br />';

testStr('2+2*2');

echo '<br /><hr /><br />';

testStr('1+2+3');

echo '<br /><hr /><br />';

testStr('1*2*3');

echo '<br /><hr /><br />';

testStr('(2+2)*(3+3)');
