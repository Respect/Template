<?php

namespace Respect\Template;

use ReflectionClass;
use DOMDocument;
use DOMNode;

/**
 * An encapsulated list of named operators and it's operands (values)
 */
class Operation
{
    /**
     * @var string Name for this operation
     *
     * @see Respect\Template\Html::registerOperation
     */
    public $name;
    /**
     * @var array List of operators in this operation
     * 
     * @see Respect\Template\Operation::__call
     * @see Respect\Template\Operation::registerOperator
     */
    public $operators = array();
    /**
     * @var mixed Replacement data for this operation
     */
    public $replacement = null;
    
    /**
     * @param string $operation The operation name
     */
    public function __construct($operation)
    {
        $this->name = $operation;
    }
    
    /**
     * Registers an operation
     *
     * @param string $operation The operation name
     * @param array  $args      Operation constructor args
     *
     * @see Respect\Template\Operators
     * @see Respect\Template\Operation::registerOperator
     */
    public function __call($operation, $args)
    {
        $this->registerOperator($operation, $args);
        return $this;
    }
    
    /**
     * Registers an operation
     *
     * @param string $operation The operation name
     * @param array  $args      Operation constructor args
     *
     * @see Respect\Template\Operators
     * @see Respect\Template\Operation::__call
     */
    public function registerOperator($operation, $args)
    {
        $mirror = new ReflectionClass('Respect\\Template\\Operators\\'.ucfirst($operation));
        $operator = $mirror->newInstanceArgs($args);
        $this->operators[] = $operator;
        return $operation;
    }
    
    /**
     * Feeds this operation with replacement data
     * 
     * @param mixed $replacement Replacement data
     *
     * @return Respect\Template\Operation The operation itself
     */
    public function feed($replacement)
    {
        $this->replacement = $replacement;
        return $this;
    }
    
    /**
     * Operates this in any node
     *
     * @param DOMNode $context Context to be operated on
     *
     * @return DOMNode The operated context instance
     *
     * @see Respect\Template\Operation::operate
     */
    public function __invoke(DOMNode $context)
    {
        return $this->operate($context);
    }
    
    /**
     * Operates this in any node
     *
     * @param DOMNode $context Context to be operated on
     *
     * @return DOMNode The operated context instance
     *
     * @see Respect\Template\Operation::__invoke
     */
    public function operate(DOMNode $context)
    {
        foreach ($this->operators as $operator) {
            $operator($context, $this->replacement);
        }
        return $context;
    }
    
    /**
     * Compile this operation as PHP Process Instructions on the Document
     *
     * @param DOMNode $context Document to be compiled on
     *
     * @return DOMNode The compiled document instance
     *
     * @see Respect\Template\Operation::compile
     */
    public function compile(DOMNOde $context)
    {
        foreach ($this->operators as $operator) {
            $operator->compile($context, $this->name, $this->replacement);
        }
        return $context;
    }
}
