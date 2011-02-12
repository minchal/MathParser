<?php
/**
 * MathParser library.
 * 
 * @author   Michał Pawłowski <michal@pawlowski.be>
 * @license  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

namespace MathParser\Parse;

/**
 * Context for Parser.
 * Holds variables, functions and operators.
 */
class Context {
	
	protected $functions = array();
	protected $operators = array();
	protected $variables = array();
	protected $listeners = array();
	
	/**
	 * Context constructor.
	 * All arguments are optional.
	 * 
	 * @param Array $operators Operator/IOperator instances.
	 * @param Array $functions Fun/IFun instances.
	 */
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
	
	/**
	 * Add listener for change context event.
	 */
	public function addChangeListener(ContextListener $lis) {
		$this -> listeners[] = $lis;
	}
	
	/**
	 * Get delimiters for Tokenizer for all collected items.
	 */
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
	
	/**
	 * Add function or operator.
	 * 
	 * @param Fun\IFun|Operator\IOperator $item
	 */
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
	
	/**
	 * Set variable.
	 * 
	 * @param string                 $name  Variable name.
	 * @param int|float|Value\IValue $value Optional value.
	 */
	public function setVariable($name, $value = 0) {
		$refresh = !isset($this -> variables[$name]);
		
		$this -> variables[$name] = $value;
		
		if ($refresh) {
			$this -> notify();
		}
	}
	
	/**
	 * Is $name reserved as variable.
	 * 
	 * @param string $name Variable name.
	 */
	public function isVariable($name) {
		return isset($this -> variables[$name]);
	}
	
	/**
	 * Get variable value.
	 * 
	 * @param string $name Variable name.
	 */
	public function getVariable($name) {
		if (isset($this -> variables[$name])) {
			return $this -> variables[$name];
		}
		
		return 0;
	}
	
	/**
	 * Get operator instance.
	 * 
	 * @param string $name Operator name.
	 * @return Operator\IOperator
	 */
	public function getOperator($name) {
		if (isset($this -> operators[$name])) {
			return $this -> operators[$name];
		}
		
		return null;
	}
	
	/**
	 * Get function instance.
	 * 
	 * @param string $name Function name.
	 * @return Fun\IFun
	 */
	public function getFunction($name) {
		if (isset($this -> functions[$name])) {
			return $this -> functions[$name];
		}
		
		return null;
	}
	
	/**
	 * Notify listeners, that context has changed.
	 */
	protected function notify() {
		foreach ($this -> listeners as $l) {
			$l -> contextChanged();
		}
	}
	
	/**
	 * Get default operator list.
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
	 * Get default functions list.
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
