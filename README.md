# Simple php templates parser

To be used with php files containing html mingled with php tags echoing vars

post.php:

```
<p><?php echo $text ?></p>
```

index.php:

```
<?php

$paths = [
    __DIR__."/../templates/",
    __DIR__."/../",
];
$parser = new \Templating\Parser($paths);

$parser->render('post',[
    'text' => 'hello worlds',
]);
```