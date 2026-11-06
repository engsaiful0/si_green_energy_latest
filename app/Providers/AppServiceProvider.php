<?php

namespace App\Providers;

use App\Models\ProductCategory;
use App\Models\ServiceCategory;
use App\Models\SolutionCategory;
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
        View::composer(['layouts.frontend', 'components.frontend.*', 'frontend.*'], function ($view) {
            $view->with('site', SiteSettings::all())
                ->with('socialLinks', SiteSettings::socialLinks());
        });

        // Main menu: catalogs with their active categories as dropdown items.
        View::composer('components.frontend.header', function ($view) {
            $catalogs = [
                ['label' => 'Products', 'prefix' => 'products', 'model' => ProductCategory::class],
                ['label' => 'Solutions', 'prefix' => 'solutions', 'model' => SolutionCategory::class],
                ['label' => 'Services', 'prefix' => 'services', 'model' => ServiceCategory::class],
            ];

            foreach ($catalogs as &$catalog) {
                $catalog['categories'] = $catalog['model']::active()->ordered()->get(['id', 'name', 'slug']);
            }

            $view->with('navCatalogs', $catalogs);
        });
    }
}
