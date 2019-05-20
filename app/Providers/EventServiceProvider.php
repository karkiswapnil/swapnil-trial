<?php

namespace App\Providers;


use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\NewSubscriberEvent;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        NewSubscriberEvent::class=>[
            \App\Listeners\NewSubscriberListener::class,
            \App\Listeners\RegisterSubscriberToNewsletter::class,
            \App\Listeners\NotifyAdminViaSlack::class,
        ],
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
