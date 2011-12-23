<?php
use Respect\Template\HtmlElement as H;

class HtmlElementTest extends \PHPUnit_Framework_TestCase
{
	public function setUp()
	{
	
	}
	
	public function testEmptyElement()
	{
		$empty = H::div();
		$this->assertEquals('<div />', (string) $empty);
	}
	
	public function testAttributesOnlyElement()
	{
		$input = H::input()->type('text')->id('test');
		$this->assertEquals('<input type="text" id="test" />', (string) $input);
	}
	
	public function testAttributesAndChildren()
	{
		$div = H::div('Uhull')->id('test');
		$this->assertEquals('<div id="test">Uhull</div>', (string) $div);
	}
	
	public function testChildrenAsHtmlElement()
	{
		$ul = H::ul(
				H::li('one'),
				H::li('two')
			  );
		$this->assertEquals('<ul><li>one</li><li>two</li></ul>', (string) $ul);
	}
}