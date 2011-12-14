<?php
namespace Respect\Template;

use \DOMXPath;
use \Zend_Dom_Query;

class Query 
{
	/**
	 * @var string
	 */
	protected $selector;
	/**
	 * @var Respect\Template\Document
	 */
	protected $document;
	
	/**
	 * undocumented function
	 *
	 * @param 	Respect\Template\Document 	$doc 
	 * @param 	string 						$selector 
	 */
	public function __construct(Document $doc, $selector)
	{
		$this->document = $doc;
		$this->selector = $selector;
	}
	
	/**
	 * @return Zend_Dom_Query_Result
	 */
	public function getResult()
	{
		// Get results by a CSS selector
		$selector = $this->selector;
		$document = $this->document->getQueryDocument();
		$results  = $document->query($selector);
		// Return should be an array with DOMElements from the DOMDocument
		$return   = array();
		$css      = $results->getCssQuery();
		$xpath    = $results->getXpathQuery();
		$domxpath = new DOMXPath($this->document->getDom());
		$nodelist = $domxpath->query($xpath);
		foreach ($nodelist as $item) {
			$return[] = $item;
		}
		return $return;
	}
}