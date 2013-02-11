<?php

namespace Respect\Template\Operators;

use DOMNode;

/**
 * Sets an attribute on the selected nodes
 */
class Attr extends AbstractAttributeOperator
{
    /**
     * Sets an attribute in each node matched by this operator
     * 
     * @param DOMNode $node        One of the nodes to be operated
     * @param mixed   $replacement Value of the attribute
     *
     * @see Respect\Template\AbstractSelectorOperator::operate
     */
    public function operateNode(DOMNode $node, $replacement)
    {
        $node->setAttribute($this->attribute, $replacement);
    }
    
    /**
     * Compiles an attribute setter in each node matched by this operator
     * 
     * @param DOMNode $node        One of the nodes to be operated
     * @param mixed   $replacement Value of the attribute
     *
     * @see Respect\Template\AbstractSelectorOperator::compile
     */
    public function compileNode(DOMNode $node, $name, $replacement)
    {
        $node->setAttribute(
            $this->attribute, 
            '{DECODE}<?php echo $'.$name.';?>{/DECODE}');
    }
}
