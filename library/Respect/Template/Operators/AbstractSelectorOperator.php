<?php

namespace Respect\Template\Operators;

use DOMNode;
use DOMDocument;
use Respect\Template\Query;

/**
 * An abstract class for all operations that use selectors
 */
abstract class AbstractSelectorOperator extends AbstractOperator
{
    /** @var string The selector string **/
    public $selector;
    
    abstract function operateNode(DOMNode $node, $replacement);
    abstract function compileNode(DOMNode $node, $name, $replacement);
    
    /**
     * Operates in a node
     * 
     * @param DOMNode $context     The node to be operated
     * @param mixed   $replacement Replacement data
     *
     * @return null
     *
     * @see Respect\Template\Operators\AbstractOperator::operateNode
     * @see Respect\Template\Operators\AbstractOperator::__invoke
     */
    public function operate(DOMNode $context, $replacement)
    {
        if (is_null($this->selector)) {
            $this->operateNode($context, $replacement);
        } else {
            $nodes = Query::perform($context, $this->selector);
            foreach ($nodes as $node) {
                $this->operateNode($node, $replacement);
            }
        }
    }
    
    /**
     * Compiles operation in a node
     * 
     * @param DOMNode  $context     The node to be compile
     * @param mixed    $name        Name of the operation
     * @param mixed    $replacement Replacement data
     *
     * @return null
     *
     * @see Respect\Template\Operators\AbstractOperator::compileNode
     */
    public function compile(DOMNode $context, $name, $replacement)
    {
        if (is_null($this->selector)) {
            $this->compileNode($context, $name, $replacement);
        } else {
            $nodes = Query::perform($context, $this->selector);
            foreach ($nodes as $node) {
                if (!is_null($replacement)) {
                    $this->operateNode($node, $replacement);
                } else {
                    $this->compileNode($node, $name, $replacement);
                }
            }
        }
    }
      
    /**
     * @param string $selector The selector string 
     *
     * @see Respect\Template\Query
     */
    public function __construct($selector=null)
    {
        $this->selector = $selector;
    }
    
}
