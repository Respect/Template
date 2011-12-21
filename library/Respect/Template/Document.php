<?php
namespace Respect\Template;

use \DOMDocument;
use \DOMImplementation;
use \DOMXPath;
use \InvalidArgumentException as Argument;
use \UnexpectedValueException as Unexpected;
use \Zend\Dom\Query as DomQuery;
/**
 * Normalizes HTMl into a valid DOM XML document.
 *
 * @package Respect\Template
 * @uses	Zend_Dom_Query
 * @author 	Augusto Pascutti <augusto@phpsp.org.br>
 */
class Document
{
	/**
	 * @var DOMDocument
	 */
	private $dom;
	/**
	 * @var Zend_Dom_Query
	 */
	private $queryDocument;
	
	/**
	 * @param 	string	$htmlDocument 
	 */
	public function __construct($htmlDocument)
	{
		$doc       = (string) $htmlDocument;
		if (empty($doc))
			throw new Argument('HTML string expected, none given');

		$docId     = "-//W3C//DTD XHTML 1.0 Transitional//EN";
		$docDtd    = "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd";
		$dom       = new DOMImplementation();
		$doctype   = $dom->createDocumentType("html", $docId, $docDtd);
		$this->dom = $dom->createDocument();
		$this->dom->loadHtml($htmlDocument);
	}
	
	/**
	 * @return DOMDocument
	 */
	public function getDom()
	{
		return $this->dom;
	}
	
	/**
	 * Replaces this dom content with the given array. 
	 * The array structure is: $array['Css Selector to Eelement'] = 'content';
	 * 
	 * @param 	array 	$data
	 * @return 	Respect\Template\Document
	 */
	public function decorate(array $data, $decorator = 'Replace')
	{
		foreach ($data as $selector=>$with) {
			$class = 'Respect\Template\Decorators\\'.$decorator;
			$query = new Query($this, $selector);
			new $class($query, Adapter::factory($with));
		}
		return $this;
	}
	
	/**
	 * Returns the XML representation of the current DOM tree.
	 *
	 * @return 	string
	 */
	public function render($beatiful=false)
	{
		$this->dom->formatOutput = $beatiful;
		return $this->dom->saveXml();
	}
	
	/**
	 * Returns XML to be parsed by CSS the selector.
	 * This will never be the final XML to be rendered.
	 *
	 * @return string
	 */
	public function getQueryDocument()
	{
		if (!$this->queryDocument)
			return $this->queryDocument = new DomQuery($this->render());

		return $this->queryDocument;
	}
}