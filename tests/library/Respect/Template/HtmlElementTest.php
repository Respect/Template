<?php
use \DOMDocument;
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
    
    public function testGetDomNode()
    {
        $dom = new DOMDocument('1.0', 'iso-8859-1');
        $ul  = $dom->createElement('ul');
        $ul->appendChild($dom->createElement('li', 'one'));
        $ul->appendChild($dom->createElement('li', 'two'));
        
        $_ul = H::ul(H::li('one'), H::li('two'));
        $this->assertEquals($ul, $_ul->getDOMNode($dom));
    }
}