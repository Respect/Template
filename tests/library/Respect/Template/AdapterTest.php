<?php
use Respect\Template\Adapter;

use \DOMText;
use \DOMDocument;
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
		return array(
			array('A', array('href'=>'test')),
			array('Dom', new DOMText),
			array('String', 'Hello World!'),
			array('Traversable', array('one', 'two', 'three', 'pigs'))
		);
	}
	/**
	 * @dataProvider instances
	 */
	public function testInstances($className, $content)
	{
		$adapter   = Adapter::factory($this->dom, $content);
		$className = 'Respect\Template\Adapters\\'.$className;
		$this->assertInstanceOf($className, $adapter);
	}
}
