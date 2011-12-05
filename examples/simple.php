<?php
require '../tests/bootstrap.php';

$view = new Respect\Template\Parser('./template.html');
$data = array(
	'names' => array('Santa', 'Pippin', 'Freakazoid')
);
echo $view->render($data);