<?php
namespace Respect\Template\Decorators;

use \DOMNode;
use \InvalidArgumentException as Argument;
use Respect\Template\Document;
use Respect\Template\Adapters\AbstractAdapter as Adapter;
use Respect\Template\Query;

abstract class AbstractDecorator
{
	final public function __construct($elements, $with=null)
	{
		if ($elements instanceof Query)
			$elements = $elements->getResult();
		if (!is_array($elements))
			throw new Argument('Query or Array expected as elements to decorate');
		// Decorate the given elements selected
		foreach ($elements as $element) {
			$this->decorate($element, $with);
		}
	}
	
	abstract protected function decorate(DOMNode $node, $with);
}