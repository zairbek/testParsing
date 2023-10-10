<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class UnableToReadFileException extends Exception
{
    protected $message = 'Невозможно прочитать файл';
}
