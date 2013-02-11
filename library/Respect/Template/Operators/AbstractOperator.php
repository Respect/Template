<?php

namespace Respect\Template\Operators;

use DOMNode;

/**
 * An abstract operation on several nodes of a document
 */
abstract class AbstractOperator
{
    abstract function operate(DOMNode $context, $replacement);
    abstract function compile(DOMNode $context, $replacement, $name);
    
    /**
     * Operates in a node
     * 
     * @param DOMNode $context     The node to be operated
     * @param mixed   $replacement Replacement data
     *
     * @return null
     *
     * @see Respect\Template\Operators\AbstractOperator::operateNode
     * @see Respect\Template\Operators\AbstractOperator::operate
     */
    public function __invoke(DOMNode $context, $replacement)
    {
        return $this->operate($context, $replacement);
    }
}
