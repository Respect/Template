<?php

namespace Respect\Template\Operators;

use DOMNode;
use DOMDocument;
use Respect\Template\Query;

/**
 * An abstract class for all operations that use selectors
 */
abstract class AbstractAttributeOperator extends AbstractSelectorOperator
{
    /** @var string The attribute name **/
    public $attribute;
    
   /**
     * @param string $selector  The selector string 
     * @param string $attribute The attribute name
     *
     * @see Respect\Template\Query
     */
    public function __construct($attribute, $selector = null)
    {
        $this->attribute = $attribute;
        parent::__construct($selector);
    }
    
}
