<?php
namespace Respect\Template;

use \DOMDocument;
use \DOMImplementation;
use \DOMXPath;
use \Zend_Dom_Query;
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
	 * Constructor for document to be queries later on.
	 *
	 * @param 	string	$htmlDocument 
	 */
	public function __construct($htmlDocument)
	{
		$docId     = "-//W3C//DTD XHTML 1.0 Transitional//EN";
		$docDtd    = "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd";
		$dom       = new DOMImplementation();
		$doctype   = $dom->createDocumentType("html", $docId, $docDtd);
		$this->dom = $dom->createDocument();
		$this->dom->loadHtml($htmlDocument);
	}
	
	public function getDom()
	{
		return $this->dom;
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
			return $this->queryDocument = new Zend_Dom_Query($this->render());

		return $this->queryDocument;
	}
}