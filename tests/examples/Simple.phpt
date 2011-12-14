--TEST--
Simple example of using the template tool
--FILE--
<?php
require 'bootstrap.php';
$html = <<<HTML
<h1>This is a Test</h1>

<ul id="items">
	<li>Item 1</li>
</ul>
HTML;
$html = new Respect\Template\Html($html);
$html['h1']     = 'Template Example';
$html['#items'] = array('ios', 'android');

echo $html;
?>
--EXPECT--
<?xml version="1.0" standalone="yes"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html><body><h1>Template Example</h1>

<ul id="items">
<li>ios</li><li>android</li></ul></body></html>