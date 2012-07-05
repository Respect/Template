<?php
namespace Respect\Template;

use \DOMDocument;
use \DOMImplementation;
use \DOMXPath;
use \InvalidArgumentException as Argument;
use \UnexpectedValueException as Unexpected;
use Zend\Dom\Query as DomQuery;
use \simple_html_dom as simple_html_dom;

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
	private $html;
	/**
	 * @var Zend_Dom_Query
	 */
//	private $queryDocument;

	/**
	 * @param 	string	$htmlDocument
	 */
	public function __construct($htmlDocument)
	{
		$this->html = new simple_html_dom();
		$this->html->load($htmlDocument);
//		$this->dom = new DOMDocument();
//		$this->dom->strictErrorChecking = false;
//		$this->dom->loadHtml($htmlDocument);
	}

    function __destruct()
    {
        $this->html->clear();
		unset($this->html);
    }

	/**
	 * @return DOMDocument
	 */
	public function getDom()
	{
		return $this->html;
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
                $adapter = Adapter::factory($this->getDom(), $with);

                if ($selector == 'head') // be a good citizen append to <head>
                        $decorator = 'Respect\Template\Decorators\Append';
                else
                        $decorator = $decorator ?: $adapter->getDecorator();

                $query = new Query($this, $selector);

                new $decorator($query, $adapter);
            }
            return $this;
	}

	/**
	 * Returns the XML representation of the current DOM tree.
	 *
	 * @return 	string
	 */
	public function render($beautiful=false)
	{

//		$this->dom->formatOutput = $beautiful;
//		return $this->dom->saveHTML();
		return $this->html->save();
	}

	/**
	 * Returns XML to be parsed by CSS the selector.
	 * This will never be the final XML to be rendered.
	 *
	 * @return string
	 */
	public function getQueryDocument()
	{
		return $this->html;
//		if (!$this->queryDocument)
//			return $this->queryDocument = new DomQuery($this->render());
//
//		return $this->queryDocument;
	}
}