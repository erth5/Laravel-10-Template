<?php

namespace App\Providers;

use App\ResourceRegistrar;
use AshAllenDesign\ConfigValidator\Services\ConfigValidator;
use Carbon\Carbon;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Routing\ResourceRegistrar as BaseResourceRegistrar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Request;
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
    public function boot(): void
    {
        $this->configureRateLimiting();

        /**
         * This action will block dusk tests, because
         * Dusk environement has own environement settings
         *  */
        // if (App::environment() === 'local') {
        //     (new ConfigValidator())
        //         ->run();
        // }

        /** Carbon Time Language */
        $lang = (Config::get('app.locale'));
        Carbon::setLocale($lang);

        /* Using view composer to set following variables globally */
        // view()->composer('*', function ($view) {
        //     $view->with('user', Auth::user());
        // });

        /**
         * Extend Resource Routes
         */
        $this->app->bind(BaseResourceRegistrar::class, ResourceRegistrar::class);
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('global', function () {
            return Limit::perMinute(200);
        });
        RateLimiter::for('downloads', function (Request $request) {
            return Limit::perMinute(10)->by($request->user()->id);
        });
    }
}
