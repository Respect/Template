<?php
use Respect\Template\Html;

class HtmlTest extends \PHPUnit_Framework_TestCase
{
	public function constructs()
	{
		return array(
			array('<ul id="test">_</ul>', array('#test'=>'Hi'), '<ul id="test">Hi</ul>'),
			array('<ul id="test">_</ul>', array('#test'=>array('A','B')), '<ul id="test"><li>A</li><li>B</li></ul>')
		);
	}
	
	/**
	 * @dataProvider constructs
	 */
	public function testSetTemplate($template, $data, $expected)
	{
		$view = new Html($template);
		$out  = $view->render();
		$this->assertContains($template, $out, "Output does not have the defined template: {$out}");
	}
	
	/**
	 * @depends testSetTemplate
	 * @dataProvider constructs
	 */
	public function testPassingDataToRender($template, $data, $expected)
	{
		$view   = new Html($template);
		$result = $view->render($data);
		$this->assertContains($expected, $result);
	}
	
	/**
	 * @depends testPassingDataToRender
	 * @dataProvider constructs
	 */
	public function testTemplateWithArrayAccess($template, $data, $expected)
	{
		$view = new Html($template);
		foreach ($data as $key=>$val)
			$view[$key] = $val;
		
		$this->assertAttributeEquals($data, 'data', $view, 'ArrayAccess did not work to set data for template');
		$this->assertContains($expected, $view->render());
	}
	
	/**
	 * @expectedException UnexpectedValueException
	 */
	public function testNonExistingDecoratorStrategy()
	{
		$parser = new Html('<div id="test"></div>');
		$parser->render(array('test'=>new Pdo('sqlite::memory:')));
	}
}