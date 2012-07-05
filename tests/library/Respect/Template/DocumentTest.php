<?php
use Respect\Template\Html;
use Respect\Template\Document;

class DocumentTest extends PHPUnit_Framework_TestCase
{
    public function providerForDoctypes()
    {
        $class     = new ReflectionClass('Respect\Template\Html');
        $constants = $class->getConstants();
        $return    = array();
        foreach ($constants as $name=>$value)
            if (strpos($name, 'HTML') !== false)
                $return[] = array($value);

        return $return;
    }

    /**
     * @dataProvider providerForDoctypes
     */
    public function testSupportedDoctypes($doctype)
    {
        $this->markTestSkipped('Segfault in OSX 10.6, PHP 5.4.0, PHPUnit 3.6.11 and XDebug 2.2.0');
        $doc = new Document('<h1>A Test</h1>');
        $this->assertInstanceOf('Respect\Template\Document', $doc);
        $out = $doc->render(false, $doctype);
        $this->assertStringStartsWith($doctype, $out);
    }
}