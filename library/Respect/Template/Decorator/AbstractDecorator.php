<?php
namespace Respect\Template\Decorator;

use \DOMNode;
use Respect\Template\Document;

abstract class AbstractDecorator
{
	final public function __construct(array $elements, $with=null)
	{
		// Decorate the given elements selected
		foreach ($elements as $element) {
			$this->decorate($element, $with);
		}
	}
	
	abstract protected function decorate(DOMNode $node, $with);
}