<?php
namespace Respect\Template\Decorator;

use \DOMDocument;
use \DOMDocumentFragment;
use \DOMElement;
use \InvalidArgumentException as Argument;
use \UnexpectedValueException as Unexpected;

class ListItem extends AbstractDecorator
{
	protected function decorate($content, $parent=null)
	{
		if (!is_array($content))
			throw new Argument('ListItem decorator requires an array');

		if (!$this->getDocument() instanceof DOMDocument)
			throw new Unexpected('No DOMDocument defined for decorator');

		$dom = $this->getDocument()->createDocumentFragment();
		foreach ($content as $value=>$innerHTML) {
			$element = $this->getDocument()->createElement('li', $innerHTML);
			$dom->appendChild($element);
		}
		return $dom;
	}
}