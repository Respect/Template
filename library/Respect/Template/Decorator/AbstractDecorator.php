<?php
namespace Respect\Template\Decorator;

use \DOMNode;
use Respect\Template\Document;

abstract class AbstractDecorator
{
	final public function __construct(array $elements, $with)
	{
		// Decorate the given elements selected
		foreach ($elements as $element) {
			$this->emptyChildNodes($element);
			$this->decorate($element, $with);
		}
	}
	protected function emptyChildNodes(DOMNode $node)
	{
		foreach ($node->childNodes as $child)
			$node->removeChild($child);
	}
	
	abstract protected function decorate(DOMNode $node, $with);
}