<?php
namespace Respect\Template\Decorators;

use DOMNode;

class Append extends AbstractDecorator
{
    protected function decorate(DOMNode $node, DOMNode $with = null)
    {
        $node->appendChild($with);
    }
}
