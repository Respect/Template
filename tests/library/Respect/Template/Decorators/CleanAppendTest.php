<?php
use Respect\Template\Decorators\CleanAppend as Decorator;
use Respect\Template\Adapter;
use \DOMDocument;
use \DOMNode;
class ReplaceTest extends \PHPUnit_Framework_TestCase
{
	protected $dom;

	public function setUp()
	{
		$this->dom = new simple_html_dom();// new DOMDocument('1.0', 'iso-8859-1');
		$this->dom->load('');
	}

	public function traversables()
	{
		return array(
			array(array('one', 'two', 'three')),
		);
	}

	/**
	 * @dataProvider traversables
	 */
	public function testInjectingOnAUl($with)
	{
		$ul = $this->dom->createElement('ul');
		for ($i=3; $i>0; $i--)
			$ul->appendChild($this->dom->createElement('li', 'test'));
		$this->dom->appendChild($ul);


		$this->assertTrue($ul->hasChildNodes());
		$this->assertEquals('<ul><li>test</li><li>test</li><li>test</li></ul>', (string) $ul);
		new Decorator(array($ul), Adapter::factory($this->dom, $with));
		$this->assertEquals('<ul><li>one</li><li>two</li><li>three</li></ul>', (string) $ul);
		$this->assertTrue($ul->hasChildNodes());
	}

	protected function tearDown()
    {
        $this->dom->clear();
		unset($this->dom);
    }
}