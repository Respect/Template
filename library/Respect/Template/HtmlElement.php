<?php
namespace Respect\Template;

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
}