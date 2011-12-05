<?php
namespace Respect\Template;

use \InvalidArgumentException as Argument;
use \UnexpectedValueException as Unexpected;
use \DOMDocument;
use \DOMText;
use \DOMNode;

class Parser
{
	protected $dom;
	
	public function __construct($template)
	{
		$this->setTemplate($template);
	}
	
	public function setDocument(DOMDocument $document)
	{
		$this->dom = $document;
	}
	
	public function getDocument()
	{
		if (!$this->dom instanceof DOMDocument)
			$this->setDocument(new \DOMDocument('1.0', 'utf-8'));
		return $this->dom;
	}
	
	/**
	 * Defines the template string or file.
	 *
	 * @param 	string 	$mixed	An HTML string or filename
	 * @return 	void
	 */
	public function setTemplate($mixed)
	{
		if (file_exists($mixed))
			return $this->getDocument()->loadHTMLFile($mixed);
			
		return $this->getDocument()->loadHTML($mixed);
	}
	
	public function applyData(array $data)
	{
		foreach ($data as $id=>$value) {
			$element = $this->getDocument()->getElementById($id);
			if (!$element instanceof DOMNode)
				continue;

			$this->applyDecoratorTo($element, $value);
		}
	}
	
	public function render(array $data)
	{	
		$this->applyData($data);
		return $this->getDocument()->saveXML();
	}
	
	protected function applyDecoratorTo(DOMNode $element, $value)
	{
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