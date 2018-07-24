<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \App\Events\OrderApprovedEvent::class => [
            \App\Listeners\OrderApprovedListener::class
        ],
        \App\Events\OrderRejectedEvent::class => [
            \App\Listeners\OrderRejectedListener::class
        ],
        \App\Events\OrderSignedEvent::class => [
            \App\Listeners\OrderSignedListener::class
        ],
        \App\Events\OrderCreatedEvent::class => [
            \App\Listeners\OrderCreatedListener::class
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
