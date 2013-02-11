<?php

namespace Respect\Template\Operators;

use DOMNode;
use DOMDocument;
use Respect\Template\Query;

/**
 * An operation that replaces text on specific selectors
 */
class Text extends AbstractSelectorOperator
{
    /**
     * Replaces any content in a single node by a text
     *
     * @param DOMNode     $node        The target DOM node
     * @param string      $replacement The text to be placed
     *
     * @return null
     */
    public function operateNode(DOMNode $node, $replacement)
    {
        $clear = new Clear($this->selector);
        $clear->operate($node, $replacement);
        $node->appendChild($node->ownerDocument->createTextNode($replacement));
    }
    
    /**
     * Replaces any content in a single node by a PHP code that replaces
     * that content to a text.
     *
     * @param DOMNode     $node        The target DOM node
     * @param string      $name        Name of the operation
     * @param string      $replacement The text to be placed
     *
     * @return null
     */
    public function compileNode(DOMNode $node, $name, $replacement)
    {
        $clear = new Clear($this->selector);
        $clear->compile($node, $name, $replacement);
        $pi = $node->ownerDocument->createProcessingInstruction(
            'php', "echo \${$name};?"
        );
        $node->appendChild($pi);
    }
}
