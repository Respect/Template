<?php
namespace Respect\Template\Decorator;

use \DOMNode;
use \DOMText;
use \InvalidArgumentException as Argument;

class String extends AbstractDecorator
{
	protected function decorate(DOMNode $node, $with)
	{
		if (!is_string($with))
			throw new Argument('String required as decorator content');

		$node->appendChild(new DOMText($with));
	}
}