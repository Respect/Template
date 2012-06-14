<?php
use \StdClass;
use Respect\Template\Adapters\A as Adapter;
use Respect\Template\Adapter as A;

class Adapter_ATest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var DOMDocument
	 */
	protected $dom;

	public function setUp()
	{
		$this->dom = new simple_html_dom();// new DOMDocument('1.0', 'iso-8859-1');
		$this->dom->load('');
	}

	public function testReplaceDecorator()
	{
		$object = new Adapter();
		$class  = $object->getDecorator();
		$this->assertEquals('Respect\Template\Decorators\Replace', $class);
	}

	public function testSimpleAdaptation()
	{
		$href    = '#top';
		$from    = array('href'=>$href);
		$adapter = A::factory($this->dom, $from);
		$this->assertInstanceOf('Respect\Template\Adapters\A', $adapter);
		$to      = $adapter->adaptTo($this->dom);
//		$this->assertInstanceOf('DOMElement', $to);
		$this->assertTrue($to->hasAttribute('href'));
		$this->assertEquals($href, $to->getAttribute('href'));
	}

    public function testAdaptationWithInnerHtml()
    {
        $std            = new StdClass();
        $std->href      = '#top';
        $std->innerHtml = 'Top';
        $adapter        = A::factory($this->dom, $std);
        $this->assertInstanceOf('Respect\Template\Adapters\A', $adapter);
//        $to             = $adapter->adaptTo($this->dom);
////        $this->assertInstanceOf('DOMElement', $to);
//        $this->assertTrue($to->hasAttribute('href'));
//echo "\n\n\n\n\n\n\n\n". $this->dom->createElement('div', 'enately cool shit');
//echo "\n\n\n\n\n\n\n\n". $this->dom->createElement('div');
//        $expected       = $this->dom->createElement('a', 'Top');
//        $expected->setAttribute('href', '#top');
//        $this->assertEquals($expected, $to);
    }

	protected function tearDown()
    {
        $this->dom->clear();
		unset($this->dom);
    }
}
