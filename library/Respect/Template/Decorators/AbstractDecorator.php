<?php
namespace Respect\Template\Decorators;

use DOMNode;
use InvalidArgumentException;
use UnexpectedValueException;
use Respect\Template\Adapters\AbstractAdapter as Adapter;
use Respect\Template\Query;

abstract class AbstractDecorator
{
    final public function __construct($elements, Adapter $with = null)
    {
        if ($elements instanceof DOMNode) {
            $elements = array($elements);
        }

        if ($elements instanceof Query) {
            $elements = $elements->getResult();
        }

        if (!is_array($elements)) {
            throw new InvalidArgumentException('Query or Array expected to decorate');
        }

        // Decorate the given elements selected
        foreach ($elements as $element) {
            if (!$element instanceof DOMNode) {
                throw new UnexpectedValueException('DOMNode expected for decoration');
            }

            if (!is_null($with)) {
                $with = $with->adaptTo($element);
            }
            $this->decorate($element, $with);
        }
    }

    abstract protected function decorate(DOMNode $node, DOMNode $with = null);
}
