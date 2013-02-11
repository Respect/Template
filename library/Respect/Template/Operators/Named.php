<?php

namespace Respect\Template\Operators;

use DOMNode;
use Respect\Template\Operation;
use Respect\Template\Query;

/**
 * Populates elements based on replacement array/object keys
 */
class Named extends AbstractSelectorOperator
{
    /** @var array The list of operations for each population member **/
    public $operations = array();
    
   /**
     * @param string $selector   Selector string
     * @param array  $operations List of operations for each matched element
     */
    public function __construct($selector, array $operations)
    {
        $this->operations = $operations;
        parent::__construct($selector);
    }
    
    /**
     * Populates a single node with replacement keys
     *
     * @param DOMNode     $node        The target DOM node
     * @param string      $replacement Unused parameter
     *
     * @return null
     */
    public function operateNode(DOMNode $node, $replacement)
    {
        foreach ($replacement as $itemKey => $item) {
            if (isset($this->operations[$itemKey])) {
                clone $this->operations[$itemKey]->feed($item)->operate($node);
            }
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
    public function compileNode(DOMNode $node, $name, $replacement)
    {
        return $this->operateNode($node, $replacement);
    }
}
