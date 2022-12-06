<?php

namespace App\Providers;

use App\Models\Product;
use App\Repositories\BaseRepositoryInterface;
use App\Repositories\Eloquen\ProductRepository;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Support\ServiceProvider;

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
        //
    }

    /**
     */
    public function __construct() {
    }
}
