<?php
namespace Respect\Template\Adapters;

use \DOMNode;
use \UnexpectedValueException as Unexpected;

abstract class AbstractAdapter
{	
	protected $content;
	
	public function __construct($content=null)
	{
		if (!is_null($content))
			$this->content=$content;
	}
	
	abstract public function isValidData($data);
	abstract protected function getDomNode($data, DOMNode $parent);
	
	protected function createElement(DOMNode $parent, $name, $value=null)
	{
		return $parent->ownerDocument->createElement($name, $value);
	}
	
	final protected function hasProperty($data, $name)
	{
		if (is_array($data))
			return isset($data['$name']);
		if (is_object($data))
			return isset($data->$name);
		return false;
	}
	
	final protected function getProperty($data, $name)
	{
		if (is_array($data))
			return $data['$name'];
		if (is_object($data))
			return $data->$name;
		return null;
	}
	
	public function adaptTo(DOMNode $parent, $content=null)
	{
		$content = ($content) ? $content : $this->content;
		return $this->getDomNode($content, $parent);
	}
	
	public function getDecorator()
	{
		return 'Respect\Template\Decorators\CleanAppend';
	}
}