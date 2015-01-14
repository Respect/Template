<?php
namespace Respect\Template\Adapters;

use DOMNode;
use DOMDocument;
use UnexpectedValueException;

abstract class AbstractAdapter
{
    /**
     * @var DOMDocument
     */
    private $dom;
    protected $content;

    public function __construct(DOMDocument $dom = null, $content = null)
    {
        if (!is_null($dom)) {
            $this->dom = $dom;
        }

        if (!is_null($content)) {
            $this->content = $content;
        }
    }

    abstract public function isValidData($data);
    abstract protected function getDomNode($data, DOMNode $parent);

    public function adaptTo(DOMNode $parent, $content = null)
    {
        $content = ($content) ? $content : $this->content;

        return $this->getDomNode($content, $parent);
    }

    protected function createElement(DOMNode $parent, $name, $value = null)
    {
        if (!$this->dom instanceof DOMDocument) {
            throw new UnexpectedValueException('No DOMDocument, cannot create new element');
        }

        return $this->dom->createElement($name, $value);
    }

    final protected function hasProperty($data, $name)
    {
        if (is_array($data)) {
            return isset($data[$name]);
        }

        if (is_object($data)) {
            return isset($data->$name);
        }

        return false;
    }

    public function getDecorator()
    {
        return 'Respect\Template\Decorators\CleanAppend';
    }

    /**
     * @return DOMDocument
     */
    public function getDom()
    {
        return $this->dom;
    }

    final protected function getProperty($data, $name)
    {
        if (is_array($data)) {
            return $data[$name];
        }

        if (is_object($data)) {
            return $data->$name;
        }

        return;
    }
}
