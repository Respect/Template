<?php
use Respect\Template\Decorator\ListItem;
use \DOMDocument;

class ListItemTest extends \PHPUnit_Framework_TestCase
{
	public function testConstructor()
	{
		$value    = array('Hello');
		$document = new DOMDocument('1.0', 'utf-8');
		$object   = new ListItem($value, $document);
		$this->assertAttributeEquals($document, 'document', $object);
		$this->assertEquals($document, $object->getDocument());
		$this->assertInstanceOf('Respect\Template\Decorator\AbstractDecorator', $object);
	}
}