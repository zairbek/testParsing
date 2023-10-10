<?php

namespace App\Listeners;

use App\Events\FailedParsingEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class FailedParsingLogger
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
    public function handle(FailedParsingEvent $event): void
    {
        Log::alert(
            sprintf(
                'request id: ' .PHP_EOL. '%s',
                $event->fingerprint,
                $event->errorMessage
            )
        );
    }
}
