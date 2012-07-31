<?php
namespace Respect\Template\Adapters;

use Respect\Template\Adapter;
use simple_html_dom as simple_html_dom;

abstract class AbstractAdapter
{
	/**
	 * @var simple_html_dom
	 */
	private $dom;
	protected $content;

	public function __construct($dom=null, $content = null)
	{
        if (!is_null($dom))
            $this->dom = $dom;

		if (!is_null($content))
			$this->content = $content;
	}

	abstract public function isValidData($data);
	abstract protected function getDomNode($data, $parent);

	public function adaptTo($parent, $content = null)
	{
		$content = ($content) ? $content : $this->content;
        return $this->getDomNode($content, $parent);
	}

	protected function createElement($parent, $name, $value = null)
	{
		$html = new simple_html_dom();
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
     * @return simple_html_dom
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
