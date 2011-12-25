<?php
use Respect\Template\Adapters\Traversable;
class Adapter_TraversableTest extends \PHPUnit_Framework_TestCase
{
	protected $dom;
	
	public function setUp()
	{
		$this->dom = new DOMDocument('1.0', 'iso-8859-1');
	}
	
	protected function assertContainTraversables($traversables)
	{
		$xml = $this->dom->saveXml();
		foreach ($traversables as $item) {
			if (is_string($item))
				$this->assertContains($item, $xml, "'{$item}' not found in: ".$xml);
			if (is_array($item))
				$this->assertContainTraversables($item);
		}
	}
	
	public function testInstance()
	{
		$this->assertInstanceOf('Respect\Template\Adapters\AbstractAdapter', new Traversable());
	}
	
	public function testSimpleAdaptation()
	{
		$ul     = $this->dom->createElement('ul');
		$ul->setAttribute('id', 'test');
		$this->dom->appendChild($ul);
		
		$array   = array('one', 'two', 'three');
		$adapter = new Traversable($this->dom);
		$this->assertTrue($adapter->isValidData($array));
		$adapted = $adapter->adaptTo($ul, $array);
		$ul->appendChild($adapted);
		$this->assertInstanceOf('DOMDocumentFragment', $adapted);
		
		$xml = $this->dom->saveXml(); 
		$this->assertContains('<li>one</li>', $xml);
		$this->assertContains('<li>two</li>', $xml);
		$this->assertContains('<li>three</li>', $xml);
		$this->assertContains('<ul id="test">', $xml);
	}
	
	public function strings()
	{
		// Elements: tag, injector, final string 
		return array(
			array('ul', array('one', 'two'), '<li>one</li><li>two</li>'),
			array('table', array(array('1', '2')), '<tr><td>1</td><td>2</td></tr>'),
            array('h1', array('hi'), '<h1><span>hi</span></h1>')
		);
	}
	
	
	/**
	 * @dataProvider strings
	 */
	public function testMultipleAdaptations($tag, $injector, $finalString)
	{
		$node = $this->dom->createElement($tag);
		$this->dom->appendChild($node);
		
		$this->assertFalse($node->hasChildNodes());
		$adapter = new Traversable($this->dom);
		$node->appendChild($adapter->adaptTo($node, $injector));
		$this->assertTrue($node->hasChildNodes());
		$this->assertContains($finalString, $this->dom->saveXml());
	}
	
}
