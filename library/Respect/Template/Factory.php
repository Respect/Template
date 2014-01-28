<?php
namespace Respect\Template;

use Respect\Template\PseudoElements;

final class Factory
{
	private function __construct(){}

	public static function PseudoElement($type)
	{
		if ('first-child' == $type)
			return new PseudoElements\FirstChild();
	}
}