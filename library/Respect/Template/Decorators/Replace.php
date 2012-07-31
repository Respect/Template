<?php
namespace Respect\Template\Decorators;

class Replace extends AbstractDecorator
{
	protected function decorate($node, $with = null)
	{
		$node->outertext = (string)$with;
	}
}
