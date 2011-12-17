<?php
use Respect\Template\Decorator\Traversable;
use \DOMDocument;
use \DOMNode;
class TraversableTest extends \PHPUnit_Framework_TestCase
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
			array(array('one', array('two-1', 'two-2'), 'three')),
		);
	}
	
	protected function assertContainTraversables($traversables)
	{
		$xml = $this->dom->saveXml();
		foreach ($traversables as $item) {
			if (is_string($item))
				$this->assertContains($item, $xml);
			if (is_array($item))
				$this->assertContainTraversables($item);
		}
	}
	
	/**
	 * @dataProvider traversables
	 */
	public function testListDecorator($with)
	{
		$ul = $this->dom->createElement('ul');
		$this->dom->appendChild($ul);
		$this->assertFalse($ul->hasChildNodes());
		new Traversable(array($ul), $with);
		$this->assertTrue($ul->hasChildNodes());
		$this->assertContainTraversables($with);
	}
	
	public function testFinalString()
	{
		$ul = $this->dom->createElement('ul');
		$this->dom->appendChild($ul);
		$this->assertFalse($ul->hasChildNodes());
		new Traversable(array($ul), array('one', 'two'));
		$this->assertTrue($ul->hasChildNodes());
		$expect = '<li>one</li><li>two</li>';
		$this->assertContains($expect, $this->dom->saveXml());
	}
	
	/**
	 * @expectedException UnexpectedValueException
	 */
	public function testUnkownContainerElementStrategy()
	{
		$bad = $this->dom->createElement('script');
		new Traversable(array($bad), array('one', 'two'));
	}
}