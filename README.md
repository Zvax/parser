# Simple php templates parser

To be used with php files containing html mingled with php tags echoing vars

post.php:

```html
<p><?php echo $text ?></p>
```

index.php:

<pre>
<?php

$paths = [
    __DIR__."/../templates/",
    __DIR__."/../",
];
$parser = new \Templating\Parser($paths);

$parser->render('post',[
    'text' => 'hello worlds',
]);
</pre>