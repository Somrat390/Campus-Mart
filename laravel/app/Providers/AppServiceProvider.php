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
        \Illuminate\Support\Facades\URL::forceScheme('https');

        \Illuminate\Support\Facades\Mail::extend('brevo', function (array $config) {
            // Direct read from ENV to avoid cache issues
            $key = trim(env('BREVO_API_KEY'));
            
            return new \Symfony\Component\Mailer\Bridge\Brevo\Transport\BrevoApiTransport(
                $key,
                new \Symfony\Component\HttpClient\NativeHttpClient()
            );
        });
    }
}