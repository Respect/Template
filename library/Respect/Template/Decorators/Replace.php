<?php
namespace Respect\Template\Decorators;

use \DOMNode;
use \UnexpectedValueException as Unexpected;
class Replace extends AbstractDecorator
{
	protected function decorate(DOMNode $node, DOMNode $with=null)
	{
		$old    = $node;
		$new    = $old->ownerDocument->importNode($with, true);
		$return = $old->parentNode->replaceChild($new, $old);
		if ($return !== $old)
			throw new Unexpected('Unable to replace node');
	}
}
