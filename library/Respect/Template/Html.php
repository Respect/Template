<?php

namespace Respect\Template;

use ArrayObject;
use DOMDocument;

/**
 * An HTML template
 */
class Html extends ArrayObject
{
    /** @var DOMDocument Real document instance */
	public $document;
	
	/**
	 * @param mixed $template Any HTML data
	 */
	public function __construct($template)
	{
		if (file_exists($template)) {
			$content = file_get_contents($template);
		} else {
			$content = $template;
		}
		
		$this->document = new DOMDocument;
		$this->document->strictErrorChecking = false;
		$this->document->loadHtml($content);
	}

    /** Renders the template and return it */
	public function __toString()
	{
		return $this->render();
	}
	
	/**
	 * Gets/Registers an operation to be performed on this template
	 *
	 * @param string $alias The name of this operation
	 *
	 * @return Respect\Template\Operation The operation object
	 *
	 * @see Respect\Template\Operation
	 * @see Respect\Template\Operation::$name
	 */
	public function offsetGet($alias)
	{
	    return $this->registerOperation($alias);
	}
	
	/**
	 * Gets/Registers an operation to be performed on this template
	 *
	 * @param string $alias The name of this operation
	 *
	 * @return Respect\Template\Operation The operation object
	 *
	 * @see Respect\Template\Html::offsetGet
	 * @see Respect\Template\Operation
	 * @see Respect\Template\Operation::$name
	 */
	public function registerOperation($alias)
	{
	    if (!isset($this[$alias])) {
	        parent::offsetSet($alias, new Operation($alias));
	    }
	    return parent::offsetGet($alias);
	}
	
	/**
	 * Feeds an operation with replacement data
	 * 
	 * @param string $alias       The name of the operation to be fed
	 * @param mixed  $replacement The replacement data for the operation
	 *
	 * @return null
	 
	 * @see Respect\Template\Operation::feed
	 */
	public function offsetSet($alias, $replacement)
	{
	    $this[$alias]->feed($replacement);
	}

    /**
     * Performs a CSS query in this document and return the matching nodes
     *
     * @param string $selector Any CSS2 Selector
     *
     * @return DOMNodeList A list of matching nodes
	 
	 * @see Respect\Template\Query
	 * @see Respect\Template\Query::getResult
     */
	public function find($selector)
	{
		$query = new Query($this->document, $selector);
		return $query->getResult();
	}
	
	/**
	 * Applies operations and returns the rendered output
	 *
	 * @param bool $beautiful True if output should be formatted
	 * 
	 * @return string The HTML output
	 *
	 * @see Respect\Template\Operation::operate
	 * @see Respect\Template\Operators\AbstractOperator::operate
	 */
	public function render($data=array(), $beautiful=false)
	{
	    foreach ($data as $name => $value) {
	        $this->offsetSet($name, $value);
	    }
	    foreach ($this->getArrayCopy() as $operation) {
	        $operation($this->document);
	    }
		$this->document->formatOutput = $beautiful;
		return $this->document->saveHTML();
	}
	
	/**
	 * Applies operations and returns the rendered output
	 * 
	 * @return string The HTML output
	 *
	 * @see Respect\Template\Operation::operate
	 * @see Respect\Template\Operators\AbstractOperator::operate
	 */
	public function __invoke($data=array())
	{
		return $this->document->render($data);
	}
	
	/**
	 * Applies operations compiled as HTML Process Instructions compatible
	 * with PHP code. Useful for caching templates in raw PHP.
	 *
	 * @param bool $beautiful True if output should be formatted
	 *
	 * @return string Raw PHP code that can be run
	 *
	 * @see Respect\Template\Operation::compile
	 * @see Respect\Template\Operators\AbstractOperator::compile
	 */
	public function compile($beautiful=false)
	{
	    foreach ($this->getArrayCopy() as $operation) {
	        $operation->compile($this->document);
	    }
		$this->document->formatOutput = $beautiful;
		return preg_replace_callback(
		    '#\{DECODE\}(.*?)\{\/DECODE\}#', 
		    function ($matches) {
		        return html_entity_decode($matches[1]);
		    }, 
		    $this->document->saveHTML()
		);
	}
	
	public static function __callStatic($operator, $args)
	{
	    $operation = new Operation(null);
	    return call_user_func_array(array($operation, $operator), $args);
	}
}
