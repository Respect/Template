<?php
namespace Respect\Template;

use \InvalidArgumentException as Argument;
use \UnexpectedValueException as Unexpected;
use \DOMImplementation;
use \DOMDocument;
use \DOMText;
use \DOMNode;
use \ArrayAccess;

class Html implements ArrayAccess
{
	/**
	 * @var Respect\Template\Document
	 */
	protected $document;
	
	protected $data = array();
	
	public function __construct($template)
	{
		$this->setTemplate($template);
	}
	
	public function __toString()
	{
		return $this->render($this->data);
	}
	
	public function offsetExists($offset)
	{
		return isset($this->data[$offset]);
	}
	
	public function offsetGet($offset)
	{
		return $this->data[$offset];
	}
	
	public function offsetSet($offset, $value)
	{
		$this->data[$offset] = $value;
	}
	
	public function offsetUnset($offset)
	{
		unset($this->data[$offset]);
	}
	
	/**
	 * Defines the template string or file and parses it with the DOMDocument.
	 *
	 * @param 	string 	$mixed	An HTML string or filename
	 * @return 	void
	 */
	protected function setTemplate($mixed)
	{
		if (file_exists($mixed))
			$content = file_get_contents($mixed);
		else
			$content = $mixed;

		$this->document = new Document($content);
	}
	
	protected function decorate(array $data=null)
	{
		$data = $data ?: $this->data;
		foreach ($data as $selector=>$with) {
			switch(true) {
				case (is_string($with)):
					$class = 'String';
					break;
				case (is_array($with)):
					$class = 'Traversable';
					break;
				default:
					$type = gettype($with);
					throw new Unexpected('No decorator set for: '.$type);
					break;
			}
			$class = 'Respect\Template\Decorator\\'.$class;
			$query = new Query($this->document, $selector);
			new $class($query->getResult(), $with);
		}
	}
	
	public function render($data=null, $beatiful=false)
	{	
		$this->decorate($data);
		return $this->document->render($beatiful);
	}
}