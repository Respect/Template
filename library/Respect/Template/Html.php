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
	/**#@+
	* Constants to define the docnype of the document.
	*
	* @see Document
	* @author nickl- <nick@jigsoft.co.za>
	*/
	const HTML_5 = Document::HTML_5;
	const HTML_4_01_STRICT = Document::HTML_4_01_STRICT;
	const HTML_4_01_TRANSITIONAL = Document::HTML_4_01_TRANSITIONAL;
	const HTML_4_01_FRAMESET = Document::HTML_4_01_FRAMESET;
	const XHTML_1_0_Strict = Document::XHTML_1_0_Strict;
	const XHTML_1_0_TRANSITIONAL = Document::XHTML_1_0_TRANSITIONAL;
	const XHTML_1_0_FRAMESET = Document::XHTML_1_0_FRAMESET;
	const XHTML_1_1 = Document::XHTML_1_1;
	const XHTML_1_1_BASIC = Document::XHTML_1_1_BASIC;
	const HTML_2_0 = Document::HTML_2_0;
	const HTML_3_2 = Document::HTML_3_2;
	const XHTML_1_0_BASIC = Document::XHTML_1_0_BASIC;
	/**#@-*/

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

	/**
	 * Returns the HTML document.
	 *
	 * @param array   $data     - The data to render
	 * @param boolean $beatiful - To pretty print or not
	 * @param string  $doctype  - The doctype of this html
	 * @return string
	 */
	public function render($data=null, $beatiful=false, $doctype='')
	{
		foreach ($this->aliasFor as $selector => $alias)
			$this[$selector] = $this[$alias];

		$data = $data ?: $this->getArrayCopy();
		return $this->document->decorate($data)->render($beatiful, $doctype);
	}
}