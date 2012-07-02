<?php
namespace Respect\Template\Adapters;

// use \DOMNode;
use Respect\Template\Adapter;
use \simple_html_dom as simple_html_dom;

class Traversable extends AbstractAdapter
{
	public function isValidData($data)
	{
		return is_array($data);
	}

	protected function getDomNode($data, $parent) //DOMNode $parent)
	{
		$tag       = $this->getChildTag($parent);
		$container = new simple_html_dom(); //$parent->ownerDocument->createDocumentFragment();
		$container = $container->load('');
		foreach ($data as $analyse) {
			$value  = (is_array($analyse)) ? null : $analyse ;
			$child  = $this->createElement($parent, $tag, $value);
			$container->appendChild($child);
			if (is_array($analyse))
				$child->appendChild($this->getDomNode($analyse, $child));
		}
		return $container;
	}

	protected function getChildTag($node) //DOMNode $node)
	{
		switch ($node->nodeName()) {
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
                        case 'head':
                                return '';
                                break;
                        default:
				return 'span';
				break;
		}
	}

}