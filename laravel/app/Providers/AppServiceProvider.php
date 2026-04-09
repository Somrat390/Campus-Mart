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
            
            // Use the Native Client - this avoids the PSR-17 factory error
            $httpClient = new \Symfony\Component\HttpClient\NativeHttpClient();

            return (new \Symfony\Component\Mailer\Bridge\Brevo\Transport\BrevoTransportFactory(
                app('events'), 
                $httpClient
            ))->create(
                new \Symfony\Component\Mailer\Transport\Dsn(
                    'brevo+api', 
                    'default', 
                    config('services.brevo.key')
                )
            );
        });
    }
}