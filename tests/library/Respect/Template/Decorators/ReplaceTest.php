<?php
use Respect\Template\Decorators\Replace as Decorator;
use Respect\Template\Adapter;
use \DOMDocument;

class Decorator_ReplaceTest extends \PHPUnit_Framework_TestCase
{	
	/**
	 * @var DOMDocument
	 */
	protected $dom;

	protected function setUp()
	{
		$this->dom = new DOMDocument('1.0', 'iso-8859-1');
	}

	public function testSimpleReplace()
	{
		$div  = $this->dom->createElement('div', 'it does not matter');
		$span = $this->dom->createElement('span', 'it matters');
		$this->dom->appendChild($div);
		new Decorator($div, Adapter::factory($span));
		$this->assertContains('<span>it matters</span>', $this->dom->saveXML());
	}
}