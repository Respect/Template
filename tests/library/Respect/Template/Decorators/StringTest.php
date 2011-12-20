<?php
use \DOMDocument;
use Respect\Template\Document;
use Respect\Template\Decorators\String;

class StringTest extends \PHPUnit_Framework_TestCase
{
	public function strings()
	{
		return array(
			array('Hello World!'),
		);
	}
	
	/**
	 * @dataProvider strings
	 */
	public function testWithSingleElement($with)
	{
		$doc       = new DOMDocument('1.0', 'iso-8859-1');
		$node      = $doc->createElement('div');
		$expect    = '<div>'.$with.'</div>';
		$elements  = array($node);
		$doc->appendChild($node);
		
		$this->assertFalse($node->hasChildNodes());
		new String($elements, $with);
		$this->assertTrue($node->hasChildNodes());
		$this->assertContains($expect, $doc->saveXml());
	}
}