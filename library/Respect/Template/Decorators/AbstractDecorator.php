<?php
namespace Respect\Template\Decorators;

use \DOMNode;
use \InvalidArgumentException as Argument;
use \UnexpectedValueException as Unexpected;
use Respect\Template\Document;
use Respect\Template\Adapters\AbstractAdapter as Adapter;
use Respect\Template\Query;

abstract class AbstractDecorator
{
	final public function __construct($elements, Adapter $with=null)
	{
		if ($elements instanceof DOMNode)
			$elements = array($elements);

		if ($elements instanceof Query)
			$elements = $elements->getResult();
		
		if (!is_array($elements))
			throw new Argument('Query or Array expected to decorate');
		
		// Decorate the given elements selected
		foreach ($elements as $element) {
			if (!$element instanceof DOMNode)
				throw new Unexpected('DOMNode expected for decoration');
			
			if (!is_null($with))
				$with = $with->adaptTo($element);
			$this->decorate($element, $with);
		}
	}
	
	abstract protected function decorate(DOMNode $node, DOMNode $with=null);
}