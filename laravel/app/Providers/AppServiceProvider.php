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
        // 1. Fix CSS/JS styling issues on Render (Moved outside Mail::extend)
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        // 2. Register the Brevo Mail Driver
        Mail::extend('brevo', function (array $config) {
            return (new BrevoTransportFactory(
                app('events'), 
                app(HttpClientInterface::class)
            ))->create(
                new Dsn(
                    'brevo+api', 
                    'default', 
                    config('services.brevo.key')
                )
            );
        });
    }
}