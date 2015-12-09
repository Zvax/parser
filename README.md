# Simple php templates parser

Basic usage: extend the ```Templating\Template``` abstract class with view objects.

Those view objects should present protected values that will be echoed. The templates should use ```$this``` to access the values of the view object.

```
class SiteView extends Template {
    protected $title = "default title";
    protected $body= "default body";
}
$siteView = new SiteView();
echo $siteView->render('path/to/template.php');
```

template:

```
<!DOCTYPE html>
<html>
<head>
	<title><?= $this->title ?></title>
</head>
<body><?= $this->body ?></body>
</html>
```