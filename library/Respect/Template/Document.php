<?php
namespace Respect\Template;

//use \InvalidArgumentException as Argument;
//use \UnexpectedValueException as Unexpected;
use simple_html_dom as simple_html_dom;

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
	 * @var simple_html_dom
	 */
	private $html;

	/**
	 * @param 	string	$htmlDocument
	 */
	public function __construct($htmlDocument)
	{
		$this->html = new simple_html_dom();
		$this->html->load($htmlDocument);
	}

    function __destruct()
    {
        $this->html->clear();
		unset($this->html);
    }

	/**
	 * @return simple_html_dom
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
	}
}
