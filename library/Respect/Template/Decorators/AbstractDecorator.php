<?php
namespace Respect\Template\Decorators;

use InvalidArgumentException as Argument;
use Respect\Template\Adapters\AbstractAdapter as Adapter;
use Respect\Template\Query;
use simple_html_dom as simple_html_dom;
use simple_html_dom_node as simple_html_dom_node;

abstract class AbstractDecorator
{
    abstract protected function decorate($node, $with=null);

    final public function __construct($elements, Adapter $with=null)
	{
		if ($elements instanceof simple_html_dom_node
		|| $elements instanceof simple_html_dom)
				$elements = array($elements);

		if ($elements instanceof Query)
			$elements = $elements->getResult();

		if (!is_array($elements))
			throw new Argument('Query or Array expected to decorate');

		// Decorate the given elements selected
		foreach ($elements as $element) {
			if (!is_null($with))
				$with = $with->adaptTo($element);
			$this->decorate($element, $with);
		}
	}
}
