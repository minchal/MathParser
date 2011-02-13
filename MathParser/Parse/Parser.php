<?php
/**
 * MathParser library.
 * 
 * @author   Michał Pawłowski <michal@pawlowski.be>
 * @license  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

namespace MathParser\Parse;
use MathParser\Tokenize\Tokenizer;
use MathParser\Compute;

/**
 * MathParser main class.
 * 
 * <code>
 * $parser = new Parser();
 * $value = $parser -> parse('2+2*2');
 * </code>
 */
class Parser implements ContextListener {
	
	protected $tokenizer;
	protected $context;
	
	/**
	 * Parser constructor.
	 * 
	 * @param Context $context
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
	 * Get current Context.
	 * 
	 * @return Context
	 */
	public function getContext() {
		return $this -> context;
	}
	
	/**
	 * Get Tokenizer created for this instance of Parser.
	 * 
	 * @return MathParser\Tokenize\Tokenizer
	 */
	public function getTokenizer() {
		return $this -> tokenizer;
	}
	
	/**
	 * Parse string to Value objects tree.
	 * 
	 * @param String $str Wyrażenie
	 * @return Compute\IValue
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
	 * Change tokens array in RPN to Value object.
	 * 
	 * @see http://en.wikipedia.org/wiki/Reverse_Polish_notation
	 * @param Array $tokens Tokens in RPN
	 * @return Compute\IValue
	 */
	public function postfixToValue($tokens) {
		$stack = array();
		
		foreach ($tokens as $token) {
			if ($token -> isNumber()) {
				$number = new Compute\Number();
				$number -> setValue($token -> getStr());
				array_push($stack, $number);
				continue;
			}
			
			if ($this -> context -> isVariable($token -> getStr())) {
				$number = new Compute\Variable();
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
	 * Change tokens array in infix notation to RPN.
	 * 
	 * @param Array $tokens
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
