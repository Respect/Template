<?php
use Respect\Template\Decorators\CleanAppend as Decorator;
use Respect\Template\Adapter;
use \DOMDocument;
use \DOMNode;
class ReplaceTest extends \PHPUnit_Framework_TestCase
{	
	protected $dom;
	
	public function setUp()
	{
		$this->dom = new DOMDocument('1.0', 'iso-8859-1');
	}
	
	public function traversables()
	{
		return array(
			array(array('one', 'two', 'three')),
		);
	}
	
	/**
	 * @dataProvider traversables
	 */
	public function testInjectingOnAUl($with)
	{
		$ul = $this->dom->createElement('ul');
		for ($i=3; $i>0; $i--)
			$ul->appendChild($this->dom->createElement('li', 'test'));
		$this->dom->appendChild($ul);
		
		
		$this->assertTrue($ul->hasChildNodes());
		new Decorator(array($ul), Adapter::factory($this->dom, $with));
		$this->assertTrue($ul->hasChildNodes());
	}
}