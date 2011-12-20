<?php
namespace Respect\Template\Adapters;

use \DOMNode;
use \DOMText;
use Respect\Template\Document;
class String extends AbstractAdapter
{
	public function isValidData($data)
	{
		return is_string((string) $data);
	}
	
	protected function getDomNode($data, DOMNode $parent)
	{
		return new DOMText($data);
	}
}