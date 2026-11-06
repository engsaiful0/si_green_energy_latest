<?php

namespace App\Providers;

use App\Support\SiteSettings;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
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
        // Keep generated URLs without /public when the app is served from the project root.
        if ($root = config('app.url')) {
            URL::forceRootUrl(rtrim($root, '/'));
        }

        // Site-wide content (logos, contact details, social links) for the frontend layout and its partials.
        View::composer(['layouts.frontend', 'components.frontend.*', 'frontend.home.*'], function ($view) {
            $view->with('site', SiteSettings::all())
                ->with('socialLinks', SiteSettings::socialLinks());
        });
    }
}
