<?php
namespace Respect\Template\Adapters;

use ReflectionObject;
use Respect\Template\Document;
use simple_html_dom as simple_html_dom;

class String extends AbstractAdapter
{
	public function isValidData($data)
	{
		if (is_string($data))
			return true;
		if (!is_object($data))
			return false;
		$reflection = new ReflectionObject($data);
		return $reflection->hasMethod('__toString');
	}

	protected function getDomNode($data, $parent)
	{
		$html = new simple_html_dom();
		return $html->createTextNode($data);
	}
}
