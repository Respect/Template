<?php
namespace Respect\Template\Injector;

use \DOMNode;
use Respect\Template\Document;

abstract class AbstractInjector
{
	final public function __construct(array $elements, $with=null)
	{
		// Decorate the given elements selected
		foreach ($elements as $element) {
			$this->inject($element, $with);
		}
	}
	
	abstract protected function inject(DOMNode $node, $with);
}