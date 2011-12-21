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
	
	public function __construct($templateFileOrString)
	{
		$this->setTemplate($templateFileOrString);
	}
	
	public function __toString()
	{
		return $this->render();
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
	
	public function render($data=null, $beatiful=false)
	{	
		$data = $data ?: $this->data;
		return $this->document->decorate($data)->render($beatiful);
	}
}