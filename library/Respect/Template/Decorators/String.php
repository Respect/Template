<?php
namespace Respect\Template\Decorators;

use \DOMNode;
use \DOMText;
use \InvalidArgumentException as Argument;

class String extends AbstractDecorator
{
	protected function decorate(DOMNode $node, $with)
	{
		if (!is_string($with))
			throw new Argument('String required as content to decorate, given '.gettype($with));
		
		new EmptyChildren(array($node));
		$node->appendChild(new DOMText($with));
	}
}