# Simple php templates parser

To be used with php files containing html mingled with php tags echoing vars

template.php:

```html
<p><?php echo $text ?></p>
```

index.php:

<pre>
<?php
$parser->render('template',[
    'text' => 'hello worlds',
]);
</pre>