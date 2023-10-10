<?php

namespace App\Listeners;

use App\Events\ErrorInJobEvent;
use App\Events\FailedParsingEvent;
use App\Events\ParsingCompletedSuccessfullyEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class DeleteUploadedFileListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(
        ParsingCompletedSuccessfullyEvent
        |FailedParsingEvent
        |ErrorInJobEvent
        $event): void
    {
        $absFilePath = Redis::get($event->fingerprint . '_filepath');

        if (file_exists($absFilePath)) {
            unlink($absFilePath);
        }
    }
}
