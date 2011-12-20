<?php
use \DOMDocument;
use Respect\Template\Decorators\EmptyChildren;

class EmptyChildrenTest extends \PHPUnit_Framework_TestCase
{
	protected $dom;
	
	public function setUp()
	{
		$this->dom = new DOMDocument('1.0', 'iso-8859-1');
	}
	
	public function testSingleChild()
	{
		$ul = $this->dom->createElement('ul');
		$li = $this->dom->createElement('li');
		$ul->appendChild($li);
		
		$this->assertEquals(1, $ul->childNodes->length);
		new EmptyChildren(array($ul));
		$this->assertEquals(0, $ul->childNodes->length);
	}
	
	/**
	 * @depends testSingleChild
	 */
	public function testMultipleChildren()
	{
		$ul     = $this->dom->createElement('ul');
		$expect = 5;
		for ($i=0; $i<$expect; $i++)
			$ul->appendChild($this->dom->createElement('li'));
		
		$this->assertEquals($expect, $ul->childNodes->length);
		new EmptyChildren(array($ul));
		$this->assertEquals(0, $ul->childNodes->length, $ul->childNodes);
	}
	
}