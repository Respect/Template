<?php
namespace Respect\Template;

use \DOMDocument;
use \DOMImplementation;
use \DOMXPath;
use \InvalidArgumentException as Argument;
use \UnexpectedValueException as Unexpected;
use Zend\Dom\Query as DomQuery;
/**
 * Normalizes HTMl into a valid DOM XML document.
 *
 * @package Respect\Template
 * @uses	Zend_Dom_Query
 * @author 	Augusto Pascutti <augusto@phpsp.org.br>
 */
class Document
{
	/**#@+
	* Constants to define the docnype of the document.
	*
	* @link http://www.w3.org/QA/2002/04/valid-dtd-list.html
	* @author nickl- <nick@jigsoft.co.za>
	*/
	const HTML_5 = <<<'HTML'
<!DOCTYPE html>
HTML;
	const HTML_4_01_STRICT = <<<'EOD'
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
EOD;
	const HTML_4_01_TRANSITIONAL = <<<'EOD'
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
EOD;
	const HTML_4_01_FRAMESET = <<<'EOD'
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN"
   "http://www.w3.org/TR/html4/frameset.dtd">
EOD;
	const XHTML_1_0_Strict = <<<'EOD'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
EOD;
	const XHTML_1_0_TRANSITIONAL = <<<'EOD'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
EOD;
	const XHTML_1_0_FRAMESET = <<<'EOD'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
EOD;
	const XHTML_1_1 = <<<'EOD'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
   "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
EOD;
	const XHTML_1_1_BASIC = <<<'EOD'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML Basic 1.1//EN"
    "http://www.w3.org/TR/xhtml-basic/xhtml-basic11.dtd">
EOD;
	const MATHML_2_0 = <<<'EOD'
<!DOCTYPE math PUBLIC "-//W3C//DTD MathML 2.0//EN"
	"http://www.w3.org/Math/DTD/mathml2/mathml2.dtd">
EOD;
	const MATHML_1_01 = <<<'EOD'
<!DOCTYPE math SYSTEM
	"http://www.w3.org/Math/DTD/mathml1/mathml.dtd">
EOD;
	const XHTML_MATHML_SVG = <<<'EOD'
<!DOCTYPE html PUBLIC
    "-//W3C//DTD XHTML 1.1 plus MathML 2.0 plus SVG 1.1//EN"
    "http://www.w3.org/2002/04/xhtml-math-svg/xhtml-math-svg.dtd">
EOD;
	const XHTML_MATHML_SVG_PROFILE_XHTML = <<<'EOD'
<!DOCTYPE html PUBLIC
    "-//W3C//DTD XHTML 1.1 plus MathML 2.0 plus SVG 1.1//EN"
    "http://www.w3.org/2002/04/xhtml-math-svg/xhtml-math-svg.dtd">
EOD;
	const XHTML_MATHML_SVG_PROFILE_SVG = <<<'EOD'
<!DOCTYPE svg:svg PUBLIC
    "-//W3C//DTD XHTML 1.1 plus MathML 2.0 plus SVG 1.1//EN"
    "http://www.w3.org/2002/04/xhtml-math-svg/xhtml-math-svg.dtd">
EOD;
	const SVG_1_1 = <<<'EOD'
<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN"
	"http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
EOD;
	const SVG_1_0 = <<<'EOD'
<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.0//EN"
	"http://www.w3.org/TR/2001/REC-SVG-20010904/DTD/svg10.dtd">
EOD;
	const SVG_1_1_BASIC = <<<'EOD'
<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1 Basic//EN"
	"http://www.w3.org/Graphics/SVG/1.1/DTD/svg11-basic.dtd">
EOD;
	const SVG_1_1_TINY = <<<'EOD'
<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1 Tiny//EN"
	"http://www.w3.org/Graphics/SVG/1.1/DTD/svg11-tiny.dtd">
EOD;
	const HTML_2_0 = <<<'EOD'
<!DOCTYPE html PUBLIC "-//IETF//DTD HTML 2.0//EN">
EOD;
	const HTML_3_2 = <<<'EOD'
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
EOD;
	const XHTML_1_0_BASIC = <<<'EOD'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML Basic 1.0//EN"
    "http://www.w3.org/TR/xhtml-basic/xhtml-basic10.dtd">
EOD;
	/**#@-*/

	/**
	 * @var DOMDocument
	 */
	private $dom;
	/**
	 * @var Zend_Dom_Query
	 */
	private $queryDocument;
	
	/**
	 * @param 	string	$htmlDocument 
	 */
	public function __construct($htmlDocument)
	{
		$this->dom = new DOMDocument();
		$this->dom->strictErrorChecking = false;
		$this->dom->loadHtml($htmlDocument);
	}
	
	/**
	 * @return DOMDocument
	 */
	public function getDom()
	{
		return $this->dom;
	}
	
	/**
	 * Replaces this dom content with the given array. 
	 * The array structure is: $array['Css Selector to Eelement'] = 'content';
	 * 
	 * @param 	array 	            $data
	 * @param   string[optional]    $decorator  Class to be used as decorator
	 * @return 	Respect\Template\Document
	 */
	public function decorate(array $data, $decorator = null)
	{
		foreach ($data as $selector=>$with) {
			$adapter   = Adapter::factory($this->getDom(), $with);
			$decorator = $decorator ?: $adapter->getDecorator();
			$query     = new Query($this, $selector);
			new $decorator($query, $adapter);
		}
		return $this;
	}
	
	/**
	 * Returns the XML representation of the current DOM tree.
	 *
	 * @param boolean   $beautiful - to pretty print or not
	 * @param string    $doctype   - the doctype to use
	 * @return 	string
	 */
	public function render($beautiful=false, $doctype='')
	{
		$this->dom->formatOutput = $beautiful;

		if ($doctype) {
			$doc = new DOMDocument();
			$doc->loadHTML($doctype);
			$dt = $doc->doctype;
			$di = new DOMImplementation();
			$dt = $di->createDocumentType($dt->name, $dt->publicId, $dt->systemId);
			$this->dom->replaceChild($dt, $this->dom->doctype);
		}

		return preg_replace('/<\?xml[\s\S]*\?>\n/', '', $this->dom->saveXML());
	}
	
	/**
	 * Returns XML to be parsed by CSS the selector.
	 * This will never be the final XML to be rendered.
	 *
	 * @return string
	 */
	public function getQueryDocument()
	{
		if (!$this->queryDocument)
			return $this->queryDocument = new DomQuery($this->render());

		return $this->queryDocument;
	}
}
