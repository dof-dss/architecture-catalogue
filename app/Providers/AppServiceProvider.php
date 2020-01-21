<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// used for custom pagination
use Illuminate\Pagination\Paginator;

// used for custom validation
use Illuminate\Support\Facades\Validator;


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
        // add custom validation rules
        //
        Validator::extend('alpha_spaces', function ($attribute, $value) {
            return preg_match('/^[\pL\s]+$/u', $value);
        });

        Validator::extend('numeric_spaces', function ($attribute, $value) {
            return preg_match('/^[0-9\s]+$/u', $value);
        });

        Validator::extend('alpha_numeric_spaces', function ($attribute, $value) {
            return preg_match('/^[\pL0-9\s]+$/u', $value);
        });

        Validator::extend('alpha_numeric_spaces_punctuation', function ($attribute, $value) {
            return preg_match('/^[\pL0-9\s.,;:!?\'\"-]+$/u', $value);
        });

        //
        // use custom pagination view
        //
        Paginator::defaultView('vendor.pagination.govuk');

        Paginator::defaultSimpleView('view-name');
    }
}
