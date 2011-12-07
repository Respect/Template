<?php
use Respect\Template\Html;

class HtmlTest extends \PHPUnit_Framework_TestCase
{
	public function constructs()
	{
		return array(
			array('<div id="test">_</div>', array('test'=>'Hi'), '<div id="test">_Hi</div>'),
			array('<div id="test">_</div>', array('test'=>array('A','B')), '<div id="test">_<li>A</li><li>B</li></div>')
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