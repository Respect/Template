<?php
use Respect\Template\Html;
use Respect\Template\HtmlElement as H;

require __DIR__.'/../tests/bootstrap.php';

// Loading the template
$template = new Html('./cssZenGarden.html', '#lselect');

// Changing the TITLE element inside HEAD tag
$template['title']             = 'Respect\Template: The different template engine';

// Changing some text from the beginning of the BODY
$template['#pageHeader h1']    = 'Respect/Template';
$template['#pageHeader h2']    = 'HTML templates';
$template['#quickSummary .p1'] = 'This page is a simple example of a Respect\Template.';
$template['#quickSummary .p2'] = 'The content of this template is manipulated with CSS selectors and plain HTML.';

//Changing more elements, creating new ones, etc ....
$template['#preamble h3']      = 'What ninja skills should I have to use it?';
$template['#preamble .p1']     = H::div(
    H::p('It depends on what you do for living:'),
    H::dl(
        H::dt('PHP Developers'),
        H::dd('Very basic (really basic) knowledge of arrays and CSS selectors.'),
        
        H::dt('Front End Developers'),
        H::dd('Nothing')
    )
)->class('p1');
$template['#preamble .p2'] = 'The key concept to understand Respect\Template is simple: isolation of concerns. Backend developers should handle data and serve them properly while frontend developers should do the shinning stuff (CSS and Javascript).';
$template['#preamble .p3'] = 'Respect\Template aims to be easy to use by everyone, with minimum learning curve, minimal impact on the existing code and awesome as possible!';

$template['#lselect ul li:first-child'] = H::h1('I\'m first');

echo $template->render();