<?php namespace EAguad\Listeners;

use EAguad\Events\OrderApprovedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderRejectedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param OrderApprovedEvent $event
     * @return void
     */
    public function handle(OrderApprovedEvent $event)
    {
        //
    }
}
