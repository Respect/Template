<?php
namespace Respect\Template\Decorators;

use \DOMNode;
use \UnexpectedValueException as Value;
use \InvalidArgumentException as Argument;
class Replace extends AbstractDecorator
{
	protected function decorate(DOMNode $node, $with)
	{
		new Clean(array($node));
		$node->appendChild($with);
	}
}