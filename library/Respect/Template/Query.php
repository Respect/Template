<?php
namespace Respect\Template;

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
	}
}
