<?php
/**
 * MathParser chart draw example.
 * 
 * LICENSE:
 *
 * Copyright (c) 2011 Michał Pawłowski
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 * 
 * @author   Michał Pawłowski <michal@pawlowski.be>
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */

require_once realpath(__DIR__ . '/../_autoload.php');

class Chart {
	
	protected $img;
	protected $color;
	
	protected $size_x,$size_y;
	protected $min_x, $max_x;
	protected $min_y, $max_y;
	protected $x_delta, $y_delta;
	
	public function __construct($size_x = 300, $size_y = 300, $min_x = -10, $max_x = 10, $min_y = -10, $max_y = 10) {
		$this -> size_x = $size_x;
		$this -> size_y = $size_y;
		$this -> min_x = $min_x;
		$this -> max_x = $max_x;
		$this -> min_y = $min_y;
		$this -> max_y = $max_y;
		
		// obliczenia jednorazowe
		$x_len = $this->max_x - $this->min_x;
		$y_len = $this->max_y - $this->min_y;
		
		$this -> x_delta = $this -> size_x / $x_len;
		$this -> y_delta = $this -> size_y / $y_len;
		
		// utworzenie pustego tła
		$this -> img = imagecreate($size_x, $size_y);
		
		$back = imagecolorallocate($this -> img, 255, 255, 255);
		$this -> color = imagecolorallocate($this -> img, 255, 0, 0);
		
		$this -> drawAxises();
	}
	
	public function drawPoint($x, $y) {
		list($px_x, $px_y) = $this -> getRealPoint($x, $y);
		imagesetpixel($this -> img, $px_x, $px_y, $this -> color);
	}
	
	public function output($file = null) {
		if ($file) {
			imagepng($this -> img, $file);
		} else {
			header('Content-type: image/png');
			imagepng($this -> img);
		}
	}
	
	protected function drawAxises() {
		$grey = imagecolorallocate($this -> img, 200, 200, 200);
		
		list($OX1x, $OX1y) = $this -> getRealPoint($this->min_x, 0);
		list($OX2x, $OX2y) = $this -> getRealPoint($this->max_x, 0);
		list($OY1x, $OY1y) = $this -> getRealPoint(0, $this->min_y);
		list($OY2x, $OY2y) = $this -> getRealPoint(0, $this->max_y);
		
		imageline($this -> img, $OX1x, $OX1y, $OX2x, $OX2y, $grey);
		imageline($this -> img, $OY1x, $OY1y, $OY2x, $OY2y, $grey);
	}
	
	protected function getRealPoint($x, $y) {
		return array(
			                $this -> x_delta * ($x - $this->min_x), 
			$this->size_y - $this -> y_delta * ($y - $this->min_y)
		);
	}
}

use MathParser\Parse;

if (isset($_POST['query'])) {
	$query = $_POST['query'];
	
	$x_min = -10;
	$x_max = 10;
	
	$size_x = 500;
	$size_y = 500;
	$min_x = -5; 
	$max_x = 5; 
	$min_y = -5; 
	$max_y = 5;
	
	$x_step = 0.03;
	
	try {
		$context = new Parse\Context();
		$context -> setVariable('x');
		
		$parser = new Parse\Parser($context);
		$root = $parser -> parse($query);
		
		$chart = new Chart($size_x, $size_y, $min_x, $max_x, $min_y, $max_y);
		
		for ($x=$min_x; $x<$max_x; $x+=$x_step) {
			$context -> setVariable('x', $x);
			
			$chart -> drawPoint($x, $root->getValue());
		}
		
		$chart -> output();
		
	} catch (Exception $e) {
		echo '<p style="color:red">Exception:: '.$e->getMessage().'</p>';
	}
	
} else {
	?>
	<form action="f(x).php" method="post">
		<label>f(x)=<input name="query" /></label>
		<input type="submit" value="Draw" />
	</form>
	
	<form action="f(x).php" method="post">
		f(x)=<input type="submit" name="query" value="2*x + 3" /><br/>
		f(x)=<input type="submit" name="query" value="x^2 - 1" /><br/>
		f(x)=<input type="submit" name="query" value="0.3*x^3 + x^2 - 1" />
	</form>
	
	<?php
}
