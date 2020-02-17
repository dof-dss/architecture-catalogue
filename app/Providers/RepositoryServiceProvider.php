<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// interfaces
use App\Repositories\Interfaces\EntryRepositoryInterface;
use App\Repositories\Interfaces\StatusRepositoryInterface;
use App\Repositories\Interfaces\CategoriesRepositoryInterface;
// repositories
use App\Repositories\Eloquent\EntryRepository;
use App\Repositories\Eloquent\StatusRepository;
use App\Repositories\Eloquent\CategoriesRepository;

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
