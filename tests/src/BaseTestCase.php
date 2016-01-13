<?php

namespace Tests;

class BaseTestCase extends \PHPUnit_Framework_TestCase
{
    public function __construct($name = null, array $data = [], $dataName = "")
    {
        parent::__construct($name, $data, $dataName);
    }
}