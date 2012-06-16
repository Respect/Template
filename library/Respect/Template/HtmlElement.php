<?php
namespace Respect\Template;

use \DOMText;
use \DOMDocument;
class HtmlElement
{
    protected $nodeName      = '';
    protected $childrenNodes = array();
    protected $attributes    = array();

    public function __construct($name, array $children)
    {
        $this->nodeName      = $name;
        $this->childrenNodes = $children;
    }

    public function __call($attribute, $value)
    {
		$attribute = strtolower(preg_replace('/[A-Z]/', '-$0', $attribute));
        $this->attributes[$attribute] = $value[0];
        return $this;
    }

    public static function __callStatic($name, array $children)
    {
        return new static($name, $children);
    }

    public function __toString()
    {
        $children = implode($this->childrenNodes);
        $attrs    = '';
        foreach ($this->attributes as $attr => &$value)
            $attrs .= " $attr=\"$value\"";

        if (count($this->childrenNodes))
            return "<{$this->nodeName}{$attrs}>$children</{$this->nodeName}>";

        return "<{$this->nodeName}{$attrs} />";
    }

    public function getDOMNode(DOMDocument $dom, $current=null)
    {
        if (is_string($current))
            return new DOMText($current);

        $current = $current ?: $this ;
        $node    = $dom->createElement($current->nodeName);
        foreach ($current->attributes as $name=>$value)
            $node->setAttribute($name, $value);

        if (!count($current->childrenNodes))
            return $node;

        foreach ($current->childrenNodes as $child)
            $node->appendChild($this->getDOMNode($dom, $child));

        return $node;
    }
}