<?php declare(strict_types=1);

namespace Zvax\Templating\Exceptions;

use Exception;

class InvalidFileException extends Exception
{
    public function __construct(string $path, int $code = 0, Exception $previous = null)
    {
        $message = sprintf("The path [ %s ] doesn't exist", $path);
        parent::__construct($message, $code, $previous);
    }
}
