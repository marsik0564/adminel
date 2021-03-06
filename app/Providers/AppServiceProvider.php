<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Admin\Category;
use App\Observers\AdminCategoryObserver;
use App\Models\Admin\Product;
use App\Observers\AdminProductObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        //date_default_timezone_set('Europe/Kiev');
        Category::observe(AdminCategoryObserver::class);
        Product::observe(AdminProductObserver::class);
    }
}
