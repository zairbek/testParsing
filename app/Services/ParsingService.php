<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\ParsingRequest;
use App\Jobs\ParsingJob;
use App\Services\Parsers\ParserServiceInterface;

class ParsingService
{
    public function parse(ParsingRequest $request)
    {
        /** @var ParserServiceInterface $parser */
        $parser = app(ParserServiceInterface::class);

        $file = $request->file('file')->store('parsingTmp');

        ParsingJob::dispatch($parser, $file, $request->fingerprint());
    }
}
