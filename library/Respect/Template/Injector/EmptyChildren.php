<?php
namespace Respect\Template\Injector;

use \DOMNode;

class EmptyChildren extends AbstractInjector
{
	protected function inject(DOMNode $node, $with)
	{
		$remove = array();
		foreach ($node->childNodes as $child)
			$remove[] = $child;
		
		foreach ($remove as $child)
			$node->removeChild($child);
	}
}