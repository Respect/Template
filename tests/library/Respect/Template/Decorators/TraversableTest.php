<?php
use Respect\Template\Decorators\Traversable;
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
	
	public function strings()
	{
		// Elements: tag, injector, final string 
		return array(
			array('ul', array(array('one', 'two')), '<li>one</li><li>two</li>'),
			array('table', array(array('one', 'two')), '<tr><td>one</td><td>two</td></tr>'),
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
	public function testInjectingOnAUl($with)
	{
		$ul = $this->dom->createElement('ul');
		$this->dom->appendChild($ul);
		$this->assertFalse($ul->hasChildNodes());
		new Traversable(array($ul), $with);
		$this->assertTrue($ul->hasChildNodes());
		$this->assertContainTraversables($with);
	}
	
	/**
	 * @dataProvider strings
	 */
	public function testFinalResultWithInjector($tag, $injector, $finalString)
	{
		$node = $this->dom->createElement($tag);
		$this->dom->appendChild($node);
		$this->assertFalse($node->hasChildNodes());
		new Traversable(array($node), $injector);
		$this->assertTrue($node->hasChildNodes());
		$this->assertContains($finalString, $this->dom->saveXml());
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