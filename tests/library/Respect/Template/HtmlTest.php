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
	public function testTemplateWithArrayObject($template, $data, $expected)
	{
		$view = new Html($template);
		foreach ($data as $key=>$val)
			$view[$key] = $val;
		
		$this->assertEquals($data, $view->getArrayCopy(), 'ArrayObject did not work to set data for template');
		$this->assertContains($expected, (string) $view);
	}
	
	public function testArrayAccessInterface()
	{
		$template = new Html('<div id="one"></div>');
		$this->assertInstanceOf('ArrayAccess', $template);
		$this->assertFalse(isset($template['one']));
		$template['one'] = 'one';
		$this->assertTrue(isset($template['one']));
		$this->assertEquals('one', $template['one']);
		unset($template['one']);
		$this->assertFalse(isset($template['one']));
	}

	public function testResolveAliases()
	{
		$v = new Html("<!DOCTYPE html>\n<html><body><h1><span></span></h1></body></html>\n");
		$v->aliasFor["h1 > span"] = "pagetitle";
		$v["pagetitle"] = "FooBar";
		$this->assertEquals("<!DOCTYPE html>\n<html><body><h1><span>FooBar</span></h1></body></html>\n", (string) $v);
	}

	public function testSimpleInheritance()
	{
		$template = new Html("<!DOCTYPE html>\n<html><body><h1></h1><div>My Text</div></body></html>\n");
		$model = new Html("<!DOCTYPE html>\n<html><body><h1><span><a>Hi!</a></span></h1></body></html>\n");
		$template->inheritFrom($model, "h1");
		$this->assertEquals("<!DOCTYPE html>\n<html><body><h1><span><a>Hi!</a></span></h1><div>My Text</div></body></html>\n", (string) $template);
	}

	public function testMultiInheritance()
	{
		$template = new Html("<!DOCTYPE html>\n<html><body><h1></h1><div>My Text</div><h1></h1></body></html>\n");
		$model = new Html("<!DOCTYPE html>\n<html><body><h1><span><a>Hi!</a></span></h1></body></html>\n");
		$template->inheritFrom($model, "h1");
		$this->assertEquals("<!DOCTYPE html>\n<html><body><h1><span><a>Hi!</a></span></h1><div>My Text</div><h1><span><a>Hi!</a></span></h1></body></html>\n", (string) $template);
	}

}