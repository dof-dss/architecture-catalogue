<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\EntryRepository;
use App\Repositories\Interfaces\EntryRepositoryInterface;
use App\Repositories\StatusRepository;
use App\Repositories\Interfaces\StatusRepositoryInterface;
use App\Repositories\CategoriesRepository;
use App\Repositories\Interfaces\CategoriesRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            EntryRepositoryInterface::class,
            EntryRepository::class
        );
        $this->app->bind(
            StatusRepositoryInterface::class,
            StatusRepository::class
        );
        $this->app->bind(
            CategoriesRepositoryInterface::class,
            CategoriesRepository::class
        );
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
