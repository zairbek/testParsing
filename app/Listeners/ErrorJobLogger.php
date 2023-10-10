<?php

namespace App\Listeners;

use App\Events\ErrorInJobEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class ErrorJobLogger
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
    public function handle(ErrorInJobEvent $event): void
    {
        Log::error(
            sprintf(
                'request id: ' .PHP_EOL. '%s',
                $event->fingerprint,
                $event->errorMessage
            ),
            $event->stackTrace
        );
    }
}
