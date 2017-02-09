<?php
namespace Templating\Exceptions;
use Exception;
class InvalidFileException extends Exception
{
    public function __construct($path, $code = 0, Exception $previous = null)
    {
        $message = "The path [ $path ] doesn't exist";
        parent::__construct($message, $code, $previous);
    }
}
