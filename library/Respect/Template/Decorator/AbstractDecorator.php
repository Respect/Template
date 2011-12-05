<?php
namespace Respect\Template\Decorator;

use \DOMDocument;
use \DOMNode;
use \UnexpectedValueException as Unexpected;
abstract class AbstractDecorator
{
	private $node;
	protected $document;
	
	abstract protected function decorate($content, $parent=null);
	
	final public function __construct($content, DOMDocument $document, $parent=null)
	{
		$this->document = $document;
		$this->node     = $this->decorate($content, $parent);
	}
	
	final public function getDocument()
	{
		return $this->document;
	}
	
	final public function getNode()
	{
		if (!$this->node instanceof DOMNode)
			throw new Unexpected('Decorated object should be a DOMNode');

		return $this->node;
	}
	
	final public function appendInto(DOMNode $parent)
	{
		$parent->appendChild($this->getNode());
	}
}