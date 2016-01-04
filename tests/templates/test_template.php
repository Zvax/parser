<?php /** @var \Tests\ExampleTemplate $this */ ?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<?= $this->body ?>
</body>
</html>

<?php


function makeLogger($param)
{
    $allowedLoggers =[
        'mysql' => 'MysqlLogger',
        'mongo' => 'MongoLogger',
        'txt' => 'TxtLogger',
        'redis' => 'RedisLogger',
        'memcached' => 'MemcachedLogger',
    ];
    if (array_key_exists($param,$allowedLoggers))
    {
        return new $allowedLoggers[$param];
    }
    throw new Exception('undefined logger');
}