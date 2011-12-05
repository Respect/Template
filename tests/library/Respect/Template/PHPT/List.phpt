--TEST--
Simple DIV template test
--FILE--
<?php
require 'bootstrap.php';
$html = <<<HTML
<ul id="names"></ul>
HTML;
$parser = new Respect\Template\Parser($html);
$names  = array('Pascutti', 'Gaigalas', 'Rasmus', 'Wilson');
echo $parser->render(array('names'=>$names));
?>
--EXPECT--
<?xml version="1.0" standalone="yes"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html><body><ul id="names"><li value="0">Pascutti</li><li value="1">Gaigalas</li><li value="2">Rasmus</li><li value="3">Wilson</li></ul></body></html>