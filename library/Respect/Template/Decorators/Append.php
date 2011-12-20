<?php
namespace Respect\Template\Decorators;

use \DOMNode;
use \DOMText;
use \InvalidArgumentException as Argument;

class Append extends AbstractDecorator
{
	protected function decorate(DOMNode $node, $with)
	{
		$node->appendChild($with);
	}
}