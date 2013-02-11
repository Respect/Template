<?php

namespace Respect\Template;

use DOMXPath;
use DOMDocument;
use DOMNode;
use Zend\Dom\Css2Xpath;

/**
 * A CSS query in a document
 */
class Query 
{
	/**
	 * @var string The CSS selector
	 */
	protected $selector;
	/**
	 * @var DOMDocument The queried document
	 */
	protected $document;
	
	/**
	 * @param DOMDocument $document The queried document
	 * @param string      $selector The CSS selector
	 */
	public function __construct(DOMNode $document, $selector)
	{
		$this->document = $document;
		$this->selector = $selector;
	}
	
	
	/**
	 * Directly performs a query and return it's results
	 *
	 * @param DOMDocument $document The queried document
	 * @param string      $selector The CSS selector
	 *
	 * @return DOMNodeList The results
	 */
	public static function perform(DOMNode $document, $selector)
	{
	    $query = new Query($document, $selector);
	    return $query->getResult();
	}
	
	/**
	 * Performs the query and return it's results
	 *
	 * @return DOMNodeList The results
	 */
	public function getResult()
	{
		// Get results by a CSS selector
		$selector = $this->selector;
		$xpath    = Css2Xpath::transform($selector);
		if ($this->document instanceof DOMDocument) {
	    	$domxpath = new DOMXPath($this->document);
    		$nodelist = $domxpath->query($xpath);
		} else {
    		$domxpath = new DOMXPath($this->document->ownerDocument);
    		$nodelist = $domxpath->query(".$xpath", $this->document);
		}
		return $nodelist;
	}
}
