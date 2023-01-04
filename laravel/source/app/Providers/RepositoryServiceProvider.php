<?php

namespace App\Providers;

use App\Repositories\CategoryRepository;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\ProductRepository;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\CollectionRepositoryInterface;
use App\Repositories\CollectionRepository;
use App\Repositories\Interfaces\SalesPromotionRepositoryInterface;
use App\Repositories\SalesPromotionRepository;
use App\Repositories\Interfaces\MenuRepositoryInterface;
use App\Repositories\MenuRepository;
use App\Repositories\Interfaces\BannerRepositoryInterface;
use App\Repositories\BannerRepository;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);

        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);

        $this->app->bind(CollectionRepositoryInterface::class, CollectionRepository::class);

        $this->app->bind(SalesPromotionRepositoryInterface::class, SalesPromotionRepository::class);

        $this->app->bind(MenuRepositoryInterface::class, MenuRepository::class);

        $this->app->bind(BannerRepositoryInterface::class, BannerRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
