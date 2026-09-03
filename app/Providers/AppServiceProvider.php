<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;

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
        if (app()->isProduction()) {
            URL::forceScheme('https');
        }

        RateLimiter::for('contact', function (Request $request) {
            return app()->isLocal()
                ? Limit::none()
                : Limit::perHour(3)->by($request->ip());
        });

        /*
            enables the following:
            preventLazyLoading
            preventSilentlyDiscardingAttributes
            preventAccessingMissingAttributes
        */
        Model::shouldBeStrict(! app()->isProduction());
        
        // in dev show throw LazyLoadingViolationException where you're missing with::('') values
        // Model::preventLazyLoading(! app()->isProduction());
    }
}
