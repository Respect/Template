<?php
namespace Respect\Template\Decorators;

class CleanAppend extends AbstractDecorator
{
	protected function decorate($node, $with=null)
	{
		new Clean(array($node));
		$node->appendChild($with);
	}
}
