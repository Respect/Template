<?php
use \DOMDocument;
use Respect\Template\Adapter as Factory;
use Respect\Template\Adapters\HtmlElement as Adapter;
use Respect\Template\HtmlElement as H;

class Adapters_HtmlElementTest extends \PHPUnit_Framework_TestCase
{
    protected $dom;
    
    public function setUp()
    {
        $this->dom = new DOMDocument('1.0', 'iso-8859-1');
    }
    
    public function testInstance()
    {
        $expected = 'Respect\Template\Adapters\AbstractAdapter';
        $this->assertInstanceOf($expected, new Adapter());
    }
    
    public function testFactory()
    {
        $test     = Factory::factory($this->dom, H::ul());
        $expected = 'Respect\Template\Adapters\HtmlElement';
        $this->assertInstanceOf($expected, $test);
    }
    
    public function testDecorator()
    {
        $expected = 'Respect\Template\Decorators\Replace';
        $adapter  = new Adapter();
        $this->assertEquals($expected, $adapter->getDecorator());
    }
    
    public function testAdaptation()
    {
        $parent   = $this->dom->createElement('div');
        $expected = $this->dom->createElement('ul');
        $base     = H::ul();
        $adapter  = Factory::factory($this->dom, $base);
        $this->assertInstanceOf('Respect\Template\Adapters\HtmlElement', $adapter);
        $this->assertEquals($expected, $adapter->adaptTo($parent));
    }
}