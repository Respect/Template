<?php
namespace Respect\Template\Decorator;

use DOMNode;

class EmptyChildren extends AbstractDecorator
{
	protected function decorate(DOMNode $node, $with)
	{
		$remove = array();
		foreach ($node->childNodes as $child)
			$remove[] = $child;
		
		foreach ($remove as $child)
			$node->removeChild($child);
	}
}