<?php

namespace App\Providers;

use App\Events\ErrorInJobEvent;
use App\Events\FailedParsingEvent;
use App\Events\ParsingCompletedSuccessfullyEvent;
use App\Listeners\DeleteUploadedFileListener;
use App\Listeners\ErrorJobLogger;
use App\Listeners\FailedParsingLogger;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        FailedParsingEvent::class => [
            FailedParsingLogger::class,
            DeleteUploadedFileListener::class,
        ],
        ErrorInJobEvent::class => [
            ErrorJobLogger::class,
            DeleteUploadedFileListener::class,
        ],
        ParsingCompletedSuccessfullyEvent::class => [
            DeleteUploadedFileListener::class,
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
