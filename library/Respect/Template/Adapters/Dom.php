<?php
namespace Respect\Template\Adapters;

use DOMNode;

class Dom extends AbstractAdapter
{
    public function isValidData($data)
    {
        return ($data instanceof DOMNode);
    }

    protected function getDomNode($data, DOMNode $parent)
    {
        return $data;
    }
}
