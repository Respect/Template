<?php
namespace Respect\Template\Adapters;

//use \DOMNode;
//use \DOMDocument;
//use \UnexpectedValueException as Unexpected;
use Respect\Template\Adapter;
use \simple_html_dom as simple_html_dom;

abstract class AbstractAdapter
{
	/**
	 * @var DOMDocument
	 */
	private $dom;
	protected $content;

	public function __construct($dom=null, $content=null)//DOMDocument $dom=null, $content=null)
	{
        if (!is_null($dom))
            $this->dom = $dom;

		if (!is_null($content))
			$this->content = $content;
	}

	abstract public function isValidData($data);
	abstract protected function getDomNode($data, $parent);//DOMNode $parent);

	public function adaptTo($parent, $content=null) //DOMNode $parent, $content=null)
	{
		$content = ($content) ? $content : $this->content;
        return $this->getDomNode($content, $parent);
	}

	protected function createElement($parent, $name, $value=null)//DOMNode $parent, $name, $value=null)
	{
//		if (!$this->dom instanceof DOMDocument)
//			throw new Unexpected('No DOMDocument, cannot create new element');
		$html = new simple_html_dom();
//		return $html->load("<$name>$value</$name>")->firstChild();// $this->dom->createElement($name, $value);
		return $html->createElement($name, $value);
	}

	final protected function hasProperty($data, $name)
	{
		if (is_array($data))
			return isset($data[$name]);

		if (is_object($data))
			return isset($data->$name);

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
		if (is_array($data))
			return $data[$name];

		if (is_object($data))
			return $data->$name;

		return null;
	}
}