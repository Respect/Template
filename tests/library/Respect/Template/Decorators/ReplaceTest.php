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
		$this->dom = new simple_html_dom();//DOMDocument('1.0', 'iso-8859-1');
		$this->dom->load('');
	}

	public function testSimpleReplace()
	{
		$div  = $this->dom->createElement('div', 'it does not matter');
		$span = $this->dom->createElement('span', 'it matters');
		$this->dom->appendChild($div);
		new Decorator($div, Adapter::factory($this->dom, $span));
		$this->assertContains('<span>it matters</span>', $this->dom->save()); //XML());
	}

	protected function tearDown()
    {
        $this->dom->clear();
		unset($this->dom);
    }
}