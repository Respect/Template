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
		$this->setTemplate($templateFileOrString);
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

	public function find($selector)
	{
		$query = new Query($this->document, $selector);
		return $query->getResult();
	}
	
	/**
	 * Defines the template string or file and parses it with the DOMDocument.
	 *
	 * @param 	string 	$mixed	An HTML string or filename
	 * @return 	void
	 */
	protected function setTemplate($mixed)
	{
		if (file_exists($mixed))
			$content = file_get_contents($mixed);
		else
			$content = $mixed;

		$this->document = new Document($content);
	}
	
	public function render($data=null, $beatiful=false)
	{
		$this->resolveAliases();
		$data = $data ?: $this->getArrayCopy();
		return $this->document->decorate($data)->render($beatiful);
	}

	protected function resolveAliases()
	{
		foreach ($this->aliasFor as $selector => $alias)
			$this[$selector] = $this[$alias];
	}
}