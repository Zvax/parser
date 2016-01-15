# Simple templates parser engine

The Engine is the parser, it will regex template strings and replace keys with values

The key definitions are shamelessly inspired by Danack/Jig.

```php
$templateString = '{first}{$second}{$obj->third}';
$engine = new Engine();
$obj = new stdClass();
$obj->third = 'sentence.';
$string = $engine->render($templateString,[
	'first' => 'This ',
	'second' => 'is a ',
	'obj' => $obj,
]);
// This is a sentence.
```

there is very basic support for loops:

```php
$string = $engine->render('{foreach $posts as $post}{$post}{/foreach}',[
            'posts' => [
                'post1',
                'post2',
            ],
        ]);
// post1post2
```

the posts array must be a 0 indexed container of strings