<?php

namespace Respect\Template\Operators;

use DOMNode;
use Respect\Template\Operation;
use Respect\Template\Query;

/**
 * Populates elements based on replacement array/object keys
 */
class Keys extends AbstractOperator
{
    /** @var array The list of operations for each population member **/
    public $operations;
    
   /**
     * @param string $selector   Selector string
     * @param array  $operations List of operations for each matched element
     */
    public function __construct(Operation $operation)
    {
        $this->operation = $operation;
    }
    
    /**
     * Populates a single node with replacement keys
     *
     * @param DOMNode     $node        The target DOM node
     * @param string      $replacement Unused parameter
     *
     * @return null
     */
    public function operate(DOMNode $node, $replacement)
    {
        foreach ($replacement as $itemKey => $item) {
            clone $this->operation->feed($itemKey)->operate($node);
        }
    }
    
    /**
     * Compiles a single node population for replacement keys
     *
     * @param DOMNode     $node        The target DOM node
     * @param string      $name        Unused parameter
     * @param string      $replacement Unused parameter
     *
     * @return null
     */
    public function compile(DOMNode $node, $name, $replacement)
    {
        return $this->operateNode($node, $replacement);
    }
}
