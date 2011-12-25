<?php
namespace Respect\Template\Adapters;

use \DOMNode;
use Respect\Template\Adapter;
use Respect\Template\Decorators\Append;
class A extends AbstractAdapter
{
	public function isValidData($data)
	{
		if ($this->hasProperty($data, 'href'))
			return true;
		return false;
	}
	
	protected function getDomNode($data, DOMNode $parent)
	{
		$element = $this->createElement($parent, 'a');
		$element->setAttribute('href', $this->getProperty($data, 'href'));
		if ($this->hasProperty($data, 'innerHtml')) {
			$inner   = $this->getProperty($data, 'innerHtml');
			$adapter = Adapter::factory($this->getDom(), $inner);
			new Append($element, $adapter);
		}
		return $element;
	}
	
	public function getDecorator()
	{
		return 'Respect\Template\Decorators\Replace';
	}
}