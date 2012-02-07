<?php
namespace Respect\Template;
use Respect\Template\HtmlElement as H;

ini_set('display_errors', 'On');
error_reporting(-1);
require __DIR__.'/../tests/bootstrap.php';

// Loading the template
$template = new Html('./cssZenGarden.html', '#lselect');

// Changing the TITLE element inside HEAD tag
$template['title']             = 'Respect\Template: The different template engine';

$template['text'] = new Selector('#preable .p2');

// Changing some text from the beginning of the BODY
$template['#pageHeader h1']    = $template['#pageHeader h2'];
$template['#pageHeader h2']    = 'A different template engine';
$template['#quickSummary .p1'] = 'This page is an example of what Respect\Template can do for you. We got the CSS Zen Garden HTML markup as our template and changed its content with PHP using simple CSS queries.';
$template['#quickSummary .p2'] = 'Design is for designers, let them create, style and keep their own HTML. With Respect\Template you can  grab this HTML and change anything you need, be it removing, adding or modifying exiting elements.';

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

echo $template->render();