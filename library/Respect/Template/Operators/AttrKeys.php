<?php

namespace Respect\Template\Operators;

use DOMNode;
use Respect\Template\Operation;
use Respect\Template\Query;

/**
 * Populates attributes based on replacement array/object keys
 */
class AttrKeys extends AbstractSelectorOperator
{
    /** @var array The list of keys to be applied **/
    public $keys = array();
        
   /**
     * @param string $selector   Selector string
     * @param array  $operations List of keys to be applied
     */
    public function __construct($selector, array $keys)
    {
        $this->keys = $keys;
        parent::__construct($selector);
    }
    
    /**
     * Populates attronites for a single node with replacement keys
     *
     * @param DOMNode     $node        The target DOM node
     * @param string      $replacement Unused parameter
     *
     * @return null
     */
    public function operateNode(DOMNode $node, $replacement)
    {
        foreach ($replacement as $itemKey => $item) {
            if (in_array($itemKey, $this->keys)) {
                $operator = new Attr($itemKey);
                $operator->operate($node, $item);
            } elseif (isset($this->keys[$itemKey])) {
                $operator = new Attr($this->keys[$itemKey]);
                $operator->operate($node, $item);
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
        foreach ($this->keys as $name => $key) {
            if (is_int($name)) {
                $operator = new Attr($key);
                $operator->compile($node, $key, $replacement);
            } else {
                $operator = new Attr($name);
                $operator->compile($node, $name, $replacement);
            }
        }
    }
}
