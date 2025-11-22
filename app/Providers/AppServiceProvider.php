<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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
    public function boot(UrlGenerator $url): void
    {
        if (env('APP_ENV') == 'production') {
            $url->forceScheme('https');
        }

        // Log all database queries
        DB::listen(function ($query) {
            $user = auth()->check() ? auth()->user()->id . ' (' . auth()->user()->email . ')' : 'guest';
            Log::channel('db')->info("User: {$user} - Query: {$query->sql} - Bindings: " . json_encode($query->bindings) . " - Time: {$query->time}ms");
        });
    }
}
