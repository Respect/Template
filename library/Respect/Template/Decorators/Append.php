<?php
namespace Respect\Template\Decorators;

class Append extends AbstractDecorator
{
	protected function decorate($node, $with=null)
	{
		$node->appendChild($with);
	}
}
