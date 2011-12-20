<?php
namespace Respect\Template\Decorators;

use \DOMNode;
use \UnexpectedValueException as Value;
use \InvalidArgumentException as Argument;
class Traversable extends AbstractDecorator
{
	protected function decorate(DOMNode $node, $with)
	{
		if (!is_array($with))
			throw new Argument('Traversable decorator requires an array');
		
		new EmptyChildren(array($node));
		$tag = $this->getContainerElement($node);
		foreach ($with as $element) {
			$value = (is_array($element)) ? null : $element ;
			$child = $node->ownerDocument->createElement($tag, $value);
			$node->appendChild($child);
			if (is_array($element))
				$this->decorate($child, $element);
		}
	}
	
	protected function getContainerElement(DOMNode $node)
	{
		$tag = $node->nodeName;
		switch ($tag) {
			case 'ol':
			case 'ul':
			case 'li':
				return 'li';
				break;
			case 'tbody':
			case 'table':
			case 'thead':
				return 'tr';
				break;
			case 'tr':
				return 'td';
				break;
			default:
				throw new Value('Unknow container element strategy: '.$tag);
				break;
		}
	}
}