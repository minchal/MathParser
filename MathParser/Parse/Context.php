<?php

namespace MathParser\Parse;

class Context {
	
	protected $functions = array();
	protected $operators = array();
	protected $variables = array();
	protected $listeners = array();
	
	public function __construct($operators = null, $functions = null) {
		if ($operators === null) {
			$operators = self::getDefaultOperators();
		}
		
		if ($functions === null) {
			$functions = self::getDefaultFunctions();
		}
		
		foreach ($operators as $o) {
			$this -> operators[$o -> getDelimiter()] = $o;
		}
		
		foreach ($functions as $f) {
			$this -> functions[$f -> getDelimiter()] = $f;
		}
	}
	
	public function addChangeListener(ContextListener $lis) {
		$this -> listeners[] = $lis;
	}
	
	public function getDelimiters() {
		$ops = array('(',')',',');
		
		foreach ($this -> operators as $o) {
			$ops[] = $o -> getDelimiter();
		}
		
		foreach ($this -> functions as $f) {
			$ops[] = $f -> getDelimiter();
		}
		
		foreach ($this -> variables as $n => $v) {
			$ops[] = $n;
		}
		
		return $ops;
	}
	
	public function add($item) {
		if ($item instanceof Fun\IFun) {
			$this -> functions[$item->getDelimiter()] = $item;
			$this -> notify();
			return;
		}
		
		if ($item instanceof Operator\IOperator) {
			$this -> operators[$item->getDelimiter()] = $item;
			$this -> notify();
			return;
		}
		
		throw new \Exception('Nierozpoznany obiekt do dodania do kontekstu.');
	}
	
	public function setVariable($name, $value = 0) {
		$refresh = !isset($this -> variables[$name]);
		
		$this -> variables[$name] = $value;
		
		if ($refresh) {
			$this -> notify();
		}
	}
	
	public function isVariable($name) {
		return isset($this -> variables[$name]);
	}
	
	public function getVariable($name) {
		if (isset($this -> variables[$name])) {
			return $this -> variables[$name];
		}
		
		return 0;
	}
	
	public function getOperator($name) {
		if (isset($this -> operators[$name])) {
			return $this -> operators[$name];
		}
		
		return null;
	}
	
	public function getFunction($name) {
		if (isset($this -> functions[$name])) {
			return $this -> functions[$name];
		}
		
		return null;
	}
	
	/**
	 * Powiadomienie słuchaczy, że kontekst uległ zmianie.
	 */
	protected function notify() {
		foreach ($this -> listeners as $l) {
			$l -> contextChanged();
		}
	}
	
	/**
	 * Zwraca domyślną listę operatorów.
	 * 
	 * @return Array
	 */
	public static function getDefaultOperators() {
		return array(
			new Operator\Power(),
			new Operator\Modulo(),
			new Operator\Divide(),
			new Operator\Multi(),
			new Operator\Minus(),
			new Operator\Add()
		);
	}
	
	/**
	 * Zwraca domyślną listę funkcji.
	 * 
	 * @return Array
	 */
	public static function getDefaultFunctions() {
		return array(
			new Fun\Exp(),
			new Fun\Log()
		);
	}
}
