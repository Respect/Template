<?php
use \DOMText;
use \DOMDocument;
use \StdClass;
use Respect\Template\HtmlElement as H;
use Respect\Template\Adapter;

class AdapterTest extends \PHPUnit_Framework_TestCase
{
	protected $dom;
	
	public function setUp()
	{
		$this->dom = new DOMDocument('1.0', 'iso-8859-1');
	}
	public function testFactoryException()
	{
		$this->setExpectedException('UnexpectedValueException');
		Adapter::factory($this->dom, new Pdo('sqlite::memory:'));
	}
	
	
	public function instances()
	{
        $anchorObject = new StdClass();
        $anchorObject->href = 'test';
		return array(
			array('A', array('href'=>'test'), 'Replace'),
            array('A', $anchorObject, 'Replace'),
			array('Dom', new DOMText, 'CleanAppend'),
			array('String', 'Hello World!', 'CleanAppend'),
			array('Traversable', array('one', 'two', 'three', 'pigs'), 'CleanAppend'),
            array('HtmlElement', H::ul(H::li('one')), 'Replace')
		);
	}
	/**
	 * @dataProvider instances
	 */
	public function testInstances($className, $content, $decorator)
	{
		$adapter   = Adapter::factory($this->dom, $content);
		$className = 'Respect\Template\Adapters\\'.$className;
        $decorator = 'Respect\Template\Decorators\\'.$decorator;
		$this->assertInstanceOf($className, $adapter);
        $this->assertEquals($decorator, $adapter->getDecorator());
        
	}
}
