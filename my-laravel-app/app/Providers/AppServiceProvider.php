<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // // coment this out if u dont  want to force laravel to use local https
        // if ($this->app->environment('local')) {
        //     URL::forceScheme('https');
        // }
        // and end here
    }

protected $policies = [
    PaymentMethod::class => PaymentMethodPolicy::class,
];

}
