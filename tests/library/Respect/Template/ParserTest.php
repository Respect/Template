<?php
use Respect\Template\Parser;

class ParsesTest extends \PHPUnit_Framework_TestCase
{
	public function constructs()
	{
		return array(
			array('<div id="test"></div>', array('test'=>'Hi'), '<div id="test">Hi</div>')
		);
	}
	
	/**
	 * @dataProvider constructs
	 */
	public function testTemplates($template, $data, $expected)
	{
		$view   = new Parser($template);
		$result = $view->render($data);
		$this->assertContains($expected, $result);
	}
	
	/**
	 * @expectedException UnexpectedValueException
	 */
	public function testNonExistingDecoratorStrategy()
	{
		$parser = new Parser('<div id="test"></div>');
		$parser->render(array('test'=>new StdClass));
	}
}