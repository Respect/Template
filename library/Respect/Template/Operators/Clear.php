<?php

namespace Respect\Template\Operators;

use DOMNode;

/**
 * Makes the selected DOM nodes empty
 */
class Clear extends AbstractSelectorOperator
{
    /**
     * Makes a single node empty
     *
     * @param DOMNode     $node        The target DOM node
     * @param string      $replacement Unused parameter
     *
     * @return null
     */
    public function operateNode(DOMNode $node, $replacement)
    {
        while ($node->firstChild) {
            $node->removeChild($node->firstChild);
        }
    }
    
    /**
     * Makes a single node empty
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
