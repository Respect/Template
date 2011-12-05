<?php
use \DOMDocument;
use Respect\Template\Decorator\Text;

class TextTest extends \PHPUnit_Framework_TestCase
{
	public function testConstructor()
	{
		$value    = 'Hello';
		$document = new DOMDocument('1.0', 'utf-8');
		$object   = new Text($value, $document);
		$this->assertAttributeEquals($document, 'document', $object);
		$this->assertEquals($document, $object->getDocument());
		$this->assertInstanceOf('Respect\Template\Decorator\AbstractDecorator', $object);
		$this->assertEquals($value, $object->getNode()->textContent);
	}
}