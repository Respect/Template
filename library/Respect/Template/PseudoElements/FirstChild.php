<?php
namespace Respect\Template\PseudoElements;

class FirstChild implements PseudoElementsInterface
{
	public function apply($selector)
	{
		return preg_replace('/:(.+\S)/', '[1]', $selector);
	}
}