<?php
use Respect\Template\Adapters\String;

class Adapter_StringTest extends \PHPUnit_Framework_TestCase
{
	protected $dom;
	
	public function setUp()
	{
		$this->dom = new DOMDocument('1.0', 'iso-8859-1');
	}
	
	public function testInstance()
	{
		$this->assertInstanceOf('Respect\Template\Adapters\AbstractAdapter', new String());
	}
	
	public function testSimpleAdaptation()
	{
		$div     = $this->dom->createElement('div');
		$div->setAttribute('id', 'test');
		$this->dom->appendChild($div);
		
		$string  = 'This is a simple string';
		$adapter = new String();
		$this->assertTrue($adapter->isValidData($string));
		$adapted = $adapter->adaptTo($div, $string);
		$div->appendChild($adapted);
		$this->assertInstanceOf('DOMText', $adapted);
		$this->assertContains('<div id="test">This is a simple string</div>', $this->dom->saveXml());
	}
}