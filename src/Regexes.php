<?php

namespace Templating;

class Regexes
{
    const OLD_VARIABLE_REGEX = '/\$\w+/';
    const VARIABLE_REGEX = '/({\$)([\w]+)(})/';
    const FUNCTION_REGEX = '/{[\w]+\(\)}/';
    const FLOW_REGEX = '/{\w+ \w+=\w+}/';
    const PROPERTY_REGEX = '/({\$)(\w+)(\-\>)(\w+)(})/';
    const STRING_REGEX = '/{z[\w]+}/';

    const FOREACH_REGEX = '/{foreach (\$[\w]+) as (\$[\w]+)}(.+){\/foreach}/s';
}