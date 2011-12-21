<?php
require '../tests/bootstrap.php';


$template = new Respect\Template\Html('./template.html');
$template['body > h1'] = 'Hello World';
$template['#names']    = array('Pascutti', 'Moody', 'Ferreira', 'Gaigalas');
echo $template->render();