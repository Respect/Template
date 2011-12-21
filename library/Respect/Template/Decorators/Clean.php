<?php
namespace Respect\Template\Decorators;

use \DOMNode;

class Clean extends AbstractDecorator
{
	protected function decorate(DOMNode $node, DOMNode $with=null)
	{
		$remove = array();
		foreach ($node->childNodes as $child)
			$remove[] = $child;
		
		foreach ($remove as $child)
			$node->removeChild($child);
	}
}