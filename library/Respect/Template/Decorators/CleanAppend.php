<?php
namespace Respect\Template\Decorators;

use DOMNode;

class CleanAppend extends AbstractDecorator
{
    protected function decorate(DOMNode $node, DOMNode $with = null)
    {
        new Clean(array($node));
        $node->appendChild($with);
    }
}
