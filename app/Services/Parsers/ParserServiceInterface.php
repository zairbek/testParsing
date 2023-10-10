<?php

namespace App\Services\Parsers;

use App\Exceptions\FileHeaderMissingException;
use App\Exceptions\UnableToReadFileException;

interface ParserServiceInterface
{
    /**
     * @throws UnableToReadFileException
     * @throws FileHeaderMissingException
     */
    public function load(string $absPath): void;
    public function getRowCount(): int;
    public function iterate(callable $callable): void;
}
