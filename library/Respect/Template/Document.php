<?php
namespace Respect\Template;

use \DOMDocument;
use \DOMImplementation;
use \DOMXPath;
use \InvalidArgumentException as Argument;
use \UnexpectedValueException as Unexpected;
use Zend\Dom\Query as DomQuery;
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
		$this->dom = new DOMDocument();
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
	 * @param 	array 	            $data
	 * @param   string[optional]    $decorator  Class to be used as decorator
	 * @return 	Respect\Template\Document
	 */
	public function decorate(array $data, $decorator = null)
	{
		foreach ($data as $selector=>$with) {
			$adapter   = Adapter::factory($this->getDom(), $with);
			$decorator = $decorator ?: $adapter->getDecorator();
			$query     = new Query($this, $selector);
			new $decorator($query, $adapter);
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
		return $this->dom->saveHTML();
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