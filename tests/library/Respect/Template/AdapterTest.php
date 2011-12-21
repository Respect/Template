<?php
use Respect\Template\Adapter;

class AdapterTest extends \PHPUnit_Framework_TestCase
{
	public function testFactoryException()
	{
		$this->setExpectedException('UnexpectedValueException');
		Adapter::factory(new Pdo('sqlite::memory:'));
	}
}
