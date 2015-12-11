# Simple php templates parser

First usage, create plain objects or arrays and pass them to the renderer

```php
$renderer = new PhpTemplatesRenderer();

$view = new stdClass();
$view->body = 'default body';
$view->title = 'default title';

echo $renderer->render('path/to/template.php',$view);
echo $renderer->render('path/to/template.php',[
    'body' => 'default body from array',
    'title' => 'default title from array',
]);
```

Second usage: extend the ```Templating\Template``` abstract class with view objects

Those view objects should present protected values that will be echoed. The templates should use ```$this``` to access the values of the view object.

```php
class SiteView extends Template {
    protected $title = 'default title';
    protected $body= 'default body';
}
$siteView = new SiteView();
echo $siteView->render('path/to/template.php');
```

template:

```php
<!DOCTYPE html>
<html>
<head>
	<title><?= $this->title ?></title>
</head>
<body><?= $this->body ?></body>
</html>
```