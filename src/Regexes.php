<?php declare(strict_types=1);

namespace Zvax\Templating;

class Regexes
{
    public const OLD_VARIABLE_REGEX = '/\$\w+/';
    public const VARIABLE_REGEX = '/({\$)([\w]+)(})/';
    public const FUNCTION_REGEX = '/{[\w]+\(\)}/';
    public const FLOW_REGEX = '/{\w+ \w+=\w+}/';
    public const PROPERTY_REGEX = '/{\$(\w+)\-\>(\w+)}/';
    public const STRING_REGEX = '/{([\w]+)}/';
    public const FOREACH_REGEX = '/{foreach \$([\w]+) as \$([\w]+)}(.+){\/foreach}/s';
}
