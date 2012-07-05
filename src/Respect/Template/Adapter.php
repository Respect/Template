<?php
namespace Respect\Template;

use Respect\Template\Adapters\AbstractAdapter;
use \DOMNode;
use \DOMDocument;
use \UnexpectedValueException as Unexpected;
class Adapter
{
	private static $instance;
	protected $adapters;
	
	private function __construct()
	{
		$adapters       = array('HtmlElement', 'A', 'Dom', 'Traversable', 'String');
		foreach ($adapters as $className) {
			$class                  = 'Respect\Template\Adapters\\'.$className;
			$this->adapters[$class] = new $class();
		}
	}
	
	public static function getInstance()
	{
		if (self::$instance instanceof Adapter)
			return self::$instance;
		
		return self::$instance = new Adapter();
	}
	
	public static function factory(DOMDocument $dom, $content)
	{
		return self::getInstance()->_factory($dom, $content);
	}
	
	public function _factory(DOMDocument $dom, $content)
	{
		if ($content instanceof AbstractAdapter)
			return $content;
		
		foreach ($this->adapters as $class=>$object)
			if ($object->isValidData($content))
				return new $class($dom, $content);
		
		$type  = gettype($content);
		$type .= (!is_object($type)) ? '' : ' of class '.get_class($content);
		throw new Unexpected('No adapter found for '.$type);
	}
}