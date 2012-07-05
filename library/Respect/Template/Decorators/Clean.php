<?php
namespace Respect\Template\Decorators;

use \DOMNode;

class Clean extends AbstractDecorator
{
	protected function decorate($node, $with=null) //DOMNode $node, DOMNode $with=null)
	{
		$node->nodes = array();
		$node->children = array();
//		$remove = array();
//		foreach ($node->childNodes as $child)
//			$remove[] = $child;
//
//		foreach ($remove as $child)
//			$node->removeChild($child);
	}
}