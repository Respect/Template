<?php
namespace Respect\Template\Decorator;

use \DOMNode;
use \DOMText;
class Text extends AbstractDecorator
{
	protected function decorate($content, $parent=null)
	{
		return new DOMText($content);
	}
}