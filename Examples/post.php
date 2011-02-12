<?php
/**
 * MathParser simple use example.
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

$query = '';

if (isset($_POST['query'])) {
	$query = $_POST['query'];
	
	$parser = new MathParser\Parse\Parser();
	
	try {
		$root = $parser -> parse($query);
		
		echo 
		'<ul>
			<li>Calculated value: <strong>'.$root->getValue().'</strong></li>
			<li>Infix notation: <strong>'.$root->toInfixString().'</strong></li>
			<li>Postfix notation (<a href="http://en.wikipedia.org/wiki/Reverse_Polish_notation">RPN</a>): <strong>'.$root->toPostfixString().'</strong></li>
		</ul>';
		
	} catch (Exception $e) {
		echo '<p style="color:red">Exception: '.$e->getMessage().'</p>';
	}
}

?>

<form action="post.php" method="post">
	<input name="query" value="<?php echo htmlspecialchars($query, ENT_QUOTES) ?>" />
	<input type="submit" value="Calculate" />
</form>
