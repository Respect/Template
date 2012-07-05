<?php
use \DOMDocument;
use Respect\Template\Decorators\Clean;


class CleanTest extends \PHPUnit_Framework_TestCase
{
	protected $dom;

	public function setUp()
	{
		$this->dom = new simple_html_dom();// new DOMDocument('1.0', 'iso-8859-1');
		$this->dom->load('');
	}

	public function testSingleChild()
	{
		$ul = $this->dom->createElement('ul');
		$li = $this->dom->createElement('li');
		$ul->appendChild($li);

		$this->assertEquals(1, count($ul->children));// $ul->childNodes->length);
		new Clean(array($ul));
		$this->assertEquals(0, count($ul->children));// $ul->childNodes->length);
		$this->assertEquals('<ul></ul>', (string) $ul);
	}

	/**
	 * @depends testSingleChild
	 */
	public function testMultipleChildren()
	{
		$ul     = $this->dom->createElement('ul');
		$expect = 5;
		for ($i=0; $i<$expect; $i++)
			$ul->appendChild($this->dom->createElement('li'));

		$this->assertEquals($expect, count($ul->children));// $ul->childNodes->length);
		new Clean(array($ul));
		$this->assertEquals(0, count($ul->children), $ul->childNodes()); //$ul->childNodes->length, $ul->childNodes);
		$this->assertEquals('<ul></ul>', (string) $ul);
	}

	protected function tearDown()
    {
        $this->dom->clear();
		unset($this->dom);
    }
}