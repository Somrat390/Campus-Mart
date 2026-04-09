<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Bridge\Brevo\Transport\BrevoTransportFactory;
use Symfony\Component\Mailer\Transport\Dsn;
use Symfony\Contracts\HttpClient\HttpClientInterface;

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
    public function boot(): void
    {
        // FORCE HTTPS for everything on Render
        \Illuminate\Support\Facades\URL::forceScheme('https');

        // Register Brevo Mail Driver
        \Illuminate\Support\Facades\Mail::extend('brevo', function (array $config) {
            
            // Use the API Transport directly to avoid the "Dispatcher" error
            return new \Symfony\Component\Mailer\Bridge\Brevo\Transport\BrevoApiTransport(
                config('services.brevo.key'),
                new \Symfony\Component\HttpClient\NativeHttpClient()
            );
        });
    }
}