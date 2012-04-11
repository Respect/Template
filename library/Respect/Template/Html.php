<?php
namespace Respect\Template;

use \InvalidArgumentException as Argument;
use \UnexpectedValueException as Unexpected;
use \DOMImplementation;
use \DOMDocument;
use \DOMText;
use \DOMNode;
use \ArrayObject;

class Html extends ArrayObject
{
	/**
	 * @var Respect\Template\Document
	 */
	protected $document;
	public $aliasFor = array();
	
	public function __construct($templateFileOrString)
	{
		if (file_exists($templateFileOrString))
			$content = file_get_contents($templateFileOrString);
		else
			$content = $templateFileOrString;
		$this->document = new Document($content);
	}

	/**
	 * @see self::find()
	 * @return array
	 */
	public function offsetGet($selector)
	{
		return $this->find($selector);
	}

	public function __toString()
	{
		return $this->render();
	}

	public function inheritFrom(Html $model, $blockSelector, $anotherSelector=null, $etc=null)
	{
		$selectors = array_slice(func_get_args(), 1);
		foreach ($selectors as $selector)
			foreach ($model->find($selector) as $modelNode)
				foreach ($this->find($selector) as $targetNode)
					$targetNode->parentNode->replaceChild(
						$this->document->getDom()->importNode($modelNode, true),
						$targetNode
					);
	}

	public function getDocument()
	{
		return $this->document;
	}

	/**
	 * @return array
	 */
	public function find($selector)
	{
		$query = new Query($this->document, $selector);
		return $query->getResult();
	}
	
	public function render($data=null, $beatiful=false)
	{
		foreach ($this->aliasFor as $selector => $alias)
			$this[$selector] = $this[$alias];
		
		$data = $data ?: $this->getArrayCopy();
		return $this->document->decorate($data)->render($beatiful);
	}
}