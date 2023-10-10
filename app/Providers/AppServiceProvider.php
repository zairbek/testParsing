<?php

namespace App\Providers;

use App\Services\Parsers\ParserServiceInterface;
use App\Services\Parsers\XlsxParserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        ParserServiceInterface::class => XlsxParserService::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
