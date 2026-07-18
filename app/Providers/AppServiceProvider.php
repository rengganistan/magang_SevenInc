<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Models\ActivityLog;
use App\Models\Product;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        Paginator::useTailwind();

        // Share recent activity notifications to navbar component
        View::composer('components.navbar-dashboard', function ($view) {
            $notifications = ActivityLog::with('user')
                ->latest()
                ->take(7)
                ->get();

            $lowStockProducts = Product::whereColumn('stok', '<=', 'stok_minimum')
                ->where('stok', '>', 0)
                ->take(3)
                ->get();

            $view->with('navNotifications', $notifications);
            $view->with('navLowStockProducts', $lowStockProducts);
            $view->with('navSetting', Setting::first());
        });
    }
}
