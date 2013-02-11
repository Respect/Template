Respect\Template [![Build Status](https://secure.travis-ci.org/Respect/Template.png)](http://travis-ci.org/Respect/Template)
================
 
What templates should be.

  * Uses **pure** HTML with no extra tags, attributes or markup at all.
  * Really fast, compiled, raw runtime.
  * Clean, nice, easy API.
  
Quick Start
-----------

Respect\Template uses plain HTML files as templates, let's look at this one:

```html
<h1>Title</h1>
<ul>
  <li><a href="" title="">Example Link</a></li>
</ul>
```

The PHP part handles every transformation on this template to get the final
markup:

```php
<?php

use Respect\Template\Html;

$data = array(
    'title' => 'Hello!',
    'links' => array(
        array('http://github.com/Respect' => 'Respect on GitHub'),
        array('http://php.net' => 'PHP Website'),
        array('http://w3.org' => 'W3C Website'),
    )
);

$template = new Html('template.html'); //That HTML file above!

$template['title']->text('h1');
$template['links']->items(
    'ul', //Parent
    'li', //Children
    Html::keys(
        Html::attr('href'))
    ->values(
        Html::text()->attr('title')
    )
);

$html = $template->render($data); //See below!
print $html;
```

Awesome output:

```html
<h1>Hello!</h1>
<ul>
  <li><a href="http://github.com/Respect" title="Respect on GitHub">Respect on GitHub</a></li>
  <li><a href="http://php.net" title="PHP Website">PHP Website</a></li>
  <li><a href="http://w3.org" title="W3C Website">W3C Website</a></li>
</ul>
```


License Information
===================

Copyright (c) 2009-2013, Alexandre Gomes Gaigalas.
All rights reserved.

Redistribution and use in source and binary forms, with or without modification,
are permitted provided that the following conditions are met:

* Redistributions of source code must retain the above copyright notice,
  this list of conditions and the following disclaimer.

* Redistributions in binary form must reproduce the above copyright notice,
  this list of conditions and the following disclaimer in the documentation
  and/or other materials provided with the distribution.

* Neither the name of Alexandre Gomes Gaigalas nor the names of its
  contributors may be used to endorse or promote products derived from this
  software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

