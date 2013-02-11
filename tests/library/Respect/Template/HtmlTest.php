<?php

namespace Respect\Template;

class HtmlTest extends \PHPUnit_Framework_TestCase
{
    public function testBasicTextReplacementRendering()
    {
        $template = new Html('<p>Test</p><div></div><p>Test</p>');
        $template['myplace']->text('div');
        $template['myplace'] = 'Hello';
        $this->assertContains('<p>Test</p><div>Hello</div><p>Test</p>', $template->render());
    }
    public function testBasicTextReplacementCompilation()
    {
        $template = new Html('<p>Test</p><div></div><p>Test</p>');
        $template['myplace']->text('div');
        $this->assertContains('<p>Test</p><div><?php echo $myplace;?></div><p>Test</p>', $template->compile());
    }
    public function testBasicTextReplacementStaticCompilation()
    {
        $template = new Html('<p>Test</p><div></div><p>Test</p>');
        $template['myplace']->text('div');
        $template['myplace'] = 'Hello';
        $this->assertContains('<p>Test</p><div>Hello</div><p>Test</p>', $template->compile());
    }
    public function testclearRendering()
    {
        $template = new Html('<p>Test</p><div>Hello!</div><p>Test</p>');
        $template['myplace']->clear('div');
        $this->assertContains('<p>Test</p><div></div><p>Test</p>', $template->render());
    }
    public function testclearCompiling()
    {
        $template = new Html('<p>Test</p><div>Hello!</div><p>Test</p>');
        $template['myplace']->clear('div');
        $this->assertContains('<p>Test</p><div></div><p>Test</p>', $template->compile());
    }
    public function testattrOperated()
    {
        $template = new Html('<p>Test</p><div></div><p>Test</p>');
        $template['myplace']->attr('title', 'div');
        $template['myplace'] = 'Hello';
        $this->assertContains('<p>Test</p><div title="Hello"></div><p>Test</p>', $template->render());
    }
    public function testattrCompiled()
    {
        $template = new Html('<p>Test</p><div></div><p>Test</p>');
        $template['myplace']->attr('title', 'div');
        $this->assertContains('<p>Test</p><div title="<?php echo $myplace;?>"></div><p>Test</p>', $template->compile());
    }
    public function testPopulate()
    {
        $template = new Html('<ul><li></li></ul><ol><li>Test</li></ol>');
        $template['myplace']->items('ul', 'li', Html::text());
        $template['myplace'] = array('one', 'two', 'three');
        $this->assertContains('<ul><li>one</li><li>two</li><li>three</li></ul><ol><li>Test</li></ol>', $template->render());
    }
    public function testPopulateKeys()
    {
        $template = new Html('<ul><li></li></ul><ol><li>Test</li></ol>');
        $template['myplace']->named('ul li', array(
            'text' => Html::text(),
            'identifier' => Html::attr('id')
        ));
        $template['myplace'] = array('text' => 'one', 'identifier' =>  133);
        $this->assertContains('<ul><li id="133">one</li></ul><ol><li>Test</li></ol>', $template->render());
    }
    public function testPopulateKeysStdClass()
    {
        $template = new Html('<ul><li></li></ul><ol><li>Test</li></ol>');
        $template['myplace']->named('ul li', array(
            'text' => Html::text(),
            'identifier' => Html::attr('id')
        ));
        $template['myplace'] = (object) array('text' => 'one', 'identifier' =>  133);
        $this->assertContains('<ul><li id="133">one</li></ul><ol><li>Test</li></ol>', $template->render());
    }
    public function testAttrKeys()
    {
        $template = new Html('<ul><li></li></ul><ol><li>Test</li></ol>');
        $template['myplace']->attrKeys('ul li', array('class', 'id'));
        $template['myplace'] = (object) array('id' => 'one', 'class' =>  'a');
        $this->assertContains('<ul><li id="one" class="a"></ul><ol><li>Test</li></ol>', $template->render());
    }
    public function testAttrKeysTranslation()
    {
        $template = new Html('<ul><li></li></ul><ol><li>Test</li></ol>');
        $template['myplace']->attrKeys('ul li', array('classfake' => 'class', 'idfake' => 'id'));
        $template['myplace'] = (object) array('idfake' => 'one', 'classfake' =>  'a');
        $this->assertContains('<ul><li id="one" class="a"></ul><ol><li>Test</li></ol>', $template->render());
    }
    public function testReadme1()
    {
        $data = array(
            'links' => array(
                array('http://github.com/Respect' => 'Respect on GitHub'),
                array('http://php.net' => 'PHP Website'),
                array('http://w3.org' => 'W3C Website'),
            )
        );

        $template = new Html('<ul><li><a href="" title="">Example Link</a></li></ul>'); //That HTML file above!
        $template['links']->items(
            'ul', 
            'li',
            Html::keys(Html::attr('href'))
                ->values(Html::text()->attr('title')));

        $html = $template->render($data); //See below!
        $this->assertContains('<ul><li href="http://github.com/Respect" title="Respect on GitHub">Respect on GitHub</li><li href="http://php.net" title="PHP Website">PHP Website</li><li href="http://w3.org" title="W3C Website">W3C Website</li></ul>', $html);
    }
    
}
