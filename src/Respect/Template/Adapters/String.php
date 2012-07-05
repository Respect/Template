<?php
namespace Respect\Template\Adapters;

use \DOMNode;
use \DOMText;
use \ReflectionObject;
use Respect\Template\Document;
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
	
	protected function getDomNode($data, DOMNode $parent)
	{
		return new DOMText($data);
	}
}