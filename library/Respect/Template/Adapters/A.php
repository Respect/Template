<?php
namespace Respect\Template\Adapters;

use \DOMNode;
use Respect\Template\Document;

class A extends AbstractAdapter
{
	public function isValidData($data)
	{
		$keys = array('href');
		foreach ($keys as $key)
			if ($this->hasProperty($data, $key))
				return true;
		return false;
	}
	
	protected function getDomNode($data, DOMNode $parent)
	{
		$element = $doc->createElement($a);
		$element->setAttribute('href', $this->getProperty($data, 'href'));
		return $element;
	}
}