# Simple php templates parser

To be used with php files containing html mingled with php tags echoing vars

template.php:

<pre>
<p><?php echo $text ?></p>
</pre>

index.php:

<pre>
<?php
$parser->render('template',[
    'text' => 'hello worlds',
]);
</pre>