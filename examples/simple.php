<?php
namespace Respect\Template;
require '../tests/bootstrap.php';

$template              = new Html('./cssZenGarden.html');
$template['title']     = 'Respect\Template: A different template engine';
$template['#pageHeader h1'] = 'Respect\Template';
$template['#pageHeader h2'] = 'A different template engine';
echo $template->render();