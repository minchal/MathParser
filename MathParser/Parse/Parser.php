<?php

namespace MathParser\Parse;
use MathParser\Tokenize\Tokenizer;

class Parser implements ContextListener {
	
	protected $tokenizer;
	protected $context;
	
	/**
	 * @param Array $operators Opcjonalna lista operatorów.
	 */
	public function __construct($context = null) {
		if (!$context) {
			$context = new Context();
		}
		
		$this -> context = $context;
		$this -> context -> addChangeListener($this);
		$this -> contextChanged();
	}
	
	/**
	 * Przy zmianie kontekstu trzeba też zmienić Tokenizer.
	 */
	public function contextChanged() {
		$this -> tokenizer = new Tokenizer($this -> context -> getDelimiters());
	}
	
	/**
	 * Zwraca Context tej instancji parsera.
	 * 
	 * @return MathParser\Parse\Context
	 */
	public function getContext() {
		return $this -> context;
	}
	
	/**
	 * Zwraca Tokenizer przygotowany dla tej instancji Parsera.
	 * 
	 * @return MathParser\Tokenize\Tokenizer
	 */
	public function getTokenizer() {
		return $this -> tokenizer;
	}
	
	/**
	 * Obliczenie wartości wyrażenia zapisanego jako string.
	 * 
	 * @param String $str Wyrażenie
	 * @return Value\Value
	 */
	public function parse($str) {
		return 
			$this -> postfixToValue(
				$this -> infixToPostfix(
					$this -> tokenizer -> tokenize($str)
				)
			);
	}
	
	/**
	 * Zmiana tokenów w ONP na wartość.
	 * 
	 * @param Array $tokens Tablica tokenów
	 * @return Value\Value
	 */
	public function postfixToValue($tokens) {
		$stack = array();
		
		foreach ($tokens as $token) {
			if ($token -> isNumber()) {
				$number = new Value\Number();
				$number -> setValue($token -> getStr());
				array_push($stack, $number);
				continue;
			}
			
			if ($this -> context -> isVariable($token -> getStr())) {
				$number = new Value\Variable();
				$number -> setName($token -> getStr());
				$number -> setContext($this -> context);
				array_push($stack, $number);
				continue;
			}
			
			if (
				($op = $this -> context -> getOperator($token -> getStr())) ||
				($op = $this -> context -> getFunction($token -> getStr()))
			) {
				$args = array();
				
				for ($i=0; $i < $op->getArgCount(); $i++) {
					if (($args[] = array_pop($stack)) === null) {
						throw new Exception('Za mało argumentów dla operatora '.$token.' na pozycji '.$token->getPosition().'!');
					}
				}
				
				array_push($stack, $op -> createValue(array_reverse($args)));
				
				continue;
			}
			
			throw new Exception('Nierozpoznany operator '.$token.'!');
		}
		
		if (count($stack) != 1) {
			throw new Exception('Nieprawidłowe dane wejściowe!');
		}
		
		return array_pop($stack);
	}
	
	/**
	 * Zmiana kolejności tokenów z notacji infiksowej do ONP.
	 * 
	 * @param Array $tokens Tablica tokenów
	 * @return Array
	 */
	public function infixToPostfix($tokens) {
		$output = array();
		$stack = array();
		
		foreach ($tokens as $token) {
			if ($token -> isNumber() || $this -> context -> isVariable($token -> getStr())) {
				array_push($output, $token);
				continue;
			}
			
			if ($op = $this -> context -> getFunction($token -> getStr())) {
				array_push($stack, $token);
				continue;
			}
			
			if ($token -> equals(',')) {
				$pe = false;
				
				while (!empty($stack)) {
					$stackToken = end($stack);
					
					if ($stackToken -> equals('(')) {
						$pe = true;
						break;
					} else {
						array_push($output, array_pop($stack));
					}
				}
				
				if (!$pe) {
					throw new Exception('Błąd nawiasów lub separatorów!');
				}
				
				continue;
			}
			
			if ($op = $this -> context -> getOperator($token -> getStr())) {
				
				while(!empty($stack)) {
					$stackToken = end($stack);
					
					if (
						($op2 = $this -> context -> getOperator($stackToken -> getStr())) && 
						(
							($op->isLeftAssoc() && $op->getPrecedence() <= $op2->getPrecedence()) || 
							(!$op->isLeftAssoc() && $op->getPrecedence() < $op2->getPrecedence())
						)
					) {
						array_push($output, array_pop($stack));
					} else {
						break;
					}
				}
				
				array_push($stack, $token);
				continue;
			}
			
			if ($token -> equals('(')) {
				array_push($stack, $token);
				continue;
			}
			
			if ($token -> equals(')')) {
				$pe = false;
				
				while (!empty($stack)) {
					$stackToken = end($stack);
					
					if ($stackToken -> equals('(')) {
						$pe = true;
						break;
					} else {
						array_push($output, array_pop($stack));
					}
				}
				
				if(!$pe) {
					throw new Exception('Błąd nawiasów!');
				}
				
				array_pop($stack);
				
				if (!empty($stack)) {
					$stackToken = end($stack);
					
					if ($op = $this -> context -> getFunction($stackToken -> getStr())) {
						array_push($output, array_pop($stack));
					}
				}
				
				continue;
			}
			
			throw new Exception('Nierozpoznany token na pozycji '.$token->getPosition());
		}
		
		while (!empty($stack)) {
			$token = array_pop($stack);
			
			if ($token->equals('(') || $token->equals(')')) {
				throw new Exception('Na pozycji '.$token->getPosition().' pozostał nawias!');
			}
			
			array_push($output, $token);
		}
		
		return $output;
	}
}
