<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

use App\Events\ExampleMail;
use App\Events\OverbidEvent;
use App\Events\AdBidEvent;
use App\Listeners\SendExampleMail;
use App\Listeners\SendOverbidNotification;
use App\Listeners\SendAdBidNotification;
use App\Listeners\TestListener;

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
        OverbidEvent::class => [
            SendOverbidNotification::class,
        ],
        AdBidEvent::class => [
            SendAdBidNotification::class,
            TestListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
