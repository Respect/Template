<?php
namespace Respect\Template\Adapters;

//use \DOMNode;
use \simple_html_dom_node as simple_html_dom_node;
use \simple_html_dom as simple_html_dom;

class Dom extends AbstractAdapter
{
	public function isValidData($data)
	{
		return ($data instanceof simple_html_dom) || ($data instanceof simple_html_dom_node);// //($data instanceof DOMNode);
	}

	protected function getDomNode($data, $parent)//DOMNode $parent)
	{
		return $data;
	}
}
