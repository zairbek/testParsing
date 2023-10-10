<?php

namespace App\Jobs;

use App\Events\ErrorInJobEvent;
use App\Events\FailedParsingEvent;
use App\Exceptions\FileHeaderMissingException;
use App\Exceptions\UnableToReadFileException;
use App\Services\Parsers\ParserServiceInterface;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class ParsingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $absPath;
    private string $fingerprint;
    private ParserServiceInterface $parser;

    public function __construct(ParserServiceInterface $parser, string $filePath, string $fingerprint)
    {
        $this->parser = $parser;
        $this->absPath = storage_path('app/' . $filePath);
        $this->fingerprint = $fingerprint;
    }

    public function handle(): void
    {
        try {
            $this->parser->load($this->absPath);
            $rowCount = $this->parser->getRowCount();

            Redis::set($this->fingerprint . '_filepath', $this->absPath);
            Redis::set($this->fingerprint . '_count', $rowCount - 1);
            Redis::set($this->fingerprint . '_done', 0);

            $this->parser->iterate(function (array $data) {
                InsertToDBJob::dispatch($data, $this->fingerprint);
            });
        } catch (FileHeaderMissingException|UnableToReadFileException $e) {
            FailedParsingEvent::dispatch($e->getMessage(), $this->fingerprint);
        } catch (Exception $e) {
            ErrorInJobEvent::dispatch($this->fingerprint, $e->getMessage(), $e->getTrace());
        }
    }
}
