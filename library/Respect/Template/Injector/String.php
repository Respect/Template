<?php
namespace Respect\Template\Injector;

use \DOMNode;
use \DOMText;
use \InvalidArgumentException as Argument;

class String extends AbstractInjector
{
	protected function inject(DOMNode $node, $with)
	{
		if (!is_string($with))
			throw new Argument('String required as content to inject');
		
		new EmptyChildren(array($node));
		$node->appendChild(new DOMText($with));
	}
}