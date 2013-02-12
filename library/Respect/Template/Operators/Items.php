<?php

namespace Respect\Template\Operators;

use DOMNode;
use Respect\Template\Operation;
use Respect\Template\Query;

/**
 * Applies operations to children of a selector
 */
class Items extends AbstractSelectorOperator
{
    /** @var string The population selector **/
    public $population;
    
    /** @var Respect\Template\Operation The list of operations for each population member **/
    public $operation = array();
    
    /**
     * @param string $selector  Selector string
     * @param string $population Population selector string
     * @param array  $operations List of operations for each matched element
     */
    public function __construct($selector, $population, Operation $operation)
    {
        $this->population = $population;
        $this->operation = $operation;
        parent::__construct($selector);
    }
    
    /**
     * Populates a single node
     *
     * @param DOMNode     $node        The target DOM node
     * @param string      $replacement Unused parameter
     *
     * @return null
     */
    public function operateNode(DOMNode $node, $replacement)
    {
        $prePopulation = Query::perform($node, $this->population);
        foreach ($prePopulation as $itemTemplate) {
            foreach ($replacement as $item) {
                $nodeClone = clone $itemTemplate;
                clone $this->operation->feed($item)->operate($nodeClone);
                $itemTemplate->parentNode->appendChild($nodeClone);
            }
            $itemTemplate->parentNode->removeChild($itemTemplate);
        }
    }
    
    /**
     * Compiles a single node population
     *
     * @param DOMNode     $node        The target DOM node
     * @param string      $name        Unused parameter
     * @param string      $replacement Unused parameter
     *
     * @return null
     */
    public function compileNode(DOMNode $node, $name, $replacement)
    {
        $subName = 'item';
        $prePopulation = Query::perform($node, $this->population);
        foreach ($prePopulation as $itemTemplate) {
            $foreachPI = $node->ownerDocument->createProcessingInstruction(
                'php',
                "foreach (\${$name} as \${$subName}Key => \${$subName}):"
            );
            $itemTemplate->parentNode->insertBefore(
                $foreachPI,
                $itemTemplate
            );
            $operation = clone $this->operation;
            $operation->name = $subName;
            $operation->feed($replacement)->compile($itemTemplate);
            $endForeachPI = $node->ownerDocument->createProcessingInstruction(
                'php',
                "endforeach;"
            );
            $itemTemplate->parentNode->insertBefore(
                $endForeachPI,
                $itemTemplate->nextSibling
            );
        }
    }
}
