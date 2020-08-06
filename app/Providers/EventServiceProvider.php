<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            'SocialiteProviders\\Azure\\AzureExtendSocialite@handle',
            'SocialiteProviders\\Cognito\\CognitoExtendSocialite@handle'
        ],

        'Illuminate\Auth\Events\Login' => [
        'App\Listeners\LogSuccessfulLogin',
        ],

        'Illuminate\Auth\Events\Failed' => [
            'App\Listeners\LogFailedLogin',
        ],

        'Illuminate\Auth\Events\Logout' => [
            'App\Listeners\LogSuccessfulLogout',
        ],

        'App\Events\AccountCreated' => [
            'App\Listeners\RecordUsageTrackingAccountCreatedEvent'
        ],

        'App\Events\ModelChanged' => [
            'App\Listeners\AuditModelChanges'
        ],

        'App\Events\TokenAdded' => [
            'App\Listeners\AuditModelChanges'
        ],

        'App\Events\TokenRevoked' => [
            'App\Listeners\AuditModelChanges'
        ]

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
