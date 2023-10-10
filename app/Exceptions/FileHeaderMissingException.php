<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class FileHeaderMissingException extends Exception
{
    public function __construct(string $message, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('В файле отсутствует заголовок по имени ' . $message, $code, $previous);
    }
}
