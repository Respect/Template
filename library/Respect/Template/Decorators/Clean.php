<?php
namespace Respect\Template\Decorators;

class Clean extends AbstractDecorator
{
	protected function decorate($node, $with=null)
	{
		$node->nodes = array();
		$node->children = array();
	}
}
