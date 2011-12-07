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
	protected $dom;
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
	 * Returns the DOMDocument that will be the result of the templating.
	 *
	 * @return DOMDocument
	 */
	protected function getDocument()
	{
		if (!$this->dom instanceof DOMDocument) {
			$docId     = "-//W3C//DTD XHTML 1.0 Transitional//EN";
			$docDtd    = "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd";
			$dom       = new DOMImplementation();
			$doctype   = $dom->createDocumentType("html", $docId, $docDtd);
			$this->dom = $dom->createDocument();
			$this->dom->formatOutput = true;
		}
		return $this->dom;
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
			return $this->getDocument()->loadHTMLFile($mixed);
			
		return $this->getDocument()->loadHTML($mixed);
	}
	
	/**
	 * Applies the given data to this template.
	 *
	 * @param array $data 
	 */
	protected function applyData(array $data)
	{
		foreach ($data as $id=>$value) {
			$element = $this->getDocument()->getElementById($id);
			if (!$element instanceof DOMNode)
				throw new Unexpected('Selected element "'.$id.'" is not valid');

			switch (true) {
				case (is_string($value)):
					$class = 'Respect\Template\Decorator\Text';
					break;
				case (is_array($value)):
					$class = 'Respect\Template\Decorator\ListItem';
					break;
				default:
					throw new Unexpected('No decorator set for: '.gettype($value));
					break;
			}
			$decorated = new $class($value, $this->dom);
			$decorated->appendInto($element);
		}
	}
	
	
	public function render($data=null)
	{	
		$data = $data ?: $this->data ;
		$this->applyData($data);
		return $this->getDocument()->saveXML();
	}
}