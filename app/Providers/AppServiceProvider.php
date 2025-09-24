<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\SiteStatistic;

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
        // Share site statistics with all views
        View::composer('*', function ($view) {
            $view->with('totalVisits', SiteStatistic::getTotalVisits());
            $view->with('formattedVisits', SiteStatistic::formatVisitCount());
        });
    }
}
