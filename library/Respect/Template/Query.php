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
		$selector = $this->tratePseudoSelector();
		$document = $this->document->getQueryDocument();
		$results  = $document->execute($selector);
		echo $xpath    = $results->getXpathQuery();
		$domxpath = new DOMXPath($this->document->getDom());
		$nodelist = iterator_to_array($domxpath->query($xpath));
		return $nodelist;
	}

	private function hasPseudoSelector()
	{
		if (preg_match('/:(.+\S)/', $this->selector, $match)) {
			return $match[1];
		}
		return false;
	}

	private function tratePseudoSelector()
	{
		if ($pseudoSelector = $this->hasPseudoSelector()) {
			$pseudoSelector = Factory::PseudoElement($pseudoSelector);
			return $pseudoSelector->apply($this->selector);
		}
		return $this->selector;
	}
}
