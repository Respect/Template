--TEST--
Simple DIV template test
--FILE--
<?php
require 'bootstrap.php';
$html = <<<HTML
<div id="test"></div>
HTML;
$parser = new Respect\Template\Parser($html);
echo $parser->render(array('test'=>'Hello World!'));
?>
--EXPECT--
<?xml version="1.0" standalone="yes"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html><body><div id="test">Hello World!</div></body></html>
