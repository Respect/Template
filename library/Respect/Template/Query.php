<?php
namespace Respect\Template;

use \DOMXPath;

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
	 * @return array
	 */
	public function getResult()
	{

		// Get results by a CSS selector
		$selector = $this->selector;
		$document = $this->document->getQueryDocument();
		return $document->find($selector);
//		$results  = $document->execute($selector);
//		$xpath    = $results->getXpathQuery();
//		$domxpath = new DOMXPath($this->document->getDom());
//		$nodelist = iterator_to_array($domxpath->query($xpath));
//		return $nodelist;
	}
}